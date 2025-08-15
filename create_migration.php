<?php

if (php_sapi_name() !== 'cli') {
    exit("CLI only\n");
}

if ($argc < 2) {
    echo "Usage: php create_migration.php <nama_migration>\n";
    exit;
}

$name = preg_replace('/[^a-z0-9_]/i', '_', strtolower($argv[1]));
$timestamp = date('Y_m_d_His');
$filename = __DIR__ . "/database/{$timestamp}_{$name}.sql";

if (!is_dir(__DIR__ . '/database')) {
    mkdir(__DIR__ . '/database', 0777, true);
}

$template = <<<SQL
-- Migration: {$name}
-- Created at: {$timestamp}

-- SQL here
SQL;

if (file_put_contents($filename, $template) !== false) {
    echo "Migration file created: {$filename}\n";
} else {
    echo "Gagal membuat file migration.\n";
}
