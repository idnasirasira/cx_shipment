<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Environment Configuration Loader
|--------------------------------------------------------------------------
| This file automatically detects the environment and loads the appropriate
| configuration files. It supports development, testing, and production environments.
|
*/

// Environment should already be defined in index.php
// This is just a fallback in case it's not
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}

// Load environment-specific configuration
$env_file = APPPATH . 'config/environments/' . ENVIRONMENT . '.php';
if (file_exists($env_file)) {
    include $env_file;
} else {
    // Fallback to default configuration
    log_message('error', 'Environment configuration file not found: ' . $env_file);
}


// Set error reporting based on environment
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>=')) {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_WARNING);
        }
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1);
}
