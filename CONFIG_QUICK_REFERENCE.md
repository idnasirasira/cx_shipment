# Configuration Quick Reference

## 🚀 Quick Setup

```bash
# 1. Copy environment file
cp env.example .env

# 2. Edit .env with your settings
nano .env

# 3. Set environment
CI_ENV=development
```

## 📋 Essential Configuration Values

### Database Settings

```php
// Local Development
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => 'your_password',
    'database' => 'cx_shipment_dev',
    'dbdriver' => 'mysqli',
    'db_debug' => TRUE,  // Show errors
);

// Production
$db['default'] = array(
    'hostname' => 'your-db-server.com',
    'username' => 'prod_user',
    'password' => 'strong_password',
    'database' => 'cx_shipment_prod',
    'dbdriver' => 'mysqli',
    'db_debug' => FALSE,  // Hide errors
    'cache_on' => TRUE,   // Enable caching
);
```

### Application Settings

```php
// Development
$config['base_url'] = 'http://localhost/cx_shipment/';
$config['index_page'] = '';  // Clean URLs
$config['log_threshold'] = 4;  // Log everything
$config['display_errors'] = TRUE;

// Production
$config['base_url'] = 'https://yourdomain.com/';
$config['index_page'] = '';
$config['log_threshold'] = 1;  // Only errors
$config['display_errors'] = FALSE;
```

### Email Settings

```php
// Development (MailHog)
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'localhost';
$config['smtp_port'] = 1025;

// Production (Gmail)
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 587;
$config['smtp_crypto'] = 'tls';
$config['smtp_user'] = 'your_email@gmail.com';
$config['smtp_pass'] = 'your_app_password';
```

### Security Settings

```php
// Development
$config['encryption_key'] = 'dev-key-123456789012345678901234';
$config['csrf_protection'] = FALSE;

// Production
$config['encryption_key'] = 'strong-32-character-production-key';
$config['csrf_protection'] = TRUE;
$config['sess_match_ip'] = TRUE;
```

## 🔧 Common Customizations

### Change Database

```php
// MySQL
'dbdriver' => 'mysqli',
'hostname' => 'localhost',
'username' => 'root',
'password' => 'password',
'database' => 'your_database',

// SQLite
'dbdriver' => 'sqlite3',
'database' => APPPATH . 'database.sqlite',

// PostgreSQL
'dbdriver' => 'postgre',
'hostname' => 'localhost',
'username' => 'postgres',
'password' => 'password',
'database' => 'your_database',
```

### Change Upload Settings

```php
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx';
$config['max_size'] = 2048;  // 2MB
$config['max_width'] = 1920;
$config['max_height'] = 1080;
```

### Change Session Settings

```php
$config['sess_driver'] = 'files';  // or 'database', 'redis'
$config['sess_expiration'] = 7200;  // 2 hours
$config['sess_save_path'] = APPPATH . 'sessions/';
$config['sess_match_ip'] = FALSE;  // TRUE for production
```

## 🛠️ Helper Functions

```php
// Get environment variable
$db_host = env('DB_HOST', 'localhost');

// Get configuration value
$base_url = config('base_url');

// Check environment
if (is_development()) {
    // Development code
}

if (is_production()) {
    // Production code
}

// Asset URLs
echo asset_url('css/style.css');
echo upload_url('images/photo.jpg');
```

## 📁 File Locations

| File                  | Purpose                                           | Location |
| --------------------- | ------------------------------------------------- | -------- |
| Environment detection | `application/config/environment.php`              |
| Development config    | `application/config/environments/development.php` |
| Production config     | `application/config/environments/production.php`  |
| Testing config        | `application/config/environments/testing.php`     |
| Template              | `application/config/environments/template.php`    |
| Environment variables | `.env` (create from `env.example`)                |

## 🔍 Environment Detection

The application automatically detects environment:

1. **Environment Variable**: `CI_ENV=development`
2. **`.env` File**: Contains `CI_ENV=development`
3. **Default**: Falls back to `development`

## 🚨 Important Notes

### Security

- ✅ Never commit `.env` files
- ✅ Use different encryption keys per environment
- ✅ Use strong passwords in production
- ✅ Enable CSRF protection in production

### Performance

- ✅ Enable caching in production
- ✅ Disable debug mode in production
- ✅ Use query caching in production
- ✅ Optimize database settings

### Development

- ✅ Enable error display for debugging
- ✅ Use local database
- ✅ Enable profiler for analysis
- ✅ Log everything for troubleshooting

## 📞 Need Help?

1. **Check logs**: `application/logs/`
2. **Test configuration**: Visit `http://localhost/cx_shipment/test`
3. **Review documentation**: `CONFIGURATION_GUIDE.md`
4. **Troubleshoot issues**: `TROUBLESHOOTING.md`
