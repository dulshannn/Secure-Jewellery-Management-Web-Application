# Secure Jewellery Management - OTP Authentication System

## Overview
This authentication system provides enterprise-grade security with OTP-based two-factor authentication for the Secure Jewellery Management platform. Built with Laravel 10, Blade templating, and Tailwind CSS.

---

## Features

### Security Features
- **Multi-Factor Authentication**: Password + OTP verification
- **Email-based OTP**: 6-digit codes with 5-minute expiry
- **Rate Limiting**: 60-second cooldown on OTP resend
- **Session Management**: Secure session handling with Laravel
- **Activity Logging**: Complete audit trail of all authentication events
- **Role-Based Access Control**: Admin, Manager, Supplier, Customer roles
- **Password Strength Validation**: Enforces strong password requirements

### UX Features
- **Luxury Dark Theme**: Premium jewellery industry aesthetic
- **Floating Labels**: Modern input interaction patterns
- **Real-time Validation**: Instant feedback on form inputs
- **Password Strength Indicator**: Visual feedback on password quality
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Accessibility**: ARIA labels and keyboard navigation support
- **Loading States**: Clear visual feedback during async operations

---

## File Structure

```
project/
├── app/
│   ├── Http/Controllers/Auth/
│   │   └── AuthController.php          # Main authentication controller
│   └── Models/
│       └── User.php                     # User model with role methods
│
├── database/migrations/
│   ├── 2024_01_01_000000_create_users_table.php
│   └── 2024_01_01_000001_create_activity_logs_table.php
│
├── resources/views/
│   ├── layouts/
│   │   └── auth.blade.php              # Auth pages layout template
│   │
│   ├── auth/
│   │   ├── login.blade.php             # Login page with OTP
│   │   ├── register.blade.php          # Registration page
│   │   └── verify-otp.blade.php        # OTP verification page
│   │
│   └── emails/
│       └── otp.blade.php               # OTP email template
│
└── routes/
    └── auth.php                         # Authentication routes
```

---

## Installation & Setup

### 1. Prerequisites
- PHP 8.1 or higher
- Composer
- Laravel 10
- PostgreSQL or MySQL database
- Mail server configuration (SMTP)

### 2. Database Setup

Run the migrations to create required tables:

```bash
php artisan migrate
```

This creates:
- `users` table with fields: id, full_name, username, email, phone, password, role, is_active, email_verified_at
- `activity_logs` table for audit trails

### 3. Environment Configuration

Update your `.env` file with mail configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sjm.com
MAIL_FROM_NAME="Secure Jewellery Management"

APP_URL=http://localhost:8000
```

### 4. Cache Configuration

The OTP system uses Laravel's cache for temporary OTP storage. Configure your cache driver:

```env
CACHE_DRIVER=redis  # or 'file' for simpler setups
```

### 5. Route Registration

Add the auth routes to your main `routes/web.php`:

```php
require __DIR__.'/auth.php';
```

### 6. Middleware Configuration

Add role-based middleware to `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    // ... existing middleware
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## Usage Guide

### Registration Flow

1. **User Registration** (`/register`)
   - User fills out registration form
   - Password strength is validated in real-time
   - Account created in inactive state
   - OTP sent to email
   - Redirects to OTP verification page

2. **Email Verification** (`/verify-otp`)
   - User enters 6-digit OTP
   - 5-minute expiration timer displayed
   - Can resend OTP after 60-second cooldown
   - Upon success, account is activated
   - Redirects to login page

### Login Flow

1. **Initial Login** (`/login`)
   - User enters username/email and password
   - Clicks "Send OTP" button
   - Credentials validated server-side
   - OTP sent to registered email

2. **OTP Verification**
   - OTP input field appears
   - User enters 6-digit code
   - 5-minute timer counts down
   - Submit form to complete login

3. **Successful Authentication**
   - Session created with remember token (optional)
   - Activity logged in database
   - Redirected based on user role:
     - Admin → `/admin/dashboard`
     - Manager → `/manager/dashboard`
     - Supplier → `/supplier/portal`
     - Customer → `/customer/dashboard`

---

## API Endpoints

### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Display login form |
| POST | `/login` | Process login with OTP |
| GET | `/register` | Display registration form |
| POST | `/register` | Create new user account |
| POST | `/otp/send` | Send OTP to user email |
| GET | `/verify-otp` | Display OTP verification form |
| POST | `/verify-otp` | Verify OTP code |
| POST | `/otp/resend` | Resend OTP code |
| POST | `/check-availability` | Check username/email availability |
| POST | `/logout` | Logout user |

### Request/Response Examples

#### Send OTP Request
```json
POST /otp/send
{
  "username": "john.doe",
  "password": "SecurePass123!"
}
```

#### Send OTP Response
```json
{
  "success": true,
  "message": "OTP sent to your registered email"
}
```

#### Verify OTP Request
```json
POST /verify-otp
{
  "otp": "123456"
}
```

---

## Security Considerations

### Password Requirements
- Minimum 8 characters
- At least one uppercase letter
- At least one lowercase letter
- At least one number
- At least one special character

### OTP Security
- 6-digit numeric code
- 5-minute expiration
- Single-use only (cleared after verification)
- 60-second resend cooldown
- Stored in encrypted cache

