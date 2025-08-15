<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Configuration Template
|--------------------------------------------------------------------------
| This file shows all available configuration options with explanations.
| Copy this file and customize it for your specific environment.
|
| Available environments:
| - development.php (for local development)
| - testing.php (for automated testing)
| - production.php (for production deployment)
|
*/

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================

$db['default'] = array(
    // Database connection settings
    'dsn'          => '',                    // Full DSN string (optional)
    'hostname'     => 'localhost',           // Database server hostname
    'username'     => '',                    // Database username
    'password'     => '',                    // Database password
    'database'     => '',                    // Database name
    'dbdriver'     => 'mysqli',              // Database driver (mysqli, pdo, sqlite3, etc.)
    'dbprefix'     => '',                    // Table prefix (optional)

    // Connection settings
    'pconnect'     => FALSE,                 // Use persistent connections
    'db_debug'     => TRUE,                  // Show database errors (FALSE for production)
    'cache_on'     => FALSE,                 // Enable query caching
    'cachedir'     => '',                    // Cache directory path

    // Character set and collation
    'char_set'     => 'utf8',                // Character set
    'dbcollat'     => 'utf8_general_ci',     // Collation

    // Advanced settings
    'swap_pre'     => '',                    // Table prefix swap
    'encrypt'      => FALSE,                 // Use encrypted connections
    'compress'     => FALSE,                 // Use compression
    'stricton'     => FALSE,                 // Enable strict mode
    'failover'     => array(),               // Failover configuration
    'save_queries' => TRUE,                  // Save executed queries (FALSE for production)
);

// ============================================================================
// APPLICATION CONFIGURATION
// ============================================================================

// URL and routing settings
$config['base_url'] = '';                    // Your application's base URL
$config['index_page'] = '';                  // Index file name (empty for clean URLs)
$config['uri_protocol'] = 'REQUEST_URI';     // URI protocol (REQUEST_URI, QUERY_STRING, PATH_INFO)
$config['url_suffix'] = '';                  // URL suffix (e.g., .html)

// Language and character settings
$config['language'] = 'english';             // Default language
$config['charset'] = 'UTF-8';                // Character encoding

// ============================================================================
// DEBUG AND LOGGING CONFIGURATION
// ============================================================================

// Debug settings
$config['log_threshold'] = 4;                // Logging level (0-4)
// 0 = Disables logging
// 1 = Error Messages (including PHP errors)
// 2 = Debug Messages
// 3 = Informational Messages
// 4 = All Messages

$config['display_errors'] = TRUE;            // Show errors in browser (FALSE for production)

// ============================================================================
// EMAIL CONFIGURATION
// ============================================================================

// Email protocol settings
$config['protocol'] = 'mail';                // Email protocol (mail, sendmail, smtp)
$config['smtp_host'] = '';                   // SMTP server hostname
$config['smtp_port'] = 25;                   // SMTP server port
$config['smtp_user'] = '';                   // SMTP username
$config['smtp_pass'] = '';                   // SMTP password
$config['smtp_crypto'] = '';                 // SMTP encryption (ssl, tls)
$config['mailtype'] = 'text';                // Email type (text, html)
$config['charset'] = 'utf-8';                // Email character set
$config['newline'] = "\r\n";                 // Email newline character

// ============================================================================
// CACHE CONFIGURATION
// ============================================================================

// Cache settings
$config['cache_dir'] = APPPATH . 'cache/';   // Cache directory
$config['cache_default_expires'] = 7200;     // Default cache expiration (seconds)

// ============================================================================
// SESSION CONFIGURATION
// ============================================================================

// Session settings
$config['sess_driver'] = 'files';            // Session driver (files, database, redis, memcached)
$config['sess_cookie_name'] = 'ci_session';  // Session cookie name
$config['sess_expiration'] = 7200;           // Session timeout (seconds)
$config['sess_save_path'] = APPPATH . 'sessions/'; // Session storage path
$config['sess_match_ip'] = FALSE;            // Match session by IP (TRUE for production)
$config['sess_time_to_update'] = 300;        // Session update time (seconds)
$config['sess_regenerate_destroy'] = FALSE;  // Regenerate session ID

// ============================================================================
// SECURITY CONFIGURATION
// ============================================================================

// Encryption settings
$config['encryption_key'] = '';              // Encryption key (32 characters)

// CSRF protection settings
$config['csrf_protection'] = FALSE;          // Enable CSRF protection (TRUE for production)
$config['csrf_token_name'] = 'csrf_token';   // CSRF token name
$config['csrf_cookie_name'] = 'csrf_cookie'; // CSRF cookie name
$config['csrf_expire'] = 7200;               // CSRF token expiration (seconds)
$config['csrf_regenerate'] = TRUE;           // Regenerate CSRF token
$config['csrf_exclude_uris'] = array();      // URIs to exclude from CSRF protection

// ============================================================================
// UPLOAD CONFIGURATION
// ============================================================================

// Upload settings
$config['upload_path'] = './uploads/';       // Upload directory
$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx'; // Allowed file types
$config['max_size'] = 2048;                  // Maximum file size (KB)
$config['max_width'] = 0;                    // Maximum image width (0 = no limit)
$config['max_height'] = 0;                   // Maximum image height (0 = no limit)

// ============================================================================
// CUSTOM CONFIGURATION
// ============================================================================

// Custom settings for your application
$config['dev_mode'] = TRUE;                  // Development mode flag
$config['show_profiler'] = TRUE;             // Show CodeIgniter profiler
$config['enable_debug_toolbar'] = TRUE;      // Enable debug toolbar

// ============================================================================
// ENVIRONMENT-SPECIFIC SETTINGS
// ============================================================================

/*
|--------------------------------------------------------------------------
| Environment-Specific Configuration Examples
|--------------------------------------------------------------------------
|
| Development Environment:
| - Enable all debugging
| - Show errors
| - Use local database
| - Relaxed security
|
| Production Environment:
| - Disable debugging
| - Hide errors
| - Use production database
| - Strict security
|
| Testing Environment:
| - Minimal logging
| - Use test database
| - Disable CSRF
|
*/

// Example: Development-specific overrides
if (ENVIRONMENT === 'development') {
    // Override settings for development
    $config['log_threshold'] = 4;
    $config['display_errors'] = TRUE;
    $config['show_profiler'] = TRUE;
    $config['csrf_protection'] = FALSE;
}

// Example: Production-specific overrides
if (ENVIRONMENT === 'production') {
    // Override settings for production
    $config['log_threshold'] = 1;
    $config['display_errors'] = FALSE;
    $config['show_profiler'] = FALSE;
    $config['csrf_protection'] = TRUE;
    $config['sess_match_ip'] = TRUE;
}

// Example: Testing-specific overrides
if (ENVIRONMENT === 'testing') {
    // Override settings for testing
    $config['log_threshold'] = 0;
    $config['display_errors'] = FALSE;
    $config['show_profiler'] = FALSE;
    $config['csrf_protection'] = FALSE;
}
