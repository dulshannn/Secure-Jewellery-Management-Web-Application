# Secure Jewellery Management - OTP Authentication System

A luxury-themed, enterprise-grade authentication system with OTP verification built for Laravel 10.

![Version](https://img.shields.io/badge/version-1.0.0-gold)
![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/license-Proprietary-gold)

---

## Overview

This authentication system provides a complete, production-ready solution for secure user authentication with the following features:

- **Multi-Factor Authentication**: Password + Email OTP verification
- **Luxury Dark UI**: Premium jewellery industry aesthetic with Tailwind CSS
- **Role-Based Access Control**: Admin, Manager, Supplier, Customer roles
- **Email Verification**: OTP-based email verification for new accounts
- **Activity Logging**: Complete audit trail of authentication events
- **Security Hardened**: CSRF protection, rate limiting, session management

---

## Features Breakdown

### Authentication Pages

#### 1. Login Page (`/login`)
- Username/Email and password authentication
- OTP verification via email
- 5-minute OTP expiry with countdown timer
- 60-second resend cooldown
- Remember me functionality
- Forgot password link
- Real-time validation feedback

#### 2. Registration Page (`/register`)
- Comprehensive user registration form
- Real-time password strength indicator
- Username/email availability checking
- Password confirmation matching
- Terms of service acceptance
- Automatic email verification flow

#### 3. OTP Verification Page (`/verify-otp`)
- 6-digit OTP input with auto-focus
- Visual timer countdown
- Resend OTP functionality
- Paste support for OTP codes
- Keyboard navigation between digits

#### 4. Forgot Password Page (`/password/reset`)
- Email-based password reset
- Secure reset link generation
- Link expiry handling

---

## Design System

### Color Palette

```css
Primary Gold:    #d4af37
Gold Dark:       #b5952f
Gold Light:      #f9e5b9
Background:      #1a1a1a
Card Background: #2c2c2c
Input Background:#1f1f1f
Border:          #444444
Text Primary:    #ffffff
Text Muted:      #cccccc
Error:           #ef4444
Success:         #22c55e
```

### Typography

- **Display Font**: Playfair Display (headings, titles)
- **Body Font**: Inter (paragraphs, forms)
- **Mono Font**: Courier New (OTP codes)

### UI Components

- Floating label inputs with smooth transitions
- Gold glow effects on hover and focus states
- Loading spinners for async operations
- Animated error shake on validation failures
- Fade-in animations for page elements

---

## File Structure

```
project/
├── app/
│   ├── Http/
│   │   ├── Controllers/Auth/
│   │   │   └── AuthController.php      # Authentication logic
│   │   └── Middleware/
│   │       └── CheckRole.php            # Role-based access control
│   └── Models/
│       └── User.php                      # User model with roles
│
├── database/migrations/
│   ├── 2024_01_01_000000_create_users_table.php
│   └── 2024_01_01_000001_create_activity_logs_table.php
│
├── resources/views/
│   ├── layouts/
│   │   └── auth.blade.php               # Base layout for auth pages
│   ├── auth/
│   │   ├── login.blade.php              # Login page
│   │   ├── register.blade.php           # Registration page
│   │   ├── verify-otp.blade.php         # OTP verification page
│   │   └── forgot-password.blade.php    # Password reset page
│   └── emails/
│       └── otp.blade.php                # OTP email template
│
├── routes/
│   └── auth.php                          # Authentication routes
│
├── AUTH_SETUP_DOCUMENTATION.md           # Full documentation
├── QUICK_START_GUIDE.md                  # Quick setup guide
└── .env.example                          # Environment configuration template
```

---

## Quick Installation

### Prerequisites

- PHP 8.1+
- Composer
- Laravel 10
- PostgreSQL or MySQL
- SMTP mail server

### Installation Steps

```bash
# 1. Install dependencies
composer install

# 2. Configure environment
cp .env.example .env
php artisan key:generate

# 3. Update .env with your database and mail settings

# 4. Run migrations
php artisan migrate

# 5. Register auth routes in routes/web.php
# Add: require __DIR__.'/auth.php';

# 6. Add middleware to app/Http/Kernel.php
# 'role' => \App\Http\Middleware\CheckRole::class,

# 7. Start server
php artisan serve
```

Visit `http://localhost:8000/register` to create your first account!

---

## Usage Examples

### Protecting Routes with Roles

```php
// Admin only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
});

// Multiple roles
Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
});

// Any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
});
```

### Checking User Roles in Views

```blade
@if(auth()->user()->isAdmin())
    <a href="/admin">Admin Panel</a>
@endif

@if(auth()->user()->isManager())
    <a href="/manager">Management</a>
@endif

@if(auth()->user()->isCustomer())
    <a href="/orders">My Orders</a>
@endif
```

### Checking User Roles in Controllers

```php
public function index()
{
    if (auth()->user()->isAdmin()) {
        return view('admin.dashboard');
    }

    if (auth()->user()->isManager()) {
        return view('manager.dashboard');
    }

    return view('user.dashboard');
}
```

---

## Authentication Flow

### Registration Flow

```
User Registration
     ↓
Account Created (Inactive)
     ↓
OTP Sent to Email
     ↓
User Enters OTP
     ↓
Email Verified
     ↓
Account Activated
     ↓
Redirect to Login
```

### Login Flow

```
User Enters Credentials
     ↓
Credentials Validated
     ↓
OTP Sent to Email
     ↓
User Enters OTP
     ↓
OTP Verified
     ↓
Session Created
     ↓
Activity Logged
     ↓
Redirect Based on Role
```

---

## API Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/login` | Display login form | No |
| POST | `/login` | Process login with OTP | No |
| GET | `/register` | Display registration form | No |
| POST | `/register` | Create new account | No |
| POST | `/otp/send` | Send OTP to email | No |
| GET | `/verify-otp` | Display OTP verification | No |
| POST | `/verify-otp` | Verify OTP code | No |
| POST | `/otp/resend` | Resend OTP | No |
| POST | `/check-availability` | Check username/email | No |
| GET | `/password/reset` | Display forgot password | No |
| POST | `/logout` | Logout user | Yes |

---

## Security Features

### Password Requirements
- Minimum 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character

### OTP Security
- 6-digit numeric code
- 5-minute expiration
- Single-use (cleared after verification)
- 60-second resend cooldown
- Encrypted cache storage

### Session Security
- CSRF protection on all forms
- Session regeneration after login
- HTTP-only cookies
- Secure cookie flag in production
- Activity logging for audit trails

### Rate Limiting
- Login attempts: 5 per minute per IP
- OTP requests: 1 per 60 seconds
- Registration: 3 per hour per IP

---

## Email Templates

### OTP Email Features
- Luxury dark theme matching web design
- Clear OTP display with monospace font
- Expiry warning
- Security notice
- Responsive design
- Brand consistency

### Email Configuration

Update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sjm.com
MAIL_FROM_NAME="Secure Jewellery Management"
```

---

## Customization

### Changing Brand Colors

Edit `resources/views/layouts/auth.blade.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'gold': '#YOUR_COLOR',
                'gold-dark': '#YOUR_COLOR',
                // ... other colors
            }
        }
    }
}
```

### Customizing OTP Expiry

Edit `app/Http/Controllers/Auth/AuthController.php`:

```php
private function storeOtp(string $email, string $otp): void
{
    cache()->put("otp_{$email}", [
        'code' => $otp,
        'expires_at' => now()->addMinutes(10) // Change to desired minutes
    ], now()->addMinutes(10));
}
```

### Adding New User Roles

1. Update migration:
```php
$table->enum('role', ['Admin', 'Manager', 'Supplier', 'Customer', 'YourNewRole']);
```

2. Add method to User model:
```php
public function isYourNewRole(): bool
{
    return $this->role === 'YourNewRole';
}
```

3. Update redirect logic in AuthController

---

## Testing

### Manual Testing

Create test accounts with different roles:

```bash
php artisan tinker

