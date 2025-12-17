<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Secure Jewellery Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gold': '#d4af37',
                        'gold-dark': '#b5952f',
                        'gold-light': '#f9e5b9',
                        'dark-bg': '#1a1a1a',
                        'dark-card': '#2c2c2c',
                        'dark-input': '#1f1f1f',
                        'dark-border': '#444444'
                    },
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'],
                        'sans': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .auth-pattern {
            background-image:
                linear-gradient(to right, rgba(212, 175, 55, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(212, 175, 55, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .input-field {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            transform: translateY(-1px);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .btn-gold {
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
        }

        .btn-gold:active {
            transform: translateY(0);
        }

        .btn-gold:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .gold-glow {
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }

        .spinner {
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-top: 2px solid #d4af37;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-shake {
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .label-float {
            transition: all 0.3s ease;
        }

        .input-wrapper:focus-within .label-float,
        .input-wrapper.has-value .label-float {
            transform: translateY(-1.5rem) scale(0.85);
            color: #d4af37;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-dark-bg text-white min-h-screen flex items-center justify-center auth-pattern">

    <div class="fixed top-0 left-0 right-0 z-50 p-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2 group">
                <svg class="w-8 h-8 text-gold transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.86-.76-7-5.14-7-9V8.3l7-3.11V20z"/>
                </svg>
                <span class="text-xl font-light tracking-wide text-white group-hover:text-gold transition-colors">SJM</span>
            </a>
        </div>
    </div>

    <div class="w-full max-w-md px-6 py-12">
        @yield('content')
    </div>

    <div class="fixed bottom-6 left-0 right-0 text-center">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} Secure Jewellery Management. All rights reserved.
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                const wrapper = input.closest('.input-wrapper');
                if (wrapper && input.value.trim() !== '') {
                    wrapper.classList.add('has-value');
                }

                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        wrapper?.classList.add('has-value');
                    } else {
                        wrapper?.classList.remove('has-value');
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
