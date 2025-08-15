# Configuration Guide

This guide explains all configuration values in the CodeIgniter 3 project and how to customize them for your local environment.

## 📁 Configuration Structure

```
application/config/
├── environments/
│   ├── development.php    # Development environment settings
│   ├── testing.php        # Testing environment settings
│   └── production.php     # Production environment settings
├── environment.php        # Environment detection and loading
├── config.php            # Main application configuration
├── database.php          # Database configuration
├── autoload.php          # Auto-loading configuration
└── routes.php            # URL routing configuration
```

## 🔧 Environment Configuration

### Environment Detection

The application automatically detects the environment using:

1. **Environment Variable**: `CI_ENV=development`
2. **`.env` File**: Contains `CI_ENV=development`
3. **Default**: Falls back to `development`

### Setting Your Environment

#### Option 1: Environment Variable
```bash
export CI_ENV=development
```

#### Option 2: .env File (Recommended)
```bash
# Copy the example file
cp env.example .env

# Edit .env file
CI_ENV=development
```

## 📋 Configuration Values Reference

### Application Configuration (`config.php`)

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `base_url` | Your application's base URL | `''` | `'http://localhost/cx_shipment/'` |
| `index_page` | Index file name (empty for clean URLs) | `'index.php'` | `''` |
| `uri_protocol` | URI protocol for URL parsing | `'REQUEST_URI'` | `'REQUEST_URI'` |
| `url_suffix` | URL suffix (e.g., .html) | `''` | `''` |
| `language` | Default language | `'english'` | `'english'` |
| `charset` | Character encoding | `'UTF-8'` | `'UTF-8'` |
| `log_threshold` | Logging level (0-4) | `0` | `4` (development) |
| `display_errors` | Show errors in browser | `FALSE` | `TRUE` (development) |

### Database Configuration (`database.php`)

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `hostname` | Database server hostname | `'localhost'` | `'localhost'` |
| `username` | Database username | `''` | `'root'` |
| `password` | Database password | `''` | `'your_password'` |
| `database` | Database name | `''` | `'cx_shipment_dev'` |
| `dbdriver` | Database driver | `'mysqli'` | `'mysqli'` or `'sqlite3'` |
| `dbprefix` | Table prefix | `''` | `'ci_'` |
| `db_debug` | Show database errors | `TRUE` | `FALSE` (production) |
| `cache_on` | Enable query caching | `FALSE` | `TRUE` (production) |

### Email Configuration

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `protocol` | Email protocol | `'mail'` | `'smtp'` |
| `smtp_host` | SMTP server hostname | `''` | `'smtp.gmail.com'` |
| `smtp_port` | SMTP server port | `25` | `587` |
| `smtp_user` | SMTP username | `''` | `'your_email@gmail.com'` |
| `smtp_pass` | SMTP password | `''` | `'your_app_password'` |
| `smtp_crypto` | SMTP encryption | `''` | `'tls'` |

### Session Configuration

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `sess_driver` | Session storage driver | `'files'` | `'files'` or `'database'` |
| `sess_cookie_name` | Session cookie name | `'ci_session'` | `'ci_session'` |
| `sess_expiration` | Session timeout (seconds) | `7200` | `7200` (2 hours) |
| `sess_save_path` | Session storage path | `''` | `APPPATH . 'sessions/'` |
| `sess_match_ip` | Match session by IP | `FALSE` | `TRUE` (production) |

### Security Configuration

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `encryption_key` | Encryption key (32 chars) | `''` | `'your-32-char-key-here'` |
| `csrf_protection` | Enable CSRF protection | `FALSE` | `TRUE` (production) |
| `csrf_token_name` | CSRF token name | `'csrf_token'` | `'csrf_token'` |
| `csrf_cookie_name` | CSRF cookie name | `'csrf_cookie'` | `'csrf_cookie'` |

### Upload Configuration

| Setting | Description | Default | Example |
|---------|-------------|---------|---------|
| `upload_path` | Upload directory | `'./uploads/'` | `'./uploads/'` |
| `allowed_types` | Allowed file types | `'gif\|jpg\|jpeg\|png'` | `'gif\|jpg\|jpeg\|png\|pdf'` |
| `max_size` | Maximum file size (KB) | `0` | `2048` (2MB) |
| `max_width` | Maximum image width | `0` | `1920` |
| `max_height` | Maximum image height | `0` | `1080` |

## 🛠️ Customizing Configuration

### For Individual Developers

1. **Copy environment template:**
   ```bash
   cp env.example .env
   ```

2. **Edit .env file with your settings:**
   ```bash
   # Environment
   CI_ENV=development
   
   # Database
   DB_HOST=localhost
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   DB_DATABASE=your_database_name
   
   # Application
   BASE_URL=http://localhost/cx_shipment/
   ENCRYPTION_KEY=your-32-character-encryption-key
   ```