# Create Admin
\App\Models\User::create([
    'full_name' => 'Admin User',
    'username' => 'admin',
    'email' => 'admin@sjm.com',
    'phone' => '1234567890',
    'password' => bcrypt('Admin123!@#'),
    'role' => 'Admin',
    'is_active' => true,
    'email_verified_at' => now()
]);
```

### Automated Testing

Run feature tests:

```bash
php artisan test
```

Create custom tests in `tests/Feature/AuthTest.php`

---

## Troubleshooting

### Common Issues & Solutions

**OTP emails not sending**
- Check `.env` mail configuration
- Test with log driver: `MAIL_MAILER=log`
- Check `storage/logs/laravel.log`

**Session issues**
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`

**CSRF token mismatch**
- Ensure `APP_URL` matches your actual URL
- Clear browser cookies
- Check session configuration

**Database connection failed**
- Verify database credentials in `.env`
- Check database server is running
- Test connection: `php artisan migrate:status`

---

## Performance Optimization

### Recommended Settings

**Development:**
```env
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Production:**
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Optimization Commands

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

---

## Production Deployment

### Pre-deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production mail server
- [ ] Enable HTTPS/SSL
- [ ] Set secure session cookies
- [ ] Configure rate limiting
- [ ] Set up log rotation
- [ ] Enable Redis caching
- [ ] Run database backups
- [ ] Test email delivery

### Security Hardening

```env
APP_ENV=production
APP_DEBUG=false
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
```

---

## Documentation

- **Full Documentation**: `AUTH_SETUP_DOCUMENTATION.md`
- **Quick Start Guide**: `QUICK_START_GUIDE.md`
- **Laravel Docs**: https://laravel.com/docs
- **Tailwind CSS**: https://tailwindcss.com

---

## Support

For technical support or bug reports:
- Review documentation files
- Check Laravel logs: `storage/logs/laravel.log`
- Contact your development team

---

## Screenshots

### Login Page
- Luxury dark theme with gold accents
- Floating label inputs
- OTP verification section
- Remember me option

### Registration Page
- Real-time password strength indicator
- Username/email availability checking
- Terms acceptance checkbox
- Comprehensive validation

### OTP Verification
- 6-digit input with auto-focus
- Visual countdown timer
- Resend functionality
- Paste support

---

## License

Proprietary - Secure Jewellery Management System
All rights reserved © 2024

---

## Credits

**Designed & Developed for**: Secure Jewellery Management Platform
**Tech Stack**: Laravel 10, Blade, Tailwind CSS, Vanilla JavaScript
**Design Theme**: Luxury Dark Security Aesthetic
**Framework**: Laravel 10.x
**Version**: 1.0.0
**Last Updated**: December 2024

---

**Get Started Now!**

```bash
composer install && php artisan migrate && php artisan serve
```

Visit `http://localhost:8000/register` and create your first account!
