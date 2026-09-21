<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Back To FurShield — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,400;0,500;1,400&family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/frontend-modern.css">
    <style>
        body {
            background-color: var(--color-paper, #fbfbfa);
            color: var(--color-ink, #0d0f11);
            font-family: var(--font-sans, 'Manrope', sans-serif);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .login-page-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 45px -15px rgba(13, 15, 17, 0.08);
            border: 1px solid rgba(13, 15, 17, 0.08);
            max-width: 960px;
            width: 100%;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* Left Side */
        .login-visual-side {
            background: #0d0f11;
            color: #ffffff;
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .login-visual-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 10% 20%, rgba(5, 150, 105, 0.25), transparent 60%);
            pointer-events: none;
        }

        .login-visual-side img {
            border-radius: 16px;
            max-height: 240px;
            width: 100%;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 16px 32px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .visual-caption {
            position: relative;
            z-index: 1;
        }

        .visual-caption .caption-tag {
            font-family: var(--font-mono, 'DM Mono', monospace);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #34d399;
            margin-bottom: 0.75rem;
            display: block;
        }

        .visual-caption h2 {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.03em;
            color: #ffffff;
            margin-bottom: 0.75rem;
        }

        .visual-caption h2 em {
            font-family: var(--font-serif, 'Playfair Display', serif);
            font-style: italic;
            font-weight: 400;
            color: #a7f3d0;
        }

        .visual-caption p {
            color: #9ca3af;
            font-size: 0.92rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Right Form Side */
        .login-form-side {
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .tab-toggle-pill {
            display: inline-flex;
            background: #f4f4f2;
            padding: 4px;
            border-radius: 9999px;
            margin-bottom: 2rem;
            align-self: flex-start;
            border: 1px solid rgba(13, 15, 17, 0.05);
        }

        .tab-btn {
            padding: 0.45rem 1.4rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #6b7280;
            transition: all 0.2s cubic-bezier(0.22, 1, 0.36, 1);
        }

        .tab-btn.active {
            background: #0d0f11;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .form-label-row label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #0d0f11;
            letter-spacing: -0.01em;
        }

        .fe-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #fafaf9;
            color: #0d0f11;
            font-size: 0.92rem;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .fe-input:focus {
            background: #ffffff;
            border-color: #0d0f11;
            box-shadow: 0 0 0 3px rgba(13, 15, 17, 0.06);
        }

        .social-btn {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #374151;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            border-color: #0d0f11;
            background: #f9fafb;
            color: #0d0f11;
        }

        .btn-submit-pill {
            width: 100%;
            padding: 0.85rem;
            font-size: 0.95rem;
            font-weight: 700;
            background: #0d0f11;
            color: #ffffff;
            border: 1px solid #0d0f11;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.2s ease;
            letter-spacing: -0.01em;
            margin-bottom: 1.5rem;
        }

        .btn-submit-pill:hover {
            background: #24272b;
            border-color: #24272b;
        }

        .quick-demo-box {
            background: #fbfbfa;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .quick-demo-box span {
            font-family: var(--font-mono, 'DM Mono', monospace);
            font-size: 0.75rem;
            color: #6b7280;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .quick-btn {
            padding: 0.35rem 0.85rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quick-btn.admin {
            background: #0d0f11;
            color: #ffffff;
        }

        .quick-btn.owner {
            background: #059669;
            color: #ffffff;
        }

        .quick-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .login-card {
                grid-template-columns: 1fr;
            }
            .login-visual-side {
                display: none;
            }
            .login-form-side {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Grain Overlay -->
<div class="grain"></div>

<!-- Top Navigation Bar -->
<header class="fe-navbar">
    <div class="fe-container fe-navbar-inner" style="display: flex; align-items: center; justify-content: space-between; padding: 18px 24px;">
        <a href="{{ route('home') }}" class="fe-brand" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
            <div class="fe-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 28px; height: 28px;">
                    <circle cx="12" cy="12" r="11" fill="#ecfdf5" stroke="#10b981" stroke-width="1.8"/>
                    <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#059669"/>
                    <circle cx="8" cy="10" r="1.6" fill="#059669"/>
                    <circle cx="10.8" cy="8" r="1.6" fill="#059669"/>
                    <circle cx="13.2" cy="8" r="1.6" fill="#059669"/>
                    <circle cx="16" cy="10" r="1.6" fill="#059669"/>
                </svg>
            </div>
            <span class="fe-brand-title" style="font-size: 1.15rem; font-weight: 800; color: #0d0f11; letter-spacing: -0.03em;">FurShield</span>
        </a>

        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('home') }}" style="color: #6b7280; font-family: var(--font-mono, monospace); font-size: 0.82rem; text-decoration: none; font-weight: 500;">
                ← Back to Website
            </a>
        </div>
    </div>
</header>

<div class="login-page-container">
    <div class="login-card">
        <!-- Left Visual Side -->
        <div class="login-visual-side">
            <img src="/images/banner-pets.jpg" alt="FurShield Pets">

            <div class="visual-caption">
                <span class="caption-tag">Unified Platform</span>
                <h2>Welcome Back to <em>FurShield</em></h2>
                <p>Log in to manage your pets, schedule appointments, review health logs, or administer the platform.</p>
            </div>
        </div>

        <!-- Right Form Side -->
        <div class="login-form-side">
            <!-- Toggle Pills: Login | Sign Up -->
            <div class="tab-toggle-pill">
                <button type="button" class="tab-btn active" id="tabLogin" onclick="switchTab('login')">Login</button>
                <button type="button" class="tab-btn" id="tabSignup" onclick="switchTab('signup')">Sign Up</button>
            </div>

            <!-- Validation alerts -->
            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 12px; margin-bottom: 1.25rem; font-size: 0.85rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1.25rem;">
                    <div class="form-label-row">
                        <label for="inputEmail">Email Address</label>
                    </div>
                    <input type="email" name="email" id="inputEmail" required 
                           value="{{ old('email', 'admin@furshield.test') }}" 
                           placeholder="Enter your email" 
                           class="fe-input">
                </div>

                <div style="margin-bottom: 1.15rem;">
                    <div class="form-label-row">
                        <label for="inputPassword">Password</label>
                    </div>
                    <div style="position: relative;">
                        <input type="password" name="password" id="inputPassword" required 
                               value="password" 
                               placeholder="Enter your password" 
                               class="fe-input" style="padding-right: 2.5rem;">
                        <span onclick="togglePassword()" style="position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%); cursor: pointer; color: #9ca3af; font-size: 1rem;">👁️</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.82rem;">
                    <label style="display: flex; align-items: center; gap: 0.4rem; color: #6b7280; cursor: pointer;">
                        <input type="checkbox" name="remember" checked style="accent-color: #059669;">
                        Remember me
                    </label>
                    <a href="#" onclick="alert('Password reset link sent to demo account.'); return false;" style="color: #6b7280; font-weight: 600; text-decoration: none;">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit-pill">
                    Sign In
                </button>

                <!-- Divider -->
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                    <span style="font-family: var(--font-mono, monospace); font-size: 0.72rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em;">or continue with</span>
                    <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                </div>

                <!-- Social Login Buttons -->
                <div style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 1.75rem;">
                    <button type="button" class="social-btn" title="Sign in with Google">G</button>
                    <button type="button" class="social-btn" title="Sign in with Facebook">f</button>
                    <button type="button" class="social-btn" title="Sign in with Apple"></button>
                </div>

                <!-- Bottom link -->
                <p style="text-align: center; font-size: 0.84rem; color: #6b7280; margin-bottom: 1.5rem;">
                    Don't have an account? 
                    <a href="#" onclick="switchTab('signup'); return false;" style="color: #059669; font-weight: 700; text-decoration: none;">Sign Up</a>
                </p>

                <!-- 1-Click Demo Accounts for Quick Evaluation -->
                <div class="quick-demo-box">
                    <span>Quick Demo:</span>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" onclick="fillCredentials('admin@furshield.test', 'password')" class="quick-btn admin">
                            Admin
                        </button>
                        <button type="button" onclick="fillCredentials('sarah@example.com', 'password')" class="quick-btn owner">
                            Pet Owner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    if (tab === 'signup') {
        document.getElementById('tabLogin').classList.remove('active');
        document.getElementById('tabSignup').classList.add('active');
        alert('Sign Up mode active! Fill in your email and password to create an account.');
    } else {
        document.getElementById('tabLogin').classList.add('active');
        document.getElementById('tabSignup').classList.remove('active');
    }
}

function fillCredentials(email, pass) {
    document.getElementById('inputEmail').value = email;
    document.getElementById('inputPassword').value = pass;
}

function togglePassword() {
    const input = document.getElementById('inputPassword');
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>

</body>
</html>
