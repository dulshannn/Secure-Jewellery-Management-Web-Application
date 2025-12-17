@extends('layouts.auth')

@section('title', 'Verify OTP')

@section('content')
<div class="bg-dark-card rounded-xl shadow-2xl overflow-hidden border-t-4 border-gold fade-in">
    <div class="p-8">
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-br from-gold/20 to-gold/10 border border-gold/30 flex items-center justify-center">
                <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-display font-bold text-gold mb-2">Verify Your Email</h1>
            <p class="text-gray-400 text-sm">We've sent a 6-digit code to</p>
            <p class="text-white font-semibold mt-1">{{ $email ?? session('verification_email') }}</p>
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

        <form id="verifyOtpForm" method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <label class="block text-center text-sm text-gray-400">Enter Verification Code</label>

                <div class="flex justify-center space-x-3" id="otpInputs">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="0" aria-label="Digit 1">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="1" aria-label="Digit 2">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="2" aria-label="Digit 3">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="3" aria-label="Digit 4">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="4" aria-label="Digit 5">
                    <input type="text" maxlength="1" pattern="[0-9]" class="otp-digit w-14 h-14 text-center text-2xl font-bold bg-dark-input border-2 border-dark-border rounded-lg text-white focus:outline-none focus:border-gold transition-all" data-index="5" aria-label="Digit 6">
                </div>

                <input type="hidden" name="otp" id="otpValue">
            </div>

            <div class="bg-dark-input/50 border border-dark-border rounded-lg p-4">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-400">Code expires in</span>
                    </div>
                    <span id="otpTimer" class="font-mono text-gold font-bold">05:00</span>
                </div>

                <div class="mt-3 pt-3 border-t border-dark-border">
                    <button
                        type="button"
                        id="resendBtn"
                        onclick="resendOtp()"
                        disabled
                        class="w-full text-center text-sm text-gold hover:text-gold-light transition-colors disabled:text-gray-600 disabled:cursor-not-allowed"
                    >
                        Didn't receive code? <span id="resendText">Resend in <span id="resendTimer">60</span>s</span>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                id="verifyBtn"
                disabled
                class="btn-gold w-full px-6 py-3 bg-gold text-dark-bg rounded-lg font-bold disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
            >
                <span id="verifyText">Verify & Continue</span>
                <svg id="verifyIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div id="verifySpinner" class="spinner hidden"></div>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-dark-border text-center">
            <p class="text-gray-400 text-sm">
                Wrong email address?
                <a href="{{ route('register') }}" class="text-gold hover:text-gold-light font-semibold transition-colors">
                    Update & Resend
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const otpDigits = document.querySelectorAll('.otp-digit');
    const otpValue = document.getElementById('otpValue');
    const verifyBtn = document.getElementById('verifyBtn');
    let otpExpiryTime = 300;
    let resendCooldown = 60;
    let otpTimer;
    let resendTimer;

    otpDigits.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value.length === 1 && index < otpDigits.length - 1) {
                otpDigits[index + 1].focus();
            }

            updateOtpValue();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                otpDigits[index - 1].focus();
            }

            if (e.key === 'ArrowLeft' && index > 0) {
                otpDigits[index - 1].focus();
            }

            if (e.key === 'ArrowRight' && index < otpDigits.length - 1) {
                otpDigits[index + 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

            if (pastedData.length === 6) {
                otpDigits.forEach((digit, i) => {
                    digit.value = pastedData[i] || '';
                });
                otpDigits[5].focus();
                updateOtpValue();
            }
        });
    });

    function updateOtpValue() {
        const otp = Array.from(otpDigits).map(input => input.value).join('');
        otpValue.value = otp;

        if (otp.length === 6) {
            verifyBtn.disabled = false;
            verifyBtn.classList.add('gold-glow');
            otpDigits.forEach(input => {
                input.classList.remove('border-dark-border');
                input.classList.add('border-gold');
            });
        } else {
            verifyBtn.disabled = true;
            verifyBtn.classList.remove('gold-glow');
            otpDigits.forEach(input => {
                input.classList.remove('border-gold');
                input.classList.add('border-dark-border');
            });
        }
    }

    function startOtpTimer() {
        const timerDisplay = document.getElementById('otpTimer');

        otpTimer = setInterval(() => {
            otpExpiryTime--;
            const minutes = Math.floor(otpExpiryTime / 60);
            const seconds = otpExpiryTime % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (otpExpiryTime <= 0) {
                clearInterval(otpTimer);
                timerDisplay.textContent = 'EXPIRED';
                timerDisplay.classList.add('text-red-400');
                otpDigits.forEach(input => {
                    input.disabled = true;
                    input.classList.add('opacity-50');
                });
                verifyBtn.disabled = true;
                showError('OTP has expired. Please request a new one.');
            } else if (otpExpiryTime <= 60) {
                timerDisplay.classList.add('text-red-400');
            }
        }, 1000);
    }

    function startResendTimer() {
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');
        const resendTimerDisplay = document.getElementById('resendTimer');

        resendBtn.disabled = true;

        resendTimer = setInterval(() => {
            resendCooldown--;
            resendTimerDisplay.textContent = resendCooldown;

            if (resendCooldown <= 0) {
                clearInterval(resendTimer);
                resendBtn.disabled = false;
                resendText.innerHTML = 'Resend Code';
            }
        }, 1000);
    }

    async function resendOtp() {
        const resendBtn = document.getElementById('resendBtn');
        const resendText = document.getElementById('resendText');

        resendBtn.disabled = true;
        resendText.innerHTML = '<div class="spinner inline-block"></div> Sending...';

        try {
            const response = await fetch('{{ route("otp.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                clearInterval(otpTimer);
                clearInterval(resendTimer);

                otpExpiryTime = 300;
                resendCooldown = 60;

                otpDigits.forEach(input => {
                    input.value = '';
                    input.disabled = false;
                    input.classList.remove('opacity-50');
                });
                otpDigits[0].focus();

                document.getElementById('otpTimer').classList.remove('text-red-400');

                startOtpTimer();
                startResendTimer();

                showSuccess('New OTP has been sent to your email');
            } else {
                showError(data.message || 'Failed to resend OTP');
            }
        } catch (error) {
            showError('Network error. Please try again.');
        }
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg fade-in error-shake';
        errorDiv.innerHTML = `<p class="text-red-400 text-sm">${message}</p>`;

        const form = document.getElementById('verifyOtpForm');
        form.insertBefore(errorDiv, form.firstChild);

        setTimeout(() => errorDiv.remove(), 5000);
    }

    function showSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg fade-in';
        successDiv.innerHTML = `<p class="text-green-400 text-sm">${message}</p>`;

        const form = document.getElementById('verifyOtpForm');
        form.insertBefore(successDiv, form.firstChild);

        setTimeout(() => successDiv.remove(), 5000);
    }

    document.getElementById('verifyOtpForm')?.addEventListener('submit', function(e) {
        const verifyBtn = document.getElementById('verifyBtn');
        const verifyText = document.getElementById('verifyText');
        const verifyIcon = document.getElementById('verifyIcon');
        const verifySpinner = document.getElementById('verifySpinner');

        verifyBtn.disabled = true;
        verifyText.textContent = 'Verifying...';
        verifyIcon.classList.add('hidden');
        verifySpinner.classList.remove('hidden');
    });

    startOtpTimer();
    startResendTimer();
    otpDigits[0].focus();
</script>
@endpush
