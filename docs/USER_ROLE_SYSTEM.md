# User Role Determination System

This document explains the comprehensive user role determination system implemented in the Laravel application to separate Admin and User access.

## Overview

The system provides multiple ways to determine whether a user is an Admin or regular User:

1. **Dual Authentication System**: Separate guards for Admin (`admin`) and User (`web`)
2. **Role-based System**: Role column in users table with values `admin` or `user`
3. **Unified Services**: Centralized services to handle role determination
4. **Helper Classes**: Easy-to-use helper methods for controllers and views

## Components

### 1. Models

#### User Model (`app/Models/User.php`)
- Added `role` to fillable attributes
- Helper methods:
  - `isAdmin()`: Check if user has admin role
  - `isUser()`: Check if user has user role
  - `getRole()`: Get user's role

#### Admin Model (`app/Models/Admin.php`)
- Separate model for admin authentication via `admin` guard

### 2. Authentication Configuration (`config/auth.php`)

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],
```

### 3. Services

#### UserRoleService (`app/Services/UserRoleService.php`)
Centralized service for role determination:

```php
// Check roles
UserRoleService::isAdmin()
UserRoleService::isUser()
UserRoleService::getCurrentUserRole()
UserRoleService::getCurrentUser()
UserRoleService::isAuthenticated()
UserRoleService::getCurrentGuard()
UserRoleService::getRedirectPath()
```

### 4. Helper Class

#### AuthHelper (`app/Helpers/AuthHelper.php`)
Simplified interface for common operations:

```php
// Basic checks
AuthHelper::isAdmin()
AuthHelper::isUser()
AuthHelper::isAuthenticated()

// User information
AuthHelper::getUserRole()
AuthHelper::getCurrentUser()
AuthHelper::getUserName()
AuthHelper::getUserEmail()
AuthHelper::getUserTypeDisplay()

// Utilities
AuthHelper::hasRole('admin')
AuthHelper::getRedirectPath()
AuthHelper::logout()
```

### 5. Middleware

#### AdminMiddleware (`app/Http/Middleware/AdminMiddleware.php`)
```php
public function handle(Request $request, Closure $next): Response
{
    if (UserRoleService::isAdmin()) {
        return $next($request);
    }
    abort(403, 'Unauthorized action.');
}
```

#### IsUser (`app/Http/Middleware/IsUser.php`)
```php
public function handle($request, Closure $next)
{
    if (UserRoleService::isUser()) {
        return $next($request);
    }
    return redirect('/');
}
```

#### IsAdmin (`app/Http/Middleware/IsAdmin.php`)
```php
public function handle(Request $request, Closure $next)
{
    if (Auth::guard('admin')->check()) {
        return $next($request);
    }
    return redirect('/admin/login')->with('error', 'Access denied.');
}
```

## Usage Examples

### In Controllers

```php
use App\Helpers\AuthHelper;
use App\Services\UserRoleService;

class ExampleController extends Controller
{
    public function index()
    {
        if (AuthHelper::isAdmin()) {
            // Admin-specific logic
            return view('admin.dashboard');
        }
        
        if (AuthHelper::isUser()) {
            // User-specific logic
            return view('user.dashboard');
        }
        
        return redirect('/login');
    }
    
    public function adminOnly()
    {
        if (!UserRoleService::isAdmin()) {
            abort(403, 'Admin access required');
        }
        
        // Admin-only code here
    }
}
```

### In Blade Views

```blade
@if(App\Helpers\AuthHelper::isAdmin())
    <div class="admin-panel">
        <!-- Admin content -->
    </div>
@endif

@if(App\Helpers\AuthHelper::isUser())
    <div class="user-panel">
        <!-- User content -->
    </div>
@endif

<p>Welcome, {{ App\Helpers\AuthHelper::getUserName() }}!</p>
<p>You are logged in as: {{ App\Helpers\AuthHelper::getUserTypeDisplay() }}</p>
```

### In Routes

```php
// Using middleware
Route::middleware(['auth:admin', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::middleware(['auth:web', 'is_user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard']);
});
```

## Testing the System

### Test Routes Available

1. **Role Information Page**: `/test-roles/info`
   - Visual display of current user's role information
   
2. **API Test**: `/test-roles/api`
   - JSON response with complete role data
   
3. **Admin Only Test**: `/test-roles/admin-only`
   - Tests admin-only access
   
4. **User Only Test**: `/test-roles/user-only`
   - Tests user-only access

### Test Controller (`app/Http/Controllers/RoleTestController.php`)

Provides comprehensive testing methods for the role system.

## Database Schema

### Users Table
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) DEFAULT 'user', -- 'admin' or 'user'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Admins Table
```sql
CREATE TABLE admins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## Best Practices

1. **Use Services**: Always use `UserRoleService` or `AuthHelper` instead of direct Auth calls
2. **Consistent Middleware**: Use the updated middleware for route protection
3. **Guard Awareness**: Be aware of which guard is being used for authentication
4. **Fallback Logic**: Always provide fallback logic for unauthenticated users
5. **Testing**: Use the provided test routes to verify role determination

## Security Considerations

1. **Double Authentication**: The system supports both guard-based and role-based authentication
2. **Middleware Protection**: All sensitive routes should be protected with appropriate middleware
3. **Role Validation**: Always validate roles on both client and server side
4. **Session Management**: Proper logout handling for both guards

## Migration Path

If you have existing users, run the migration to add the role column:

```bash
php artisan migrate
```

The migration adds a `role` column with default value `'user'` to the users table.

## Troubleshooting

1. **Role not detected**: Ensure the user has the correct role value in the database
2. **Guard issues**: Check which guard the user is authenticated with
3. **Middleware conflicts**: Ensure middleware is applied in the correct order
4. **Session problems**: Clear sessions if switching between authentication methods

## Future Enhancements

1. **Multiple Roles**: Extend to support multiple roles per user
2. **Permissions**: Add permission-based access control
3. **Role Hierarchy**: Implement role inheritance
4. **Dynamic Roles**: Allow runtime role assignment