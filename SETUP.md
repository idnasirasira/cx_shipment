# CodeIgniter 3 Shipment Management System - Setup Guide

This guide will help you set up the CX Shipment Management System for your local development environment.

## Project Overview

The CX Shipment Management System is a comprehensive web application built with CodeIgniter 3 that provides:

- **User Authentication System** - Login, registration, and password recovery
- **Admin Dashboard** - Centralized management interface
- **Role-Based Access Control** - User roles and permissions system
- **Database Management** - Built-in database reset tools for development
- **Modern UI Framework** - Bootstrap-based responsive design
- **Environment Configuration** - Multi-environment support (development, testing, production)

## Prerequisites

- PHP 7.0 or higher
- MySQL/MariaDB (MAMP/XAMPP recommended for local development)
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
DB_PASSWORD=root
DB_DATABASE=cx_shipment_dev
DB_DRIVER=mysqli

# Application Configuration
# Note: Adjust the port number based on your local setup
# Common configurations:
# - XAMPP: http://localhost/cx_shipment/
# - MAMP: http://localhost:8888/cx_shipment/
# - Custom: http://localhost:YOUR_PORT/cx_shipment/
BASE_URL=http://localhost/cx_shipment/
ENCRYPTION_KEY=your-32-character-encryption-key-here

# Email Configuration
SMTP_HOST=localhost
SMTP_PORT=1025
SMTP_USERNAME=
SMTP_PASSWORD=
SMTP_ENCRYPTION=

# Debug Settings
DISPLAY_ERRORS=true
LOG_THRESHOLD=4

# Upload Settings
UPLOAD_PATH=./uploads/
MAX_FILE_SIZE=2048

# Session Settings
SESSION_EXPIRATION=7200
SESSION_MATCH_IP=false

# Cache Settings
CACHE_ENABLED=false
CACHE_EXPIRES=7200
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

#### Option A: MySQL/MariaDB (Recommended)

1. Create a new database:

```sql
CREATE DATABASE cx_shipment_dev CHARACTER SET utf8 COLLATE utf8_general_ci;
```

2. Import the database schema files in order:

```bash
# Import roles table
mysql -u root -p cx_shipment_dev < database/2025_08_15_164216_create_roles_table.sql

# Import permissions table
mysql -u root -p cx_shipment_dev < database/2025_08_15_164445_create_permissions_table.sql

# Import users table (includes default admin user)
mysql -u root -p cx_shipment_dev < database/2025_08_15_164606_create_users_table.sql
```

**Note**: If you're using a different port for MySQL (e.g., MAMP uses port 8889), specify it in the connection:

```bash
mysql -u root -p -h localhost -P 8889 cx_shipment_dev < database/2025_08_15_164216_create_roles_table.sql
```

#### Default Admin Credentials

After importing the database, you can log in with:

- **Username**: `admin`
- **Email**: `admin@example.com`
- **Password**: `admin123`

#### Option B: SQLite (for testing)

The testing environment is configured to use SQLite by default.

### 5. Configure .htaccess

The project includes a configured `.htaccess` file with:

- URL rewriting for clean URLs
- Authorization header support
- Trailing slash handling
- Front controller pattern

### 6. Start Development Server

#### Using PHP Built-in Server

```bash
php -S localhost:8000
```

#### Using MAMP/XAMPP

Configure your web server to point to the project directory.

### 7. Test the Application

After setting up your environment, test the following URLs (adjust the port number based on your setup):

#### Authentication Pages:

- **Login**: `http://localhost/cx_shipment/auth/login`
- **Register**: `http://localhost/cx_shipment/auth/register`
- **Forgot Password**: `http://localhost/cx_shipment/auth/forgot-password`

#### Admin Dashboard:

- **Dashboard**: `http://localhost/cx_shipment/admin/dashboard`
- **Developer Settings** (Development only): `http://localhost/cx_shipment/admin/settings/developer`
- **Database Reset** (Development only): `http://localhost/cx_shipment/admin/settings/database-reset`

**Common URL variations:**

- XAMPP: `http://localhost/cx_shipment/`
- MAMP: `http://localhost:8888/cx_shipment/`
- Custom port: `http://localhost:YOUR_PORT/cx_shipment/`

## Implemented Features

### 1. Authentication System

- **Login/Logout functionality** - User authentication with session management
- **User Registration** - New user account creation
- **Password Recovery** - Forgot password functionality
- **Session Management** - Secure session handling with configurable timeouts

### 2. Admin Dashboard

- **Modern UI** - Bootstrap-based responsive design
- **Navigation System** - Breadcrumb navigation and menu highlighting
- **Settings Management** - Organized settings structure with developer tools
- **Development Tools** - Developer settings and database reset functionality (development environment only)
- **Role-Based Access** - Different views based on user roles

### 3. Database Structure

#### Users Table

- User authentication and profile information
- Role-based access control
- Soft delete functionality
- Audit timestamps

#### Roles Table

- User role definitions
- Default roles: admin, user, manager

#### Permissions Table

- Granular permission system
- Role-permission relationships

### 4. Layout System

- **Custom Layout Library** - Flexible template system
- **Multiple Layouts** - Guest and admin layouts
- **Asset Management** - CSS/JS file organization with admin-specific scripts
- **Responsive Design** - Mobile-friendly interface

