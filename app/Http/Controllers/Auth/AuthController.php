<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'terms' => ['accepted']
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'is_active' => false,
            'role' => 'Customer'
        ]);

        $otp = $this->generateOtp();
        $this->storeOtp($user->email, $otp);

        $this->sendOtpEmail($user->email, $otp, $user->full_name);

        Session::put('verification_email', $user->email);
        Session::put('pending_user_id', $user->id);

        return redirect()->route('otp.verify.form')
            ->with('success', 'Account created! Please verify your email with the OTP sent.');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account not activated. Please verify your email first.'
            ], 403);
        }

        $otp = $this->generateOtp();
        $this->storeOtp($user->email, $otp);

        $this->sendOtpEmail($user->email, $otp, $user->full_name);

        Session::put('login_email', $user->email);
        Session::put('login_user_id', $user->id);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent to your registered email'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors(['username' => 'Account not activated'])->withInput();
        }

        if (!$this->verifyOtp($user->email, $request->otp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP'])->withInput();
        }

        auth()->login($user, $request->has('remember'));

        $this->clearOtp($user->email);

        $request->session()->regenerate();

        $this->logActivity($user->id, 'login', 'User logged in successfully');

        return $this->redirectBasedOnRole($user);
    }

    public function showOtpVerifyForm()
    {
        if (!Session::has('verification_email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', [
            'email' => Session::get('verification_email')
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $email = Session::get('verification_email');
        $userId = Session::get('pending_user_id');

        if (!$email || !$userId) {
            return back()->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        if (!$this->verifyOtpCode($email, $request->otp)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $user = User::find($userId);
        if ($user) {
            $user->is_active = true;
            $user->email_verified_at = now();
            $user->save();

            $this->clearOtp($email);

            Session::forget(['verification_email', 'pending_user_id']);

            return redirect()->route('login')
                ->with('success', 'Email verified successfully! You can now login.');
        }

        return back()->withErrors(['otp' => 'User not found']);
    }

    public function resendOtp(Request $request)
    {
        $email = Session::get('verification_email') ?? Session::get('login_email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired'
            ], 400);
        }

        $otp = $this->generateOtp();
        $this->storeOtp($email, $otp);

        $user = User::where('email', $email)->first();
        $this->sendOtpEmail($email, $otp, $user->full_name ?? 'User');

        return response()->json([
            'success' => true,
            'message' => 'New OTP sent successfully'
        ]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'field' => 'required|in:username,email',
            'value' => 'required|string'
        ]);

        $exists = User::where($request->field, $request->value)->exists();

        return response()->json([
            'available' => !$exists
        ]);
    }

    public function logout(Request $request)
    {
        $this->logActivity(auth()->id(), 'logout', 'User logged out');

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function generateOtp(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function storeOtp(string $email, string $otp): void
    {
        cache()->put("otp_{$email}", [
            'code' => $otp,
            'expires_at' => now()->addMinutes(5)
        ], now()->addMinutes(5));
    }

    private function verifyOtpCode(string $email, string $otp): bool
    {
        $storedOtp = cache()->get("otp_{$email}");

        if (!$storedOtp) {
            return false;
        }

        if (now()->isAfter($storedOtp['expires_at'])) {
            $this->clearOtp($email);
            return false;
        }

        return $storedOtp['code'] === $otp;
    }

    private function clearOtp(string $email): void
    {
        cache()->forget("otp_{$email}");
    }

    private function sendOtpEmail(string $email, string $otp, string $name): void
    {
        Mail::send('emails.otp', compact('otp', 'name'), function ($message) use ($email) {
            $message->to($email)
                ->subject('Your OTP Code - Secure Jewellery Management');
        });
    }

    private function redirectBasedOnRole(User $user)
    {
        return match($user->role) {
            'Admin' => redirect()->route('admin.dashboard'),
            'Manager' => redirect()->route('manager.dashboard'),
            'Supplier' => redirect()->route('supplier.portal'),
            'Customer' => redirect()->route('customer.dashboard'),
            default => redirect()->route('dashboard')
        };
    }

    private function logActivity(int $userId, string $action, string $description): void
    {
        \DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now()
        ]);
    }
}
