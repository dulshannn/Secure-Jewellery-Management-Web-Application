# Quick Start Guide - OTP Authentication System

Get your Secure Jewellery Management authentication system up and running in 10 minutes.

---

## Step 1: Install Dependencies (1 min)

```bash
composer install
npm install
```

---

## Step 2: Configure Environment (2 min)

Copy `.env.example` to `.env` and update:

```bash
cp .env.example .env
php artisan key:generate
```

Update database settings in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=jewellery_secure_db
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

Update mail settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sjm.com
MAIL_FROM_NAME="Secure Jewellery Management"
```

---

## Step 3: Setup Database (2 min)

```bash
php artisan migrate
```

---

## Step 4: Register Routes (1 min)

Add to `routes/web.php`:

```php
require __DIR__.'/auth.php';
```

---

## Step 5: Configure Middleware (2 min)

Add to `app/Http/Kernel.php` in `$routeMiddleware` array:

```php
'role' => \App\Http\Middleware\CheckRole::class,
```

---

## Step 6: Start Development Server (1 min)

```bash
php artisan serve
```

Visit: `http://localhost:8000/register`

---

## Step 7: Test the System (1 min)

### Register a New Account

1. Go to `http://localhost:8000/register`
2. Fill in the form:
   - Full Name: Test User
   - Username: testuser
   - Email: test@example.com
   - Phone: 1234567890
   - Password: Test123!@#
   - Confirm Password: Test123!@#
   - Check "I agree" checkbox
3. Click "Create Account"

### Verify Email

1. Check your email for the OTP (or check logs if using Mailtrap)
2. Enter the 6-digit code
3. Click "Verify & Continue"

### Login

1. Go to `http://localhost:8000/login`
2. Enter username: `testuser`
3. Enter password: `Test123!@#`
4. Click "Send OTP"
5. Enter OTP from email
6. Click "Verify & Login"

---

## Protected Routes Example

Create protected routes in `routes/web.php`:

```php
// Admin only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Manager and Admin
Route::middleware(['auth', 'role:Admin,Manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
});

// Supplier only
Route::middleware(['auth', 'role:Supplier'])->group(function () {
    Route::get('/supplier/portal', function () {
        return view('supplier.portal');
    })->name('supplier.portal');
});

// Customer only
Route::middleware(['auth', 'role:Customer'])->group(function () {
    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');
});
```

---

## Development Tips

### Viewing OTP Codes in Development

If you're using Mailtrap or log driver, view sent emails:

**Using Log Driver:**
```env
MAIL_MAILER=log
```

Check `storage/logs/laravel.log` for OTP codes.

**Using Mailtrap:**
- Visit https://mailtrap.io
- Check your inbox for emails

### Clearing Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Seeding Test Users

Create `database/seeders/UserSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'full_name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@sjm.com',
            'phone' => '1234567890',
            'password' => Hash::make('Admin123!@#'),
            'role' => 'Admin',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        User::create([
            'full_name' => 'Manager User',
            'username' => 'manager',
            'email' => 'manager@sjm.com',
            'phone' => '0987654321',
            'password' => Hash::make('Manager123!@#'),
            'role' => 'Manager',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        User::create([
            'full_name' => 'Customer User',
            'username' => 'customer',
            'email' => 'customer@sjm.com',
            'phone' => '5555555555',
            'password' => Hash::make('Customer123!@#'),
            'role' => 'Customer',
            'is_active' => true,
            'email_verified_at' => now()
        ]);
    }
}
```

Run seeder:
```bash
php artisan db:seed --class=UserSeeder
```

---

## Troubleshooting Quick Fixes

### Issue: "Class 'User' not found"
**Fix**: Run `composer dump-autoload`

### Issue: "No such table: users"
**Fix**: Run `php artisan migrate`

### Issue: OTP emails not sending
**Fix**:
1. Check `.env` mail settings
2. Try log driver: `MAIL_MAILER=log`
3. Check `storage/logs/laravel.log`

### Issue: "Session store not set on request"
**Fix**:
1. Clear config: `php artisan config:clear`
2. Check `SESSION_DRIVER` in `.env`

### Issue: CSRF token mismatch
**Fix**:
1. Clear cache: `php artisan cache:clear`
2. Check `APP_URL` matches your actual URL

---

## Next Steps

After successful setup:

1. Read full documentation: `AUTH_SETUP_DOCUMENTATION.md`
2. Create your dashboard views
3. Customize the design to match your brand
4. Add role-specific features
5. Set up production mail server
6. Configure rate limiting
7. Enable logging and monitoring

---

## Production Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure real mail server
- [ ] Enable HTTPS
- [ ] Set secure cookies
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set up database backups
- [ ] Configure log rotation
- [ ] Test all flows thoroughly

---

## Support

For detailed documentation, see: `AUTH_SETUP_DOCUMENTATION.md`

For issues or questions, contact your development team.

---

**Quick Start Complete!**

You now have a fully functional OTP-based authentication system with:
- User registration with email verification
- OTP-based login
- Role-based access control
- Activity logging
- Luxury dark UI design

Happy coding!
