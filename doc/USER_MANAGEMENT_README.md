# User Management System

A comprehensive user management feature for the CX Shipment Management System built with CodeIgniter 3.

## Features

### Core Functionality

- **User Listing**: Display all users with DataTables integration
- **User Creation**: Add new users with comprehensive form validation
- **User Details**: View detailed user information
- **User Editing**: Update user information with validation
- **User Deletion**: Soft delete users with confirmation
- **Status Management**: Activate/deactivate user accounts

### User Roles

- **Admin**: Full system access
- **Staff**: Limited administrative access
- **Driver**: Delivery driver access
- **Customer**: Client/customer access

### Security Features

- Password hashing using PHP's `password_hash()`
- Form validation with CodeIgniter's validation library
- CSRF protection
- Input sanitization
- Role-based access control
- Soft delete functionality

## File Structure

```
application/
├── controllers/admin/
│   └── Users.php                 # Main user management controller
├── models/
│   ├── User_model.php            # User data operations
│   └── Role_model.php            # Role data operations
├── views/admin/users/
│   ├── index.php                 # User listing page
│   ├── create.php                # Create user form
│   ├── edit.php                  # Edit user form
│   └── show.php                  # User details page
├── helpers/
│   └── user_helper.php           # User utility functions

assets/
└── js/admin/users/
    ├── index.js                  # User listing JavaScript
    └── form.js                   # Form handling JavaScript

database/
└── 2025_01_15_120000_add_user_profile_fields.sql  # Database migration
```

## Installation

### 1. Database Setup

Run the database migration to ensure all required fields exist:

```sql
-- Execute the migration file
source database/2025_01_15_120000_add_user_profile_fields.sql
```

### 2. Load Helper

Add the user helper to your autoload configuration in `application/config/autoload.php`:

```php
$autoload['helper'] = array('user');
```

### 3. Routes (Optional)

Add routes to `application/config/routes.php` for cleaner URLs:

```php
// User management routes
$route['admin/users'] = 'admin/users/index';
$route['admin/users/create'] = 'admin/users/create';
$route['admin/users/store'] = 'admin/users/store';
$route['admin/users/show/(:num)'] = 'admin/users/show/$1';
$route['admin/users/edit/(:num)'] = 'admin/users/edit/$1';
$route['admin/users/update/(:num)'] = 'admin/users/update/$1';
$route['admin/users/destroy/(:num)'] = 'admin/users/destroy/$1';
$route['admin/users/toggle_status/(:num)'] = 'admin/users/toggle_status/$1';
```

## Usage

### Accessing User Management

Navigate to: `http://your-domain/admin/users`

### Creating a New User

1. Click "Add New User" button
2. Fill in the required fields:
   - First Name (required)
   - Last Name (required)
   - Username (required, unique)
   - Email (required, unique)
   - Password (required, min 6 characters)
   - Role (required)
3. Optional fields:
   - Phone number
   - Address
   - Account status (active/inactive)
4. Click "Create User"

### Editing a User

1. Click the edit icon (pencil) next to any user
2. Modify the desired fields
3. Password is optional - leave blank to keep current password
4. Click "Update User"

### Viewing User Details

1. Click the view icon (eye) next to any user
2. View comprehensive user information
3. Use quick action buttons for common tasks

### Managing User Status

1. Click the status toggle button (play/pause icon)
2. Confirm the action in the modal
3. User will be activated/deactivated accordingly

### Deleting a User

1. Click the delete icon (trash) next to any user
2. Confirm deletion in the modal
3. User will be soft deleted (not permanently removed)

## API Endpoints

### GET Endpoints

- `GET /admin/users` - List all users
- `GET /admin/users/create` - Show create form
- `GET /admin/users/show/{id}` - Show user details
- `GET /admin/users/edit/{id}` - Show edit form

### POST Endpoints

- `POST /admin/users/store` - Create new user
- `POST /admin/users/update/{id}` - Update user

