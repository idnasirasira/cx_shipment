# CX Shipment - CodeIgniter 3 Project

A modern CodeIgniter 3 project with dynamic configuration, environment management, and team-friendly setup.

## 🚀 Quick Start

### Prerequisites

- PHP 7.0 or higher
- MySQL/MariaDB or SQLite
- Web server (Apache/Nginx) or PHP built-in server
- Composer (optional)

### Installation

1. **Clone the repository**

   ```bash
   git clone <repository-url>
   cd cx_shipment
   ```

2. **Set up environment**

   ```bash
   cp env.example .env
   # Edit .env with your settings
   ```

3. **Create required directories**

   ```bash
   mkdir -p uploads application/sessions
   chmod 755 uploads application/sessions application/cache
   ```

4. **Configure .htaccess**

   ```bash
   # For development
   cp .htaccess.development .htaccess

   # For production
   cp .htaccess.production .htaccess
   ```

5. **Start development server**

   ```bash
   php -S localhost:8000
   ```

6. **Test the setup**
   - Visit: `http://localhost:8000/`
   - Test page: `http://localhost:8000/test`

## 📚 Documentation

### Setup & Configuration

- **[SETUP.md](SETUP.md)** - Complete setup guide for team members
- **[CONFIGURATION_GUIDE.md](CONFIGURATION_GUIDE.md)** - Detailed configuration reference
- **[CONFIG_QUICK_REFERENCE.md](CONFIG_QUICK_REFERENCE.md)** - Quick configuration reference
- **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** - Common issues and solutions

### Configuration Files

- **Environment Detection**: `application/config/environment.php`
- **Development Config**: `application/config/environments/development.php`
- **Production Config**: `application/config/environments/production.php`
- **Testing Config**: `application/config/environments/testing.php`
- **Configuration Template**: `application/config/environments/template.php`

## 🔧 Configuration System

### Environment Management

The project uses a dynamic configuration system that automatically detects and loads the appropriate settings based on the environment:

- **Development**: Debug enabled, local database, relaxed security
- **Testing**: SQLite database, minimal logging, testing optimizations
- **Production**: Strict security, production database, performance optimizations

### Environment Detection

1. **Environment Variable**: `CI_ENV=development`
2. **`.env` File**: Contains `CI_ENV=development`
3. **Default**: Falls back to `development`

### Key Features

- ✅ **Clean URLs** - No `index.php` in URLs
- ✅ **Environment-Specific Settings** - Different configs for dev/test/prod
- ✅ **Security Headers** - XSS protection, CSRF, clickjacking prevention
- ✅ **Performance Optimizations** - Compression, caching, optimization
- ✅ **Team-Friendly** - Easy setup for new team members
- ✅ **Helper Functions** - Easy access to configuration values

## 🛠️ Helper Functions

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

## 📁 Project Structure

```
cx_shipment/
├── application/
│   ├── config/
│   │   ├── environments/          # Environment-specific configs
│   │   │   ├── development.php
│   │   │   ├── production.php
│   │   │   ├── testing.php
│   │   │   └── template.php
│   │   ├── environment.php        # Environment detection
│   │   ├── config.php            # Main application config
│   │   └── database.php          # Database config
│   ├── controllers/
│   │   ├── Auth.php              # Authentication controller
│   │   ├── Test.php              # Test controller
│   │   └── admin/                # Admin controllers
│   │       ├── Dashboard.php     # Admin dashboard
│   │       └── settings/         # Settings controllers
│   │           ├── Developer.php # Developer settings
│   │           └── DatabaseReset.php # Database reset
│   ├── helpers/
│   │   └── config_helper.php     # Configuration helpers
│   └── views/
│       ├── auth/                 # Authentication views
│       ├── admin/                # Admin views
│       │   ├── dashboard/        # Dashboard views
│       │   ├── settings/         # Settings views
│       │   └── users/            # User management views
│       └── layouts/              # Layout templates
├── system/                       # CodeIgniter core
├── uploads/                      # File uploads
├── .htaccess                     # URL rewriting & security
├── .htaccess.development         # Development settings
├── .htaccess.production          # Production settings
├── .env.example                  # Environment template
├── env.example                   # Environment template
├── index.php                     # Entry point
└── README.md                     # This file
```

## 🔒 Security Features

### Development Environment

- Relaxed security for easier debugging
- Error display enabled
- CSRF protection disabled
- Debug toolbar enabled

### Production Environment

- Strict security headers
- Error display disabled
- CSRF protection enabled
- IP-based session matching
- HSTS (HTTP Strict Transport Security)

### File Protection

- Sensitive files protected (.env, composer files, logs)
- PHP execution prevented in uploads directory
- Application and system directories protected

## 🚀 Performance Features

### URL Rewriting

- Clean URLs without `index.php`
- Automatic trailing slash handling
- Authorization header support

### Caching & Compression

- Gzip compression for text files
- Browser caching with appropriate expiration times
- Query caching in production
- Asset versioning for cache busting

### PHP Optimization

- Environment-specific PHP settings
- Memory and upload limits optimization
- Execution time optimization

## 👥 Team Development

### For New Team Members

1. Clone the repository
2. Copy `env.example` to `.env`
3. Customize `.env` for local environment
4. Create required directories
5. Start developing!

### Configuration Changes

When adding new configuration options:

1. Add to all environment files
2. Update `env.example`
3. Document in `CONFIGURATION_GUIDE.md`
4. Update this README if needed

### Best Practices

- ✅ Never commit `.env` files
- ✅ Use different encryption keys per environment
- ✅ Test configuration changes
- ✅ Document new settings
- ✅ Use helper functions for configuration access

## 🧪 Testing

### Test Controller

Visit `http://localhost/cx_shipment/test` to verify:

- Environment detection
- Configuration loading
- URL rewriting
- Helper functions

### Test URLs

- **Homepage**: `http://localhost/cx_shipment/`
- **Login**: `http://localhost/cx_shipment/auth/login`
- **Test**: `http://localhost/cx_shipment/test`
- **Admin Dashboard**: `http://localhost/cx_shipment/admin/dashboard`
- **Developer Settings**: `http://localhost/cx_shipment/admin/settings/developer`

## 🐛 Troubleshooting

### Common Issues

1. **URLs not working**: Check `.htaccess` and mod_rewrite
2. **Database connection**: Verify credentials in `.env`
3. **Environment not detected**: Check `CI_ENV` setting
4. **Permission errors**: Set correct file permissions

### Getting Help

1. Check `TROUBLESHOOTING.md` for detailed solutions
2. Review `SETUP.md` for setup instructions
3. Check application logs in `application/logs/`
4. Use the test controller to verify configuration

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

1. Follow the existing code style
2. Update documentation for configuration changes
3. Test your changes thoroughly
4. Use the established environment system

## 📞 Support

- **Documentation**: Check the documentation files above
- **CodeIgniter 3**: [Official Documentation](https://codeigniter.com/userguide3/)
- **Issues**: Create an issue in the repository
- **Team**: Contact your development team lead
