@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="bg-dark-card rounded-xl shadow-2xl overflow-hidden border-t-4 border-gold fade-in">
    <div class="p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-gold/20 to-gold/10 border border-gold/30 flex items-center justify-center">
                <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-display font-bold text-gold mb-2">Reset Password</h1>
            <p class="text-gray-400 text-sm">Enter your email to receive a password reset link</p>
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

        <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div class="input-wrapper relative">
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
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
            </div>

            <div class="bg-dark-input/50 border border-dark-border rounded-lg p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-gold flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        We'll send you an email with a secure link to reset your password. The link will expire in 60 minutes.
                    </p>
                </div>
            </div>

            <button
                type="submit"
                id="resetBtn"
                class="btn-gold w-full px-6 py-3 bg-gold text-dark-bg rounded-lg font-bold flex items-center justify-center space-x-2"
            >
                <span id="resetText">Send Reset Link</span>
                <svg id="resetIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <div id="resetSpinner" class="spinner hidden"></div>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-dark-border">
            <div class="flex items-center justify-between text-sm">
                <a href="{{ route('login') }}" class="text-gold hover:text-gold-light transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Back to Login</span>
                </a>

                <a href="{{ route('register') }}" class="text-gray-400 hover:text-white transition-colors">
                    Create Account
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('forgotPasswordForm')?.addEventListener('submit', function(e) {
        const resetBtn = document.getElementById('resetBtn');
        const resetText = document.getElementById('resetText');
        const resetIcon = document.getElementById('resetIcon');
        const resetSpinner = document.getElementById('resetSpinner');

        resetBtn.disabled = true;
        resetText.textContent = 'Sending...';
        resetIcon.classList.add('hidden');
        resetSpinner.classList.remove('hidden');
    });
</script>
@endpush
