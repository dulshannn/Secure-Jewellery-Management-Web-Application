<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #2c2c2c;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }
        .header {
            background: linear-gradient(135deg, #d4af37 0%, #f9e5b9 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header h1 {
            margin: 0;
            color: #1a1a1a;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .message {
            font-size: 14px;
            line-height: 1.6;
            color: #cccccc;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #1f1f1f;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-label {
            font-size: 12px;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
        }
        .expiry-notice {
            margin-top: 15px;
            font-size: 13px;
            color: #888888;
        }
        .warning-box {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .warning-box p {
            margin: 0;
            font-size: 13px;
            color: #fca5a5;
            line-height: 1.5;
        }
        .footer {
            background-color: #1a1a1a;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #444444;
        }
        .footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #888888;
        }
        .footer a {
            color: #d4af37;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        .brand-icon {
            width: 24px;
            height: 24px;
            color: #d4af37;
        }
        .brand-text {
            font-size: 18px;
            font-weight: bold;
            color: #d4af37;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="header-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                </svg>
            </div>
            <h1>Security Verification</h1>
        </div>

        <div class="content">
            <p class="greeting">Hello {{ $name }},</p>

            <p class="message">
                You are receiving this email because a login attempt was made to your Secure Jewellery Management account.
                To complete the authentication process, please use the One-Time Password (OTP) below:
            </p>

            <div class="otp-container">
                <div class="otp-label">Your Verification Code</div>
                <p class="otp-code">{{ $otp }}</p>
                <div class="expiry-notice">
                    <svg style="display: inline-block; width: 14px; height: 14px; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="#888888" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    This code will expire in 5 minutes
                </div>
            </div>

            <p class="message">
                Enter this code on the login page to access your account. If you didn't request this code,
                please ignore this email or contact our security team immediately.
            </p>

            <div class="warning-box">
                <p><strong>Security Notice:</strong> Never share this code with anyone. Our support team will never ask for your OTP code.</p>
            </div>
        </div>

        <div class="footer">
            <div class="brand">
                <svg class="brand-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                </svg>
                <span class="brand-text">SJM</span>
            </div>
            <p>&copy; {{ date('Y') }} Secure Jewellery Management System</p>
            <p>All rights reserved.</p>
            <p style="margin-top: 15px;">
                <a href="{{ config('app.url') }}">Visit Website</a> |
                <a href="{{ config('app.url') }}/support">Support</a> |
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
        </div>
    </div>
</body>
</html>