### 5. Helper Functions

#### Configuration Helpers

- `env()` - Environment variable access
- `config()` - Configuration value retrieval
- `is_development()`, `is_production()`, `is_testing()` - Environment checks

#### Asset Helpers

- `asset_url()` - Asset URLs with cache busting
- `upload_url()` - Upload file URLs

#### UI Helpers

- `is_menu_active()` - Menu highlighting based on current URL

## Environment Configuration

### Available Environments

- **development**: For local development with debug enabled
- **testing**: For automated testing and CI/CD
- **production**: For production deployment with security optimizations

### Environment-Specific Settings

#### Development Environment

- Debug mode enabled
- Error display on
- Database debugging enabled
- Relaxed security settings
- Development tools available

#### Production Environment

- Debug mode disabled
- Error display off
- Strict security settings
- Performance optimizations
- Development tools hidden

## Development Tools

### Development Tools

Available in development environment:

#### Database Reset Tool (`/admin/settings/database-reset`)

- Resets database to initial state
- Re-imports all migration files
- Useful for testing and development
- **Only available in development mode**

#### Developer Settings (`/admin/settings/developer`)

- Centralized developer configuration
- Development environment management
- **Only available in development mode**

### Configuration Management

The system uses a multi-layered configuration approach:

1. **Environment Variables** (`.env` file)
2. **Environment-Specific Configs** (`application/config/environments/`)
3. **Main Configuration** (`application/config/config.php`)

## File Structure

```
cx_shipment/
├── application/
│   ├── config/
│   │   ├── environments/          # Environment-specific configs
│   │   └── config.php            # Main configuration
│   ├── controllers/
│   │   ├── admin/                # Admin controllers
│   │   │   ├── Dashboard.php     # Admin dashboard
│   │   │   └── settings/         # Settings controllers
│   │   │       ├── Developer.php # Developer settings
│   │   │       └── DatabaseReset.php # Database reset
│   │   ├── Auth.php              # Authentication controller
│   │   └── Test.php              # Test controller
│   ├── core/
│   │   └── MY_Controller.php     # Base controller
│   ├── helpers/
│   │   ├── config_helper.php     # Configuration helpers
│   │   └── global_helper.php     # Global utility functions
│   ├── libraries/
│   │   └── layout.php            # Layout management
│   └── views/
│       ├── auth/                 # Authentication views
│       ├── admin/                # Admin views
│       │   ├── dashboard/        # Dashboard views
│       │   ├── settings/         # Settings views
│       │   │   └── developer/    # Developer settings views
│       │   └── users/            # User management views
│       └── layouts/              # Layout templates
├── assets/                       # Frontend assets
│   ├── js/                      # JavaScript files
│   │   ├── admin/               # Admin JavaScript
│   │   │   ├── dashboard/       # Dashboard scripts
│   │   │   └── settings/        # Settings scripts
│   │   └── auth/                # Authentication scripts
│   └── compiled/                # Compiled assets
├── database/                     # Database migration files
├── uploads/                      # File upload directory
├── .env                          # Environment configuration
├── .htaccess                     # URL rewriting rules
└── index.php                     # Front controller
```

## Troubleshooting

### Common Issues

#### 1. "No direct script access allowed" Error

Make sure you're accessing the application through the web server, not directly via file system.

#### 2. Database Connection Error

- Check your database credentials in `.env`
- Ensure the database exists
- Verify database server is running
- For MAMP: Use port 8889 for MySQL (if using default MAMP configuration)

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

#### 5. URL Rewriting Not Working

- Ensure Apache mod_rewrite is enabled
- Check that `.htaccess` file is in project root
- Verify web server configuration allows `.htaccess` overrides

### Debug Mode

In development environment, debug information is automatically enabled. You can:

- View error messages in the browser
- Check logs in `application/logs/`
- Use the profiler (if enabled)
- Access development tools in admin dashboard

## Security Notes

- Never commit `.env` files to version control
- Use strong encryption keys in production
- Keep database credentials secure
- Regularly update dependencies
- Change default admin password after first login

## Production Deployment

For production deployment:

1. Set `CI_ENV=production` in your environment
2. Configure production database settings
3. Set strong encryption keys
4. Enable CSRF protection
5. Configure proper email settings
6. Set up SSL certificates
7. Configure caching
8. Disable development tools
9. Set appropriate file permissions

## Next Steps

### Planned Features

- **Shipment Management** - Create, track, and manage shipments
- **User Management** - Admin interface for user management
- **Reporting System** - Analytics and reporting features
- **API Development** - RESTful API for mobile applications
- **Email Notifications** - Automated email notifications
- **File Upload System** - Document and image upload functionality

### Development Guidelines

1. **Follow CodeIgniter 3 conventions**
2. **Use the layout system** for consistent UI
3. **Implement proper validation** for all forms
4. **Add appropriate error handling**
5. **Write unit tests** for critical functionality
6. **Document new features** in this setup guide

## Support

If you encounter issues:

1. Check the troubleshooting section above
2. Review the CodeIgniter 3 documentation
3. Check the application logs in `application/logs/`
4. Contact the development team

## Version Information

- **CodeIgniter Version**: 3.x
- **PHP Requirement**: 7.0+
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Last Updated**: January 2025
