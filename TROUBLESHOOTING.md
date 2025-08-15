# Troubleshooting Guide

This guide helps you resolve common issues with the CodeIgniter 3 project setup.

## URL Rewriting Issues

### Problem: URLs still show `index.php`

**Symptoms:**

- URLs like `http://localhost/cx_shipment/index.php/auth/login` still work
- URLs like `http://localhost/cx_shipment/auth/login` show 404 errors
- URLs like `http://localhost:8888/cx_shipment/auth/login` show 404 errors (if using custom port)

**Solutions:**

1. **Check .htaccess file exists:**

   ```bash
   ls -la .htaccess
   ```

2. **Check .htaccess permissions:**

   ```bash
   chmod 644 .htaccess
   ```

3. **Verify mod_rewrite is enabled:**

   ```bash
   # Create a test file
   echo "<?php phpinfo(); ?>" > test.php

   # Check if mod_rewrite is loaded
   grep -i "mod_rewrite" test.php
   ```

4. **Test .htaccess with a simple rule:**

   ```apache
   RewriteEngine On
   RewriteRule ^test$ test.php [L]
   ```

5. **Check Apache configuration:**

   ```bash
   # Ubuntu/Debian
   sudo a2enmod rewrite
   sudo systemctl restart apache2

   # macOS (MAMP)
   # Check MAMP preferences -> Apache -> Modules -> rewrite

   # Windows (XAMPP)
   # Check httpd.conf for LoadModule rewrite_module
   ```

### Problem: 500 Internal Server Error

**Symptoms:**

- All pages show 500 error
- Apache error logs show syntax errors

**Solutions:**

1. **Check .htaccess syntax:**

   ```bash
   # Test .htaccess syntax
   apache2ctl -t
   ```

2. **Check PHP syntax in environment files:**

   ```bash
   php -l application/config/environments/development.php
   php -l application/config/environments/production.php
   php -l application/config/environments/testing.php
   ```

3. **Check file permissions:**
   ```bash
   chmod 755 application/
   chmod 755 system/
   chmod 644 .htaccess
   ```

### Problem: Environment not detected

**Symptoms:**

- Configuration not loading correctly
- Database connection errors
- Wrong base_url

**Solutions:**

1. **Check .env file:**

   ```bash
   # Verify .env exists and has correct content
   cat .env
   ```

2. **Check environment variable:**

   ```bash
   # Set environment variable
   export CI_ENV=development

   # Or add to your shell profile
   echo 'export CI_ENV=development' >> ~/.bashrc
   ```

3. **Check environment file exists:**
   ```bash
   ls -la application/config/environments/
   ```

## Database Issues

### Problem: Database connection failed

**Symptoms:**

- "Unable to connect to your database server" error
- Database queries fail

**Solutions:**

1. **Check database credentials in .env:**

   ```bash
   # Verify database settings
   grep -E "DB_|database" .env
   ```

2. **Test database connection:**

   ```bash
   # Standard connection
   mysql -u root -p -h localhost

   # If using custom port (e.g., MAMP uses 8889)
   mysql -u root -p -h localhost -P 8889
   ```

3. **Check database exists:**

   ```sql
   SHOW DATABASES;
   CREATE DATABASE IF NOT EXISTS cx_shipment_dev;
   ```

4. **Check MySQL service:**

   ```bash
   # Ubuntu/Debian
   sudo systemctl status mysql

   # macOS (MAMP)
   # Check MAMP preferences -> MySQL
   # Default MySQL port: 8889

   # Windows (XAMPP)
   # Check XAMPP Control Panel
   # Default MySQL port: 3306
   ```

## File Permission Issues

### Problem: Upload directory not writable

**Symptoms:**

- File uploads fail
- "Upload directory is not writable" error

**Solutions:**

1. **Set correct permissions:**

   ```bash
   chmod 755 uploads/
   chmod 755 application/sessions/
   chmod 755 application/cache/
   ```

