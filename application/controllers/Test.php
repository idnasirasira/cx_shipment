<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Only allow access in development environment
        if (ENVIRONMENT !== 'development') {
            show_error('Database reset is only available in development environment.', 403, 'Access Denied');
        }
    }

    public function index()
    {
        echo "<h1>Environment Configuration Test</h1>";

        // Test 1: Check environment
        echo "<h2>1. Environment Detection</h2>";
        echo "Current Environment: " . ENVIRONMENT . "<br>";
        echo "Environment File: " . APPPATH . 'config/environments/' . ENVIRONMENT . '.php<br>';
        echo "File Exists: " . (file_exists(APPPATH . 'config/environments/' . ENVIRONMENT . '.php') ? 'YES' : 'NO') . "<br><br>";

        // Test 2: Check database configuration
        echo "<h2>2. Database Configuration</h2>";
        if (isset($this->db)) {
            echo "Database Library Loaded: YES<br>";
            echo "Database Hostname: " . $this->db->hostname . "<br>";
            echo "Database Name: " . $this->db->database . "<br>";
            echo "Database Username: " . $this->db->username . "<br>";
            echo "Database Port: " . $this->db->port . "<br>";

            // Test database connection
            echo "<h3>3. Database Connection Test</h3>";
            if ($this->db->simple_query('SELECT 1')) {
                echo "Database Connection: SUCCESS<br>";
            } else {
                echo "Database Connection: FAILED<br>";
                echo "Error: " . $this->db->error()['message'] . "<br>";
            }
        } else {
            echo "Database Library Loaded: NO<br>";
        }

        // Test 3: Check loaded configs
        echo "<h2>4. Loaded Configuration Files</h2>";
        echo "Autoloaded Configs: " . implode(', ', array_keys($this->config->config)) . "<br>";

        // Test 4: Show current database config array
        echo "<h2>5. Current Database Config Array</h2>";
        echo "<pre>";
        print_r($this->db->db_debug);
        echo "</pre>";

        // Test Database Connection
        echo "<h2>6. Database Connection Test</h2>";
        $this->load->database();
        if ($this->db->simple_query('SELECT 1')) {
            echo "Database Connection: SUCCESS<br>";
        } else {
            echo "Database Connection: FAILED<br>";
            echo "Error: " . $this->db->error()['message'] . "<br>";
        }
    }
}
