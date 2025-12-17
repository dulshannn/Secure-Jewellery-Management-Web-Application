@extends('layouts.auth')

@section('title', 'Secure Login')

@section('content')
<div class="bg-dark-card rounded-xl shadow-2xl overflow-hidden border-t-4 border-gold fade-in">
    <div class="p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-display font-bold text-gold mb-2">Welcome Back</h1>
            <p class="text-gray-400 text-sm">Authenticate to access the secure vault</p>
        </div>

        @if (session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg fade-in">
            <p class="text-green-400 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg fade-in error-shake">
            <p class="text-red-400 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg fade-in">
            <ul class="list-disc list-inside text-red-400 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="input-wrapper relative">
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autocomplete="username"
                    autofocus
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer"
                    placeholder="Username or Email"
                    aria-label="Username or Email"
                >
                <label
                    for="username"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Username or Email
                </label>
            </div>

            <div class="input-wrapper relative">
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer pr-12"
                    placeholder="Password"
                    aria-label="Password"
                >
                <label
                    for="password"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Password
                </label>
                <button
                    type="button"
                    onclick="togglePassword('password')"
                    class="absolute right-3 top-3 text-gray-400 hover:text-gold transition-colors"
                    aria-label="Toggle password visibility"
                >
                    <svg id="password-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="password-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>

            <div id="otpSection" class="hidden space-y-4 fade-in">
                <div class="input-wrapper relative">
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        maxlength="6"
                        pattern="[0-9]{6}"
                        class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold tracking-widest text-center text-lg font-semibold"
                        placeholder="000000"
                        aria-label="One-Time Password"
                    >
                    <label
                        for="otp"
                        class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                    >
                        Enter 6-Digit OTP
                    </label>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div id="otpTimer" class="text-gray-400">
                        <span class="text-gold">●</span> OTP valid for <span id="timeRemaining" class="text-gold font-semibold">05:00</span>
                    </div>
                    <button
                        type="button"
                        id="resendOtpBtn"
                        onclick="resendOtp()"
                        disabled
                        class="text-gold hover:text-gold-light transition-colors disabled:text-gray-600 disabled:cursor-not-allowed"
                    >
                        Resend OTP
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center space-x-2 cursor-pointer group">
                    <input
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 bg-dark-input border border-dark-border rounded focus:ring-2 focus:ring-gold/50 text-gold"
                    >
                    <span class="text-gray-400 group-hover:text-white transition-colors">Remember Me</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-gold hover:text-gold-light transition-colors">
                    Forgot Password?
                </a>
            </div>

            <div class="space-y-3">
                <button
                    type="button"
                    id="sendOtpBtn"
                    onclick="sendOtp()"
                    class="w-full px-6 py-3 border-2 border-gold text-gold rounded-lg font-semibold hover:bg-gold hover:text-dark-bg transition-all duration-300 flex items-center justify-center space-x-2"
                >
                    <span id="sendOtpText">Send OTP</span>
                    <svg id="sendOtpIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div id="sendOtpSpinner" class="spinner hidden"></div>
                </button>

                <button
                    type="submit"
                    id="loginBtn"
                    disabled
                    class="btn-gold w-full px-6 py-3 bg-gold text-dark-bg rounded-lg font-bold disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                >
                    <span id="loginText">Verify & Login</span>
                    <svg id="loginIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <div id="loginSpinner" class="spinner hidden"></div>
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-dark-border text-center">
            <p class="text-gray-400 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-gold hover:text-gold-light font-semibold transition-colors">
                    Create Account
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let otpTimer;
    let resendTimer;
    let timeLeft = 300;
    let resendTimeLeft = 60;

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eyeOpen = document.getElementById(`${inputId}-eye-open`);
        const eyeClosed = document.getElementById(`${inputId}-eye-closed`);

        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    async function sendOtp() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!username || !password) {
            showError('Please enter username and password first');
            return;
        }

        const sendOtpBtn = document.getElementById('sendOtpBtn');
        const sendOtpText = document.getElementById('sendOtpText');
        const sendOtpIcon = document.getElementById('sendOtpIcon');
        const sendOtpSpinner = document.getElementById('sendOtpSpinner');

        sendOtpBtn.disabled = true;
        sendOtpText.textContent = 'Sending...';
        sendOtpIcon.classList.add('hidden');
        sendOtpSpinner.classList.remove('hidden');

        try {
            const response = await fetch('{{ route("otp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username, password })
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById('otpSection').classList.remove('hidden');
                document.getElementById('loginBtn').disabled = false;
                document.getElementById('otp').focus();

                startOtpTimer();
                startResendTimer();

                showSuccess('OTP sent to your registered email');
            } else {
                showError(data.message || 'Failed to send OTP');
                sendOtpBtn.disabled = false;
            }
        } catch (error) {
            showError('Network error. Please try again.');
            sendOtpBtn.disabled = false;
        } finally {
            sendOtpText.textContent = 'Send OTP';
            sendOtpIcon.classList.remove('hidden');
            sendOtpSpinner.classList.add('hidden');
        }
    }

    function startOtpTimer() {
        timeLeft = 300;
        updateTimerDisplay();

        otpTimer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(otpTimer);
                showError('OTP expired. Please request a new one.');
                document.getElementById('otp').disabled = true;
                document.getElementById('loginBtn').disabled = true;
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        document.getElementById('timeRemaining').textContent =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function startResendTimer() {
        resendTimeLeft = 60;
        const resendBtn = document.getElementById('resendOtpBtn');
        resendBtn.disabled = true;
        resendBtn.textContent = `Resend in ${resendTimeLeft}s`;

        resendTimer = setInterval(() => {
            resendTimeLeft--;
            resendBtn.textContent = `Resend in ${resendTimeLeft}s`;

            if (resendTimeLeft <= 0) {
                clearInterval(resendTimer);
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend OTP';
            }
        }, 1000);
    }

    function resendOtp() {
        clearInterval(otpTimer);
        clearInterval(resendTimer);
        document.getElementById('otp').value = '';
        document.getElementById('otp').disabled = false;
        sendOtp();
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg fade-in error-shake';
        errorDiv.innerHTML = `<p class="text-red-400 text-sm">${message}</p>`;

        const form = document.getElementById('loginForm');
        form.insertBefore(errorDiv, form.firstChild);

        setTimeout(() => errorDiv.remove(), 5000);
    }

    function showSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg fade-in';
        successDiv.innerHTML = `<p class="text-green-400 text-sm">${message}</p>`;

        const form = document.getElementById('loginForm');
        form.insertBefore(successDiv, form.firstChild);

        setTimeout(() => successDiv.remove(), 5000);
    }

    document.getElementById('otp')?.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length === 6) {
            document.getElementById('loginBtn').classList.add('gold-glow');
        } else {
            document.getElementById('loginBtn').classList.remove('gold-glow');
        }
    });

    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        const loginBtn = document.getElementById('loginBtn');
        const loginText = document.getElementById('loginText');
        const loginIcon = document.getElementById('loginIcon');
        const loginSpinner = document.getElementById('loginSpinner');

        loginBtn.disabled = true;
        loginText.textContent = 'Verifying...';
        loginIcon.classList.add('hidden');
        loginSpinner.classList.remove('hidden');
    });
</script>
@endpush