2. **Check web server user:**

   ```bash
   # Find web server user
   ps aux | grep apache
   ps aux | grep nginx

   # Change ownership if needed
   sudo chown www-data:www-data uploads/
   ```

## Port Configuration Issues

### Problem: Wrong port in URLs

**Symptoms:**

- Pages load but assets (CSS, JS, images) don't load
- Links redirect to wrong URLs
- Database connection works but web interface doesn't

**Solutions:**

1. **Check BASE_URL in .env file:**

   ```bash
   # Verify your BASE_URL matches your setup
   grep BASE_URL .env
   ```

2. **Common BASE_URL configurations:**

   ```bash
   # XAMPP (default)
   BASE_URL=http://localhost/cx_shipment/

   # MAMP (default)
   BASE_URL=http://localhost:8888/cx_shipment/

   # Custom port
   BASE_URL=http://localhost:YOUR_PORT/cx_shipment/
   ```

3. **Check database port configuration:**

   ```bash
   # In your .env file, verify database settings
   # For MAMP users, you might need to specify port in environment config
   ```

### Problem: Database connection on wrong port

**Symptoms:**

- "Unable to connect to your database server" error
- Database exists but connection fails

**Solutions:**

1. **Check database port in environment config:**

   ```php
   // In application/config/environments/development.php
   $db['default']['hostname'] = '127.0.0.1';
   $db['default']['port'] = '8889'; // Add this line for MAMP
   ```

2. **Test connection with explicit port:**

   ```bash
   mysql -u root -p -h localhost -P 8889
   ```

## Environment-Specific Issues

### Development Environment

**Problem: Errors not showing**

- Check `display_errors` is set to `TRUE`
- Check `log_threshold` is set to `4`

**Problem: Profiler not showing**

- Check `show_profiler` is set to `TRUE`
- Load the profiler in your controller: `$this->output->enable_profiler(TRUE);`

### Production Environment

**Problem: Too many redirects**

- Check `base_url` is correct
- Verify SSL configuration if using HTTPS

**Problem: Performance issues**

- Enable caching in production environment
- Check `db_debug` is set to `FALSE`

## Common Error Messages

### "No direct script access allowed"

- You're trying to access PHP files directly
- Always access through the web server
- Make sure you're using the correct URL format for your setup

### "Unable to load the requested file"

- Check file paths are correct
- Verify file permissions

### "Class 'CI_Controller' not found"

- Check system directory is accessible
- Verify CodeIgniter installation

## Testing Your Setup

Use the test controller to verify everything is working:

1. **Access test page:**

   ```
   # Standard setup
   http://localhost/cx_shipment/test

   # With custom port (e.g., MAMP)
   http://localhost:8888/cx_shipment/test
   ```

2. **Access development tools:**

   ```
   # Developer settings
   http://localhost/cx_shipment/admin/settings/developer

   # Database reset
   http://localhost/cx_shipment/admin/settings/database-reset
   ```

3. **Check environment detection:**

   - Should show current environment
   - Should display correct base_url

4. **Test URL rewriting:**
   - All links should work without `index.php`
   - Parameters should be passed correctly

## Getting Help

If you're still having issues:

1. **Check error logs:**

   ```bash
   # Apache error logs
   tail -f /var/log/apache2/error.log

   # CodeIgniter logs
   tail -f application/logs/log-*.php
   ```

2. **Verify your setup configuration:**

   - Check your `.env` file has the correct `BASE_URL` for your port setup
   - Verify database connection settings match your local environment
   - Ensure all required directories exist and have proper permissions

3. **Enable debug mode:**

   - Set `CI_ENV=development`
   - Check browser developer tools

4. **Verify setup:**

   - Follow the setup guide step by step
   - Check all prerequisites are met
   - Verify port configurations match your local environment

5. **Contact support:**
   - Check the CodeIgniter 3 documentation
   - Review the setup guide in SETUP.md
