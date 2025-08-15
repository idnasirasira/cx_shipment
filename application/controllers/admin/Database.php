<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Database extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load database library

        // Only allow access in development environment
        if (ENVIRONMENT !== 'development') {
            show_error('Database reset is only available in development environment.', 403, 'Access Denied');
        }

        $this->defaultLayout = 'layouts/app';
    }

    /**
     * Show database reset interface
     */
    public function index()
    {
        $data = [
            'sql_files' => $this->get_sql_files(),
            'last_reset' => $this->get_last_reset_time()
        ];

        $this->pageScripts = ['assets/js/database-reset.js'];
        $this->pageStyles = [];

        $this->loadView('admin/database/reset', 'Database Reset', $data);
    }

    /**
     * Execute database reset
     */
    public function reset()
    {
        // Verify this is a POST request
        if ($this->input->method() !== 'post') {
            show_error('Invalid request method', 405);
        }

        // Verify confirmation
        $confirmation = $this->input->post('confirmation');
        if ($confirmation !== 'RESET_DATABASE') {
            $response = [
                'success' => false,
                'message' => 'Invalid confirmation code. Please type "RESET_DATABASE" to confirm.'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
            return;
        }

        try {
            $result = $this->execute_sql_files();

            if ($result['success']) {
                $this->log_reset_time();
                $response = [
                    'success' => true,
                    'message' => 'Database reset completed successfully!',
                    'details' => $result['details']
                ];
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Database reset failed: ' . $result['error'],
                    'details' => $result['details']
                ];
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Database reset failed: ' . $e->getMessage()
            ];
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    /**
     * Get all SQL files from database directory
     */
    private function get_sql_files()
    {
        $sql_files = [];
        $database_path = FCPATH . 'database/';

        if (is_dir($database_path)) {
            $files = glob($database_path . '*.sql');

            foreach ($files as $file) {
                $filename = basename($file);
                $sql_files[] = [
                    'filename' => $filename,
                    'path' => $file,
                    'size' => filesize($file),
                    'modified' => date('Y-m-d H:i:s', filemtime($file))
                ];
            }

            // Sort by filename to ensure proper order
            usort($sql_files, function ($a, $b) {
                return strcmp($a['filename'], $b['filename']);
            });
        }

        return $sql_files;
    }

    /**
     * Execute all SQL files in order
     */
    private function execute_sql_files()
    {
        $sql_files = $this->get_sql_files();
        $results = [];
        $errors = [];

        if (empty($sql_files)) {
            return [
                'success' => false,
                'error' => 'No SQL files found in database directory'
            ];
        }

        // Load database
        $this->load->database();

        foreach ($sql_files as $file_info) {
            $filename = $file_info['filename'];
            $file_path = $file_info['path'];

            try {
                // Read SQL file content
                $sql_content = file_get_contents($file_path);

                if ($sql_content === false) {
                    throw new Exception("Could not read file: $filename");
                }

                // Split SQL content by semicolon to execute multiple statements
                $statements = $this->split_sql_statements($sql_content);

                foreach ($statements as $index => $statement) {
                    $statement = trim($statement);

                    if (!empty($statement)) {
                        $result = $this->db->query($statement);

                        if ($result === false) {
                            $error = $this->db->error();
                            throw new Exception("Error in $filename (statement " . ($index + 1) . "): " . $error['message']);
                        }
                    }
                }

                $results[] = [
                    'file' => $filename,
                    'status' => 'success',
                    'statements' => count(array_filter($statements))
                ];
            } catch (Exception $e) {
                $errors[] = $e->getMessage();
                $results[] = [
                    'file' => $filename,
                    'status' => 'error',
                    'error' => $e->getMessage()
                ];
            }
        }

        return [
            'success' => empty($errors),
            'error' => !empty($errors) ? implode('; ', $errors) : null,
            'details' => $results
        ];
    }

    /**
     * Split SQL content into individual statements
     */
    private function split_sql_statements($sql_content)
    {
        // Remove comments
        $sql_content = preg_replace('/--.*$/m', '', $sql_content);
        $sql_content = preg_replace('/\/\*.*?\*\//s', '', $sql_content);

        // Split by semicolon, but be careful with semicolons in strings
        $statements = [];
        $current_statement = '';
        $in_string = false;
        $string_delimiter = null;

        for ($i = 0; $i < strlen($sql_content); $i++) {
            $char = $sql_content[$i];

            if (!$in_string && ($char === "'" || $char === '"')) {
                $in_string = true;
                $string_delimiter = $char;
            } elseif ($in_string && $char === $string_delimiter) {
                // Check for escaped quotes
                if ($i > 0 && $sql_content[$i - 1] !== '\\') {
                    $in_string = false;
                    $string_delimiter = null;
                }
            } elseif (!$in_string && $char === ';') {
                $statements[] = trim($current_statement);
                $current_statement = '';
                continue;
            }

            $current_statement .= $char;
        }

        // Add the last statement if it's not empty
        if (!empty(trim($current_statement))) {
            $statements[] = trim($current_statement);
        }

        return $statements;
    }

    /**
     * Get last reset time from cache
     */
    private function get_last_reset_time()
    {
        $this->load->driver('cache', ['adapter' => 'file']);
        return $this->cache->get('database_last_reset');
    }

    /**
     * Log reset time to cache
     */
    private function log_reset_time()
    {
        $this->load->driver('cache', ['adapter' => 'file']);
        $this->cache->save('database_last_reset', date('Y-m-d H:i:s'), 86400); // Cache for 24 hours
    }
}
