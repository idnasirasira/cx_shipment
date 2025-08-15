# CodeIgniter 3 Project Setup Guide

This guide will help you set up the project for your local development environment.

## Prerequisites

- PHP 7.0 or higher
- MySQL/MariaDB or SQLite
- Web server (Apache/Nginx) or PHP built-in server
- Composer (optional, for dependency management)

## Quick Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd cx_shipment
```

### 2. Set Up Environment Configuration

Copy the example environment file and customize it for your setup:

```bash
cp env.example .env
```

Edit the `.env` file with your local settings:

```bash
# Environment (development, testing, production)
CI_ENV=development

# Database Configuration
DB_HOST=localhost
DB_USERNAME=root
DB_PASSWORD=your_password
DB_DATABASE=cx_shipment_dev
DB_DRIVER=mysqli

# Application Configuration
BASE_URL=http://localhost/cx_shipment/
ENCRYPTION_KEY=your-32-character-encryption-key-here
```

### 3. Create Required Directories

```bash
# Create upload directories
mkdir -p uploads
mkdir -p uploads/test

# Create session directory
mkdir -p application/sessions

# Set proper permissions (Unix/Linux/macOS)
chmod 755 uploads
chmod 755 application/sessions
chmod 755 application/cache
```

### 4. Database Setup

#### Option A: MySQL/MariaDB

1. Create a new database:

```sql
CREATE DATABASE cx_shipment_dev CHARACTER SET utf8 COLLATE utf8_general_ci;
```

2. Import the database schema (if available):

```bash
mysql -u root -p cx_shipment_dev < database/schema.sql
```

#### Option B: SQLite (for testing)

The testing environment is configured to use SQLite by default.

### 5. Configure .htaccess

The project includes different `.htaccess` files for different environments:

#### For Development:

```bash
cp .htaccess.development .htaccess
```

#### For Production:

```bash
cp .htaccess.production .htaccess
```

#### Default .htaccess:

The main `.htaccess` file is configured for general use and includes:

- URL rewriting for clean URLs
- Security headers
- Compression and caching
- File access control
- PHP settings optimization

### 6. Start Development Server

#### Using PHP Built-in Server

```bash
php -S localhost:8000
```

#### Using Apache/Nginx

Configure your web server to point to the project directory.

### 7. Test URL Rewriting

After setting up your environment, test that URL rewriting is working:

#### Test URLs (should work without index.php):

- **Homepage**: `http://localhost/cx_shipment/`
- **Welcome page**: `http://localhost/cx_shipment/welcome`
- **Welcome index**: `http://localhost/cx_shipment/welcome/index`
- **Test page**: `http://localhost/cx_shipment/test`
- **Test hello**: `http://localhost/cx_shipment/test/hello`
- **Test with params**: `http://localhost/cx_shipment/test/params/123/abc`

#### If URLs don't work:

1. **Check .htaccess**: Make sure the `.htaccess` file is in the project root
2. **Check mod_rewrite**: Ensure Apache mod_rewrite is enabled
3. **Check permissions**: Ensure `.htaccess` is readable by the web server
4. **Check environment**: Verify your environment is set correctly

#### Enable mod_rewrite on Apache:

```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# macOS (MAMP)
# mod_rewrite should be enabled by default

# Windows (XAMPP)
# mod_rewrite should be enabled by default
```

## Environment Configuration

### Available Environments

- **development**: For local development with debug enabled
- **testing**: For automated testing and CI/CD
- **production**: For production deployment with security optimizations

## .htaccess Configuration

### Available .htaccess Files

- **`.htaccess`** - Main configuration with balanced security and performance
- **`.htaccess.development`** - Relaxed security for easier debugging
- **`.htaccess.production`** - Strict security and performance optimizations

### Key Features

#### URL Rewriting

- Clean URLs without `index.php`
- Automatic trailing slash handling
- Authorization header support

#### Security Headers

- X-Content-Type-Options: nosniff
- X-Frame-Options: DENY (production) / SAMEORIGIN (development)
- X-XSS-Protection: 1; mode=block
- Content Security Policy
- HSTS (HTTP Strict Transport Security) in production

#### Performance Optimizations

- Gzip compression for text files
- Browser caching with appropriate expiration times
- PHP settings optimization

#### File Access Control

- Protection of sensitive files (.env, composer files, logs)
- Prevention of PHP execution in uploads directory
- Access control for application and system directories

#### Environment-Specific Settings

**Development:**

- Relaxed security for easier debugging
- Error display enabled
- Higher memory and upload limits
- Shorter cache times for quick development

**Production:**

- Strict security headers
- Error display disabled
- Optimized memory and upload limits
- Aggressive caching for performance
- Additional security measures

### Environment Detection

The application automatically detects the environment using:

1. `CI_ENV` environment variable
2. `.env` file in the project root
3. Defaults to `development` if none is set

### Configuration Files

- `application/config/environments/development.php` - Development settings
- `application/config/environments/testing.php` - Testing settings
- `application/config/environments/production.php` - Production settings

## Helper Functions

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

// Asset URLs with cache busting
echo asset_url('css/style.css');

// Upload URLs
echo upload_url('images/photo.jpg');
```

## Team Development Workflow

### 1. Initial Setup

Each team member should:

1. Clone the repository
2. Copy `env.example` to `.env`
3. Customize `.env` for their local environment
4. Create required directories
5. Set up their local database

### 2. Configuration Changes

When adding new configuration options:

1. Add the option to all environment files (`development.php`, `testing.php`, `production.php`)
2. Update `env.example` with the new variable
3. Document the change in this file

### 3. Database Changes

When making database schema changes:

1. Create a migration file
2. Test in development environment
3. Update the schema file for new team members

## Troubleshooting

### Common Issues

#### 1. "No direct script access allowed" Error

Make sure you're accessing the application through the web server, not directly via file system.

#### 2. Database Connection Error

- Check your database credentials in `.env`
- Ensure the database exists
- Verify database server is running

#### 3. Permission Errors

On Unix/Linux/macOS systems, ensure proper permissions:

```bash
chmod 755 uploads
chmod 755 application/sessions
chmod 755 application/cache
```

#### 4. Environment Not Detected

- Check that `.env` file exists in project root
- Verify `CI_ENV` is set correctly
- Ensure `application/config/environments/` directory exists

### Debug Mode

In development environment, debug information is automatically enabled. You can:

- View error messages in the browser
- Check logs in `application/logs/`
- Use the profiler (if enabled)

## Security Notes

- Never commit `.env` files to version control
- Use strong encryption keys in production
- Keep database credentials secure
- Regularly update dependencies

## Production Deployment

For production deployment:

1. Set `CI_ENV=production` in your environment
2. Configure production database settings
3. Set strong encryption keys
4. Enable CSRF protection
5. Configure proper email settings
6. Set up SSL certificates
7. Configure caching

## Support

If you encounter issues:

1. Check the troubleshooting section above
2. Review the CodeIgniter 3 documentation
3. Check the application logs in `application/logs/`
4. Contact the development team
