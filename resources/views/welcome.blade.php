<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A secure, role-based jewellery management platform with OTP authentication and locker verification.">
    <title>Secure Jewellery Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --gold: #d4af37;
            --bg-dark: #1a1a1a;
            --bg-section: #2c2c2c;
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
        }

        .gold-gradient {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
        }

        .hero-pattern {
            background-image:
                linear-gradient(to right, rgba(212, 175, 55, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(212, 175, 55, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .btn-gold {
            background-color: var(--gold);
            color: #1a1a1a;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
        }

        .btn-outline-gold {
            border: 2px solid var(--gold);
            color: var(--gold);
            transition: all 0.3s ease;
        }

        .btn-outline-gold:hover {
            background-color: var(--gold);
            color: #1a1a1a;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: var(--gold);
        }

        .navbar-sticky {
            transition: all 0.3s ease;
        }

        .navbar-sticky.scrolled {
            background-color: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(212, 175, 55, 0.1));
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card-hover:hover .feature-icon {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.3), rgba(212, 175, 55, 0.2));
            border-color: var(--gold);
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        @media (max-width: 768px) {
            .mobile-menu {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .mobile-menu.active {
                max-height: 400px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-sticky fixed top-0 left-0 right-0 z-50 py-4">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 18c-3.86-.76-7-5.14-7-9V8.3l7-3.11V20z"/>
                    </svg>
                    <span class="text-xl font-light tracking-wide">Secure Jewellery Management</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-300 hover:text-yellow-600 transition text-sm font-light tracking-wide">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-yellow-600 transition text-sm font-light tracking-wide">Features</a>
                    <a href="#roles" class="text-gray-300 hover:text-yellow-600 transition text-sm font-light tracking-wide">Roles</a>
                    <a href="#security" class="text-gray-300 hover:text-yellow-600 transition text-sm font-light tracking-wide">Security</a>
                    <a href="#contact" class="text-gray-300 hover:text-yellow-600 transition text-sm font-light tracking-wide">Contact</a>
                    <a href="{{ url('/index.html') }}" class="btn-gold px-6 py-2 rounded font-medium text-sm">Login</a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="mobile-menu md:hidden mt-4">
                <div class="flex flex-col space-y-3">
                    <a href="#home" class="text-gray-300 hover:text-yellow-600 transition py-2">Home</a>
                    <a href="#features" class="text-gray-300 hover:text-yellow-600 transition py-2">Features</a>
                    <a href="#roles" class="text-gray-300 hover:text-yellow-600 transition py-2">Roles</a>
                    <a href="#security" class="text-gray-300 hover:text-yellow-600 transition py-2">Security</a>
                    <a href="#contact" class="text-gray-300 hover:text-yellow-600 transition py-2">Contact</a>
                    <a href="{{ url('/index.html') }}" class="btn-gold px-6 py-2 rounded font-medium text-center mt-2">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center justify-center hero-pattern pt-20">
        <div class="absolute inset-0 gold-gradient"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center fade-in">
                <h1 class="text-5xl md:text-7xl font-light mb-6 leading-tight">
                    Secure Your <span class="text-yellow-600 font-normal">Precious Assets</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-400 mb-4 font-light leading-relaxed">
                    Advanced Jewellery Management with Multi-Factor Authentication
                </p>
                <p class="text-base md:text-lg text-gray-500 mb-10 max-w-2xl mx-auto">
                    Automated locker verification, OTP-based security, and complete audit trails for enterprise-grade jewellery inventory control.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ url('/index.html') }}" class="btn-gold px-8 py-4 rounded-lg font-medium text-lg w-full sm:w-auto">
                        Get Started
                    </a>
                    <a href="#features" class="btn-outline-gold px-8 py-4 rounded-lg font-medium text-lg w-full sm:w-auto">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-gradient-to-b from-[#1a1a1a] to-[#2c2c2c]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-4xl md:text-5xl font-light mb-4">Why Choose Us</h2>
                <p class="text-gray-400 text-lg mt-8">Built for security, designed for efficiency</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700">
                    <div class="feature-icon mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Enterprise Security</h3>
                    <p class="text-gray-400 leading-relaxed">Multi-factor authentication with OTP verification ensures only authorized access to your valuable inventory.</p>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700">
                    <div class="feature-icon mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">100% Accuracy</h3>
                    <p class="text-gray-400 leading-relaxed">Automated locker verification before and after storage eliminates discrepancies and human error.</p>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700">
                    <div class="feature-icon mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Full Automation</h3>
                    <p class="text-gray-400 leading-relaxed">Streamlined workflows from supplier intake to customer orders with real-time inventory updates.</p>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700">
                    <div class="feature-icon mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Complete Audit Trail</h3>
                    <p class="text-gray-400 leading-relaxed">Every transaction logged and tracked with timestamps for compliance and accountability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- System Features -->
    <section id="features" class="py-20 bg-[#2c2c2c]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-4xl md:text-5xl font-light mb-4">System Features</h2>
                <p class="text-gray-400 text-lg mt-8">Comprehensive tools for modern jewellery management</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">Jewellery Management</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Complete inventory tracking with real-time stock levels, material specifications, and pricing management.</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">Locker Verification</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Automated verification before and after storage with image capture and weight validation.</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">OTP Authentication</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Secure login with one-time password verification for enhanced protection against unauthorized access.</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">Reports & Analytics</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Generate comprehensive reports on inventory, deliveries, suppliers, and transaction history.</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">Activity Logs</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Complete audit trail of all system activities with user identification and timestamp tracking.</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-[#1a1a1a] p-8 rounded-xl border border-gray-700">
                    <div class="flex items-start space-x-4">
                        <div class="feature-icon flex-shrink-0">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2 text-yellow-600">Backup & Restore</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Automated data backups with point-in-time recovery options for business continuity.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- User Roles -->
    <section id="roles" class="py-20 bg-gradient-to-b from-[#2c2c2c] to-[#1a1a1a]">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="section-title text-4xl md:text-5xl font-light mb-4">User Roles</h2>
                <p class="text-gray-400 text-lg mt-8">Role-based access control for enhanced security</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-600 to-yellow-700 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Admin</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">Full system access, user management, security settings, and system configuration control.</p>
                    <ul class="text-left text-gray-500 text-xs space-y-1">
                        <li>• Manage all users</li>
                        <li>• System settings</li>
                        <li>• Security configuration</li>
                        <li>• Full audit access</li>
                    </ul>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-600 to-yellow-700 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Manager</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">Inventory management, order processing, reports generation, and supplier coordination.</p>
                    <ul class="text-left text-gray-500 text-xs space-y-1">
                        <li>• Manage inventory</li>
                        <li>• Process orders</li>
                        <li>• Generate reports</li>
                        <li>• Coordinate suppliers</li>
                    </ul>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-600 to-yellow-700 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Supplier</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">Submit delivery requests, upload invoices, track orders, and view delivery history.</p>
                    <ul class="text-left text-gray-500 text-xs space-y-1">
                        <li>• Submit deliveries</li>
                        <li>• Upload invoices</li>
                        <li>• Track orders</li>
                        <li>• View history</li>
                    </ul>
                </div>

                <div class="card-hover bg-[#2c2c2c] p-8 rounded-xl border border-gray-700 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-yellow-600 to-yellow-700 flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium mb-3 text-yellow-600">Customer</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">Request custom jewellery, upload designs, track order status, and view order history.</p>
                    <ul class="text-left text-gray-500 text-xs space-y-1">
                        <li>• Request custom orders</li>
                        <li>• Upload designs</li>
                        <li>• Track order status</li>
                        <li>• View history</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Highlights -->
    <section id="security" class="py-20 bg-[#1a1a1a]">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-16 fade-in">
                    <h2 class="section-title text-4xl md:text-5xl font-light mb-4">Security First</h2>
                    <p class="text-gray-400 text-lg mt-8">Enterprise-grade protection for your valuable assets</p>
                </div>

                <div class="space-y-6">
                    <div class="card-hover bg-[#2c2c2c] p-6 rounded-xl border border-gray-700 flex items-start space-x-4">
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 border border-yellow-600/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-yellow-600 mb-2">Multi-Factor Authentication</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">OTP-based login system with time-sensitive codes sent to verified devices. Every login attempt is logged and monitored.</p>
                        </div>
                    </div>

                    <div class="card-hover bg-[#2c2c2c] p-6 rounded-xl border border-gray-700 flex items-start space-x-4">
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 border border-yellow-600/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-yellow-600 mb-2">Data Encryption</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">All sensitive data encrypted at rest and in transit using industry-standard AES-256 encryption protocols.</p>
                        </div>
                    </div>

                    <div class="card-hover bg-[#2c2c2c] p-6 rounded-xl border border-gray-700 flex items-start space-x-4">
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 border border-yellow-600/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-yellow-600 mb-2">Complete Activity Logs</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Every action tracked with user identification, IP address, and timestamp. Comprehensive audit trail for compliance.</p>
                        </div>
                    </div>

                    <div class="card-hover bg-[#2c2c2c] p-6 rounded-xl border border-gray-700 flex items-start space-x-4">
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 border border-yellow-600/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-yellow-600 mb-2">Role-Based Access Control</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Granular permissions ensure users can only access features and data relevant to their role. No unauthorized access.</p>
                        </div>
                    </div>

                    <div class="card-hover bg-[#2c2c2c] p-6 rounded-xl border border-gray-700 flex items-start space-x-4">
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gradient-to-br from-yellow-600/20 to-yellow-700/20 border border-yellow-600/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-yellow-600 mb-2">Automated Backups</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">Daily automated backups with 30-day retention. Point-in-time recovery available for disaster recovery scenarios.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-br from-yellow-900/20 to-yellow-800/10 border-t border-yellow-600/20">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center fade-in">
                <h2 class="text-4xl md:text-5xl font-light mb-6">Ready to Secure Your Inventory?</h2>
                <p class="text-xl text-gray-400 mb-8 leading-relaxed">
                    Join leading jewellery businesses that trust our platform for secure, automated inventory management.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ url('/index.html') }}" class="btn-gold px-10 py-4 rounded-lg font-medium text-lg w-full sm:w-auto">
                        Secure Login
                    </a>
                    <a href="#contact" class="btn-outline-gold px-10 py-4 rounded-lg font-medium text-lg w-full sm:w-auto">
                        Contact Admin
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-[#2c2c2c]">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl mx-auto text-center fade-in">
                <h2 class="section-title text-4xl md:text-5xl font-light mb-4">Get In Touch</h2>
                <p class="text-gray-400 text-lg mt-8 mb-12">Have questions? Our support team is here to help.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-[#1a1a1a] p-6 rounded-xl border border-gray-700">
                        <svg class="w-8 h-8 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-yellow-600 font-medium mb-2">Email</h3>
                        <p class="text-gray-400 text-sm">support@sjm.com</p>
                    </div>

                    <div class="bg-[#1a1a1a] p-6 rounded-xl border border-gray-700">
                        <svg class="w-8 h-8 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <h3 class="text-yellow-600 font-medium mb-2">Phone</h3>
                        <p class="text-gray-400 text-sm">+94 77 123 4567</p>
                    </div>

                    <div class="bg-[#1a1a1a] p-6 rounded-xl border border-gray-700">
                        <svg class="w-8 h-8 text-yellow-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h3 class="text-yellow-600 font-medium mb-2">Location</h3>
                        <p class="text-gray-400 text-sm">Colombo, Sri Lanka</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1a1a1a] py-8 border-t border-gray-800">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-500 text-sm">&copy; 2025 Secure Jewellery Management System. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#home" class="text-gray-500 hover:text-yellow-600 text-sm transition">Home</a>
                    <a href="#features" class="text-gray-500 hover:text-yellow-600 text-sm transition">Features</a>
                    <a href="#security" class="text-gray-500 hover:text-yellow-600 text-sm transition">Security</a>
                    <a href="#contact" class="text-gray-500 hover:text-yellow-600 text-sm transition">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.querySelector('.navbar-sticky');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    mobileMenu.classList.remove('active');
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