### Session Security
- CSRF protection on all forms
- Session regeneration after login
- Secure cookie settings
- Activity logging for audit trails

### Rate Limiting
- Login attempts: 5 per minute per IP
- OTP requests: 1 per 60 seconds per user
- Registration: 3 per hour per IP

---

## Customization Guide

### Changing Colors

Update Tailwind config in `auth.blade.php`:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'gold': '#d4af37',        // Change primary color
                'gold-dark': '#b5952f',   // Change hover state
                // ... other colors
            }
        }
    }
}
```

### Modifying OTP Expiry Time

In `AuthController.php`, update the expiry duration:

```php
private function storeOtp(string $email, string $otp): void
{
    cache()->put("otp_{$email}", [
        'code' => $otp,
        'expires_at' => now()->addMinutes(10) // Change from 5 to 10 minutes
    ], now()->addMinutes(10));
}
```

### Customizing Email Template

Edit `resources/views/emails/otp.blade.php` to match your brand:
- Change header colors
- Update logo/branding
- Modify email copy
- Add company information

### Adding New Roles

Update the User model and migration:

1. Add role to migration enum:
```php
$table->enum('role', ['Admin', 'Manager', 'Supplier', 'Customer', 'NewRole']);
```

2. Add role method to User model:
```php
public function isNewRole(): bool
{
    return $this->role === 'NewRole';
}
```

3. Update redirect logic in AuthController:
```php
return match($user->role) {
    'NewRole' => redirect()->route('newrole.dashboard'),
    // ... existing roles
};
```

---

## Troubleshooting

### Common Issues

**Issue**: OTP emails not sending
- **Solution**: Check `.env` mail configuration
- Verify SMTP credentials
- Check mail logs: `php artisan queue:work --verbose`

**Issue**: OTP expired immediately
- **Solution**: Verify cache is working: `php artisan cache:clear`
- Check system time is synchronized

**Issue**: Session lost during OTP verification
- **Solution**: Ensure session driver is configured correctly
- Check `SESSION_DRIVER` in `.env`

**Issue**: Password validation failing
- **Solution**: Ensure password meets all requirements
- Check Laravel validation rules in controller

**Issue**: Floating labels not working
- **Solution**: Verify JavaScript is loaded
- Check browser console for errors

### Debug Mode

Enable debug logging in `AuthController.php`:

```php
use Illuminate\Support\Facades\Log;

Log::info('OTP sent to: ' . $email);
Log::info('OTP code: ' . $otp); // Remove in production!
```

---

## Testing

### Manual Testing Checklist

**Registration:**
- [ ] Form validation works for all fields
- [ ] Password strength indicator updates in real-time
- [ ] Username/email availability check works
- [ ] Password confirmation matches validation
- [ ] OTP email is received
- [ ] Account created in inactive state

**OTP Verification:**
- [ ] 6-digit input accepts only numbers
- [ ] Timer counts down correctly
- [ ] Resend button disabled for 60 seconds
- [ ] OTP expires after 5 minutes
- [ ] Account activated after successful verification

**Login:**
- [ ] Send OTP validates credentials first
- [ ] OTP input appears after sending
- [ ] Invalid OTP shows error
- [ ] Successful login redirects based on role
- [ ] Remember me checkbox works
- [ ] Activity logged in database

### Automated Testing

Create feature tests in `tests/Feature/AuthTest.php`:

```php
public function test_user_can_register_with_valid_data()
{
    $response = $this->post('/register', [
        'full_name' => 'John Doe',
        'username' => 'johndoe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'password' => 'SecurePass123!',
        'password_confirmation' => 'SecurePass123!',
        'terms' => true
    ]);

    $response->assertRedirect('/verify-otp');
    $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
}
```

---

## Performance Optimization

### Caching
- OTP codes cached for 5 minutes
- User sessions cached
- Route caching: `php artisan route:cache`
- View caching: `php artisan view:cache`

### Database Indexing
- Username and email indexed for fast lookups
- Role and is_active indexed for filtering
- Activity logs indexed on user_id and created_at

### Frontend Optimization
- Tailwind CSS loaded via CDN (consider building for production)
- Minimal JavaScript dependencies
- Lazy loading for non-critical assets

---

## Production Deployment

### Pre-deployment Checklist

- [ ] Change `APP_DEBUG` to `false` in `.env`
- [ ] Set secure `APP_KEY`: `php artisan key:generate`
- [ ] Configure production mail server
- [ ] Enable HTTPS/SSL
- [ ] Set secure session cookies
- [ ] Configure rate limiting
- [ ] Set up log rotation
- [ ] Enable caching (Redis recommended)
- [ ] Run database backups
- [ ] Test OTP email delivery

### Security Hardening

```env
APP_ENV=production
APP_DEBUG=false
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict
```

### Monitoring

Monitor these metrics:
- Failed login attempts per IP
- OTP request frequency
- Email delivery success rate
- Session creation rate
- Activity log growth

---

## Support & Documentation

### Additional Resources
- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com
- Laravel Sanctum: https://laravel.com/docs/sanctum

### Contact
For technical support or questions about this authentication system, contact your development team.

---

## License
This authentication system is part of the Secure Jewellery Management platform. All rights reserved.

---

**Last Updated**: December 2024
**Version**: 1.0.0
**Laravel Version**: 10.x
**Tailwind CSS Version**: 3.x