### GET Endpoints (Actions)

- `GET /admin/users/destroy/{id}` - Delete user
- `GET /admin/users/toggle_status/{id}` - Toggle user status

## Database Schema

### Users Table

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone VARCHAR(20),
    address TEXT,
    profile_picture VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
);
```

### Roles Table

```sql
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);
```

## Helper Functions

The system includes several helper functions for user management:

### User Information

- `get_user_full_name($user)` - Get user's full name
- `get_user_display_name($user)` - Get display name (first + last initial)
- `get_user_initials($user)` - Get user initials for avatar
- `get_user_profile_picture($user)` - Get profile picture URL

### Status and Roles

- `get_user_status_badge($isActive)` - Get status badge HTML
- `get_user_role_badge($roleName)` - Get role badge HTML
- `user_has_role($user, $roleName)` - Check if user has specific role
- `user_is_admin($user)` - Check if user is admin
- `user_is_staff($user)` - Check if user is staff
- `user_is_driver($user)` - Check if user is driver
- `user_is_customer($user)` - Check if user is customer

### Validation

- `is_valid_username($username)` - Validate username format
- `is_valid_email($email)` - Validate email format
- `is_valid_phone($phone)` - Validate phone number format

### Formatting

- `format_last_login($lastLogin)` - Format last login time
- `format_phone_number($phone)` - Format phone number for display
- `get_user_created_date($createdAt)` - Format creation date
- `get_user_updated_date($updatedAt)` - Format update date

## JavaScript Features

### DataTables Integration

- Searchable and sortable user table
- Pagination with configurable page sizes
- Responsive design
- Custom labels and styling

### Form Validation

- Real-time client-side validation
- Password confirmation matching
- Username format validation
- Email format validation
- Phone number validation

### Interactive Features

- Password visibility toggle
- Modal confirmations for destructive actions
- Auto-hiding alerts
- Loading states for form submissions

## Security Considerations

### Password Security

- Passwords are hashed using PHP's `password_hash()` with `PASSWORD_DEFAULT`
- Minimum password length of 6 characters
- Password confirmation required for new users

### Input Validation

- Server-side validation using CodeIgniter's form validation library
- Client-side validation for immediate feedback
- SQL injection prevention through CodeIgniter's query builder
- XSS prevention through proper output escaping

### Access Control

- Role-based permissions
- Soft delete functionality to prevent data loss
- Prevention of self-deletion
- Unique constraints on username and email

## Customization

### Adding New User Fields

1. Add the field to the database migration
2. Update the User_model methods
3. Modify the form views
4. Update validation rules in the controller
5. Add helper functions if needed

### Customizing Validation Rules

Modify validation rules in the controller methods:

```php
$this->form_validation->set_rules('field_name', 'Field Label', 'validation_rules');
```

### Customizing UI

The views use Bootstrap 5 classes and can be customized by:

- Modifying CSS classes
- Adding custom JavaScript
- Updating the template structure

## Troubleshooting

### Common Issues

1. **Users not appearing in list**

   - Check if users have `deleted_at IS NULL`
   - Verify database connection
   - Check for JavaScript errors

2. **Form validation errors**

   - Ensure all required fields are filled
   - Check username/email uniqueness
   - Verify password confirmation matches

3. **JavaScript not working**
   - Check browser console for errors
   - Ensure all required libraries are loaded
   - Verify file paths are correct

### Debug Mode

Enable CodeIgniter's debug mode in `application/config/config.php`:

```php
$config['log_threshold'] = 4;
```

## Contributing

When contributing to the user management system:

1. Follow the existing code style
2. Add proper PHPDoc comments
3. Include validation for new features
4. Test thoroughly before submitting
5. Update documentation as needed

## License

This user management system is part of the CX Shipment Management System and follows the same licensing terms.

## Support

For support and questions:

- Check the troubleshooting section
- Review the CodeIgniter 3 documentation
- Consult the project's main documentation
