# Database Reset Feature

This feature allows developers to reset the database to its initial state by executing all SQL migration files in the correct order.

## ⚠️ Important Notes

- **This feature is only available in development environment**
- **All existing data will be permanently lost when resetting**
- **Use with extreme caution**

## How to Use

### 1. Access the Feature

1. Navigate to the admin dashboard: `http://your-domain/admin/dashboard`
2. In development mode, you'll see a "Developer Tools" section
3. Click the "Database Reset" button

### 2. Reset Process

1. Review the SQL files that will be executed
2. Type `RESET_DATABASE` in the confirmation field
3. Click "Reset Database"
4. Wait for the process to complete
5. Review the results in the modal

## SQL Files Execution Order

The system executes SQL files in alphabetical order based on filename. The current files are:

1. `2025_08_15_164216_create_roles_table.sql` - Creates roles table and inserts default roles
2. `2025_08_15_164445_create_permissions_table.sql` - Creates permissions and role_permissions tables
3. `2025_08_15_164606_create_users_table.sql` - Creates users table and inserts default admin user

## Security Features

- **Environment Check**: Only works in development environment
- **Confirmation Required**: Must type exact confirmation code
- **POST Request Only**: Cannot be triggered via GET requests
- **Error Handling**: Comprehensive error reporting and rollback

## Default Data

After reset, the database will contain:

### Roles

- admin (Administrator with full access)
- staff (Staff with limited access)
- driver (Delivery driver)
- customer (Customer/client user)

### Permissions

- manage_users
- manage_roles
- manage_orders
- view_reports
- manage_customers
- manage_drivers
- manage_settings

### Default Admin User

- Username: `admin`
- Email: `admin@example.com`
- Password: `admin123` (hashed)
- Role: Administrator

## Troubleshooting

### Common Issues

1. **"Access Denied" Error**

   - Ensure you're in development environment
   - Check `ENVIRONMENT` constant in `application/config/config.php`

2. **SQL Execution Errors**

   - Check database connection settings
   - Verify SQL file syntax
   - Ensure proper file permissions

3. **Files Not Found**
   - Verify SQL files exist in `database/` directory
   - Check file extensions are `.sql`

### Logs

The system logs the last reset time in the cache. You can check this in the interface.

## File Structure

```
database/
├── 2025_08_15_164216_create_roles_table.sql
├── 2025_08_15_164445_create_permissions_table.sql
└── 2025_08_15_164606_create_users_table.sql
```

## Adding New SQL Files

1. Create new SQL file in `database/` directory
2. Use timestamp prefix for proper ordering: `YYYY_MM_DD_HHMMSS_description.sql`
3. Include proper DROP TABLE statements if needed
4. Test the reset process

## API Endpoints

- `GET /database` - Show reset interface
- `POST /database/reset` - Execute database reset

## Dependencies

- CodeIgniter 3.x
- Bootstrap 5 (for UI)
- jQuery (for AJAX functionality)