3. **Customize environment file (optional):**
   ```bash
   # Copy and customize development environment
   cp application/config/environments/development.php application/config/environments/development_local.php
   ```

### For Team-Wide Changes

1. **Update environment files:**
   - Edit `application/config/environments/development.php`
   - Edit `application/config/environments/production.php`
   - Edit `application/config/environments/testing.php`

2. **Update env.example:**
   - Add new variables to `env.example`
   - Document the new configuration options

3. **Update documentation:**
   - Add new settings to this guide
   - Update `SETUP.md` if needed

## 📝 Configuration Examples

### Development Environment

```php
// application/config/environments/development.php

// Database - Local development
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'database' => 'cx_shipment_dev',
    'dbdriver' => 'mysqli',
    'db_debug' => TRUE,  // Show database errors
);

// Application - Local development
$config['base_url'] = 'http://localhost/cx_shipment/';
$config['index_page'] = '';  // Clean URLs
$config['log_threshold'] = 4;  // Log everything
$config['display_errors'] = TRUE;  // Show errors

// Email - Local testing (MailHog)
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = 1025;

// Security - Relaxed for development
$config['csrf_protection'] = FALSE;
$config['encryption_key'] = 'dev-key-123456789012345678901234';
```

### Production Environment

```php
// application/config/environments/production.php

// Database - Production server
$db['default'] = array(
    'hostname' => 'production-db-server.com',
    'username' => 'prod_user',
    'password' => 'strong_password',
    'database' => 'cx_shipment_prod',
    'dbdriver' => 'mysqli',
    'db_debug' => FALSE,  // Hide database errors
    'cache_on' => TRUE,   // Enable query caching
);

// Application - Production domain
$config['base_url'] = 'https://yourdomain.com/';
$config['index_page'] = '';
$config['log_threshold'] = 1;  // Only log errors
$config['display_errors'] = FALSE;  // Hide errors

// Email - Production SMTP
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.yourdomain.com';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';

// Security - Strict for production
$config['csrf_protection'] = TRUE;
$config['encryption_key'] = 'strong-32-character-production-key';
```

### Testing Environment

```php
// application/config/environments/testing.php

// Database - SQLite for testing
$db['default'] = array(
    'database' => APPPATH . 'tests/mocks/database/ci_test.sqlite',
    'dbdriver' => 'sqlite3',
    'db_debug' => FALSE,
    'save_queries' => FALSE,
);

// Application - Testing
$config['base_url'] = 'http://localhost/';
$config['index_page'] = '';
$config['log_threshold'] = 0;  // No logging
$config['display_errors'] = FALSE;

// Security - Minimal for testing
$config['csrf_protection'] = FALSE;
$config['encryption_key'] = 'testing-key-123456789012345678901234';
```

## 🔍 Helper Functions

The project includes helper functions for easy configuration access:

```php
// Get environment variable
$db_host = env('DB_HOST', 'localhost');

// Get configuration value
$base_url = config('base_url');

// Check environment
if (is_development()) {
    // Development-specific code
}

if (is_production()) {
    // Production-specific code
}

// Asset URLs with cache busting
echo asset_url('css/style.css');

// Upload URLs
echo upload_url('images/photo.jpg');
```

## 🚨 Important Notes

### Security Considerations

1. **Never commit sensitive data:**
   - Database passwords
   - Encryption keys
   - API keys
   - SMTP credentials

2. **Use environment variables:**
   - Store sensitive data in `.env` file
   - Keep `.env` in `.gitignore`

3. **Different keys per environment:**
   - Use different encryption keys for each environment
   - Use different database credentials

### Performance Considerations

1. **Development:**
   - Enable debug mode
   - Show all errors
   - Log everything
   - Disable caching

2. **Production:**
   - Disable debug mode
   - Hide errors
   - Enable caching
   - Optimize database queries

### Database Considerations

1. **Development:**
   - Use local database
   - Enable query debugging
   - Save queries for analysis

2. **Testing:**
   - Use SQLite or test database
   - Disable query saving
   - Clean database between tests

3. **Production:**
   - Use production database
   - Disable query debugging
   - Enable query caching

## 📚 Additional Resources

- [CodeIgniter 3 Configuration Documentation](https://codeigniter.com/userguide3/libraries/config.html)
- [CodeIgniter 3 Database Documentation](https://codeigniter.com/userguide3/database/index.html)
- [CodeIgniter 3 Email Documentation](https://codeigniter.com/userguide3/libraries/email.html)
- [CodeIgniter 3 Session Documentation](https://codeigniter.com/userguide3/libraries/sessions.html)
