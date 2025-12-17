@extends('layouts.auth')

@section('title', 'Register Account')

@section('content')
<div class="bg-dark-card rounded-xl shadow-2xl overflow-hidden border-t-4 border-gold fade-in">
    <div class="p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-display font-bold text-gold mb-2">Create Account</h1>
            <p class="text-gray-400 text-sm">Join the secure jewellery management network</p>
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

        <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="input-wrapper relative">
                <input
                    type="text"
                    id="full_name"
                    name="full_name"
                    value="{{ old('full_name') }}"
                    required
                    autocomplete="name"
                    autofocus
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer"
                    placeholder="Full Name"
                    aria-label="Full Name"
                >
                <label
                    for="full_name"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Full Name
                </label>
                @error('full_name')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-wrapper relative">
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autocomplete="username"
                    pattern="[a-zA-Z0-9_]{3,20}"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer"
                    placeholder="Username"
                    aria-label="Username"
                >
                <label
                    for="username"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Username (3-20 characters)
                </label>
                @error('username')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-wrapper relative">
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer"
                    placeholder="Email Address"
                    aria-label="Email Address"
                >
                <label
                    for="email"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Email Address
                </label>
                @error('email')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-wrapper relative">
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    autocomplete="tel"
                    pattern="[0-9+\-\s()]{10,15}"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer"
                    placeholder="Phone Number"
                    aria-label="Phone Number"
                >
                <label
                    for="phone"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Phone Number
                </label>
                @error('phone')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-wrapper relative">
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    minlength="8"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer pr-12"
                    placeholder="Password"
                    aria-label="Password"
                >
                <label
                    for="password"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Password (min. 8 characters)
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
                @error('password')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="passwordStrength" class="hidden">
                <div class="flex items-center space-x-2 mb-2">
                    <div class="flex-1 h-1.5 bg-dark-border rounded-full overflow-hidden">
                        <div id="strengthBar" class="h-full transition-all duration-300" style="width: 0%;"></div>
                    </div>
                    <span id="strengthText" class="text-xs font-semibold"></span>
                </div>
                <ul id="passwordRequirements" class="text-xs space-y-1">
                    <li id="req-length" class="text-gray-500">
                        <span class="requirement-icon">○</span> At least 8 characters
                    </li>
                    <li id="req-uppercase" class="text-gray-500">
                        <span class="requirement-icon">○</span> One uppercase letter
                    </li>
                    <li id="req-lowercase" class="text-gray-500">
                        <span class="requirement-icon">○</span> One lowercase letter
                    </li>
                    <li id="req-number" class="text-gray-500">
                        <span class="requirement-icon">○</span> One number
                    </li>
                    <li id="req-special" class="text-gray-500">
                        <span class="requirement-icon">○</span> One special character
                    </li>
                </ul>
            </div>

            <div class="input-wrapper relative">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    minlength="8"
                    class="input-field w-full px-4 py-3 bg-dark-input border border-dark-border rounded-lg text-white placeholder-transparent focus:outline-none focus:border-gold peer pr-12"
                    placeholder="Confirm Password"
                    aria-label="Confirm Password"
                >
                <label
                    for="password_confirmation"
                    class="label-float absolute left-4 top-3 text-gray-400 text-sm pointer-events-none origin-left"
                >
                    Confirm Password
                </label>
                <button
                    type="button"
                    onclick="togglePassword('password_confirmation')"
                    class="absolute right-3 top-3 text-gray-400 hover:text-gold transition-colors"
                    aria-label="Toggle password confirmation visibility"
                >
                    <svg id="password_confirmation-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="password_confirmation-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
                <div id="passwordMatch" class="text-xs mt-1 hidden"></div>
                @error('password_confirmation')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-dark-input border border-dark-border rounded-lg p-4">
                <label class="flex items-start space-x-3 cursor-pointer group">
                    <input
                        type="checkbox"
                        name="terms"
                        id="terms"
                        required
                        class="mt-0.5 w-4 h-4 bg-dark-input border border-dark-border rounded focus:ring-2 focus:ring-gold/50 text-gold"
                    >
                    <span class="text-gray-400 text-sm group-hover:text-white transition-colors">
                        I agree to the <a href="#" class="text-gold hover:text-gold-light">Terms of Service</a> and <a href="#" class="text-gold hover:text-gold-light">Privacy Policy</a>
                    </span>
                </label>
            </div>

            <button
                type="submit"
                id="registerBtn"
                class="btn-gold w-full px-6 py-3 bg-gold text-dark-bg rounded-lg font-bold flex items-center justify-center space-x-2"
            >
                <span id="registerText">Create Account</span>
                <svg id="registerIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <div id="registerSpinner" class="spinner hidden"></div>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-dark-border text-center">
            <p class="text-gray-400 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-gold hover:text-gold-light font-semibold transition-colors">
                    Sign In
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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

    const passwordInput = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const strengthSection = document.getElementById('passwordStrength');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    const passwordMatch = document.getElementById('passwordMatch');

    passwordInput.addEventListener('focus', () => {
        strengthSection.classList.remove('hidden');
    });

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };

        Object.keys(requirements).forEach(req => {
            const element = document.getElementById(`req-${req}`);
            if (requirements[req]) {
                strength++;
                element.classList.remove('text-gray-500');
                element.classList.add('text-green-400');
                element.querySelector('.requirement-icon').textContent = '●';
            } else {
                element.classList.remove('text-green-400');
                element.classList.add('text-gray-500');
                element.querySelector('.requirement-icon').textContent = '○';
            }
        });

        const percentage = (strength / 5) * 100;
        strengthBar.style.width = `${percentage}%`;

        if (strength <= 2) {
            strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
            strengthText.textContent = 'Weak';
            strengthText.className = 'text-xs font-semibold text-red-400';
        } else if (strength <= 3) {
            strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
            strengthText.textContent = 'Fair';
            strengthText.className = 'text-xs font-semibold text-yellow-400';
        } else if (strength <= 4) {
            strengthBar.className = 'h-full transition-all duration-300 bg-blue-500';
            strengthText.textContent = 'Good';
            strengthText.className = 'text-xs font-semibold text-blue-400';
        } else {
            strengthBar.className = 'h-full transition-all duration-300 bg-green-500';
            strengthText.textContent = 'Strong';
            strengthText.className = 'text-xs font-semibold text-green-400';
        }

        checkPasswordMatch();
    });

    passwordConfirmation.addEventListener('input', checkPasswordMatch);

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmation.value;

        if (confirmation.length === 0) {
            passwordMatch.classList.add('hidden');
            return;
        }

        passwordMatch.classList.remove('hidden');

        if (password === confirmation) {
            passwordMatch.textContent = '✓ Passwords match';
            passwordMatch.className = 'text-xs mt-1 text-green-400';
        } else {
            passwordMatch.textContent = '✗ Passwords do not match';
            passwordMatch.className = 'text-xs mt-1 text-red-400';
        }
    }

    document.getElementById('registerForm')?.addEventListener('submit', function(e) {
        const registerBtn = document.getElementById('registerBtn');
        const registerText = document.getElementById('registerText');
        const registerIcon = document.getElementById('registerIcon');
        const registerSpinner = document.getElementById('registerSpinner');

        registerBtn.disabled = true;
        registerText.textContent = 'Creating Account...';
        registerIcon.classList.add('hidden');
        registerSpinner.classList.remove('hidden');
    });

    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');

    usernameInput.addEventListener('blur', async function() {
        const username = this.value.trim();
        if (username.length >= 3) {
            await checkAvailability('username', username);
        }
    });

    emailInput.addEventListener('blur', async function() {
        const email = this.value.trim();
        if (email.includes('@')) {
            await checkAvailability('email', email);
        }
    });

    async function checkAvailability(field, value) {
        try {
            const response = await fetch('{{ route("check.availability") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ field, value })
            });

            const data = await response.json();
            const input = document.getElementById(field);
            const wrapper = input.closest('.input-wrapper');
            let feedback = wrapper.querySelector('.availability-feedback');

            if (!feedback) {
                feedback = document.createElement('p');
                feedback.className = 'availability-feedback text-xs mt-1';
                wrapper.appendChild(feedback);
            }

            if (data.available) {
                feedback.textContent = `✓ ${field.charAt(0).toUpperCase() + field.slice(1)} is available`;
                feedback.className = 'availability-feedback text-xs mt-1 text-green-400';
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            } else {
                feedback.textContent = `✗ ${field.charAt(0).toUpperCase() + field.slice(1)} is already taken`;
                feedback.className = 'availability-feedback text-xs mt-1 text-red-400';
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }
        } catch (error) {
            console.error('Availability check failed:', error);
        }
    }
</script>
@endpush
