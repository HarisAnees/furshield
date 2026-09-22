<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FurShield — Authentication & Portal Access</title>

    <!-- Google Fonts: Anton (Display), Manrope (Sans), DM Mono (Monospace) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Favicon Suite -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#091a13">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --obsidian: #091a13;
            --obsidian-deep: #050e0a;
            --forest: #0f382a;
            --emerald: #10b981;
            --emerald-hover: #059669;
            --emerald-soft: #ecfdf5;
            --emerald-border: #a7f3d0;
            --white: #ffffff;
            --gray-100: #f8fafc;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-800: #1e293b;
        }

        body {
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--obsidian-deep) 0%, var(--obsidian) 55%, #0d281e 100%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 24px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient glowing background radials */
        .auth-ambient-mesh {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .auth-radial {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.6;
        }

        .auth-radial-1 {
            width: 500px;
            height: 500px;
            top: -100px;
            left: -100px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, rgba(5, 150, 105, 0.05) 70%, transparent 100%);
        }

        .auth-radial-2 {
            width: 600px;
            height: 600px;
            bottom: -150px;
            right: -150px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, rgba(9, 26, 19, 0.1) 70%, transparent 100%);
        }

        /* Top Brand Navigation Bar */
        .auth-top-bar {
            position: absolute;
            top: 24px;
            left: 28px;
            right: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 20;
        }

        .auth-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #ffffff;
            padding: 8px 18px;
            border-radius: 9999px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .auth-back-link:hover {
            background: var(--emerald);
            border-color: var(--emerald);
            transform: translateX(-3px);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4);
        }

        .auth-top-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            text-decoration: none;
        }

        .auth-top-brand-name {
            font-family: 'Anton', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 0.04em;
        }

        /* Main Sliding Auth Card Container */
        .auth-container {
            position: relative;
            width: 100%;
            max-width: 1000px;
            min-height: 620px;
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(16, 185, 129, 0.25);
            overflow: hidden;
            z-index: 10;
        }

        .forms-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .signin-signup {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            left: 75%;
            width: 50%;
            transition: 1s 0.7s cubic-bezier(0.22, 1, 0.36, 1);
            display: grid;
            grid-template-columns: 1fr;
            z-index: 5;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 2.5rem 3.5rem;
            transition: all 0.25s 0.65s;
            overflow: hidden;
            grid-column: 1 / 2;
            grid-row: 1 / 2;
            width: 100%;
        }

        form.sign-up-form {
            opacity: 0;
            z-index: 1;
            pointer-events: none;
        }

        form.sign-in-form {
            opacity: 1;
            z-index: 2;
            pointer-events: all;
        }

        /* Header within forms */
        .form-header {
            text-align: center;
            margin-bottom: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            background: var(--obsidian);
            border: 2px solid var(--emerald);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .form-title {
            font-family: 'Anton', 'Manrope', sans-serif;
            font-size: 2rem;
            letter-spacing: 0.02em;
            color: var(--obsidian);
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .form-subtitle {
            font-size: 0.82rem;
            color: var(--gray-600);
            max-width: 320px;
            line-height: 1.45;
        }

        /* Input Fields */
        .input-field {
            max-width: 380px;
            width: 100%;
            background-color: var(--gray-100);
            margin: 7px 0;
            height: 50px;
            border-radius: 9999px;
            display: grid;
            grid-template-columns: 14% 74% 12%;
            padding: 0 1rem;
            position: relative;
            border: 1.5px solid var(--gray-200);
            transition: all 0.25s ease;
        }

        .input-field.two-col {
            grid-template-columns: 14% 86%;
        }

        .input-field:focus-within {
            background-color: #ffffff;
            border-color: var(--emerald);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.18);
        }

        .input-field i.field-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--emerald);
            font-size: 1rem;
            transition: 0.3s;
        }

        .input-field input {
            background: none;
            outline: none;
            border: none;
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
            font-size: 0.92rem;
            color: var(--gray-800);
            width: 100%;
        }

        .input-field input::placeholder {
            color: var(--gray-400);
            font-weight: 400;
        }

        .toggle-password {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--gray-400);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: var(--emerald);
        }

        /* Role Selection Pills (Sign Up) */
        .role-selector-wrap {
            max-width: 380px;
            width: 100%;
            margin: 6px 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .role-selector-label {
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gray-600);
        }

        .role-pills {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }

        .role-pill-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px 8px;
            border-radius: 9999px;
            border: 1.5px solid var(--gray-200);
            background: var(--gray-100);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .role-pill-label input[type="radio"] {
            display: none;
        }

        .role-pill-label:has(input:checked) {
            background: var(--obsidian);
            color: #ffffff;
            border-color: var(--emerald);
            box-shadow: 0 3px 10px rgba(16, 185, 129, 0.25);
        }

        /* Actions & Helpers */
        .form-helpers {
            max-width: 380px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6px 0 12px;
            font-size: 0.8rem;
            color: var(--gray-600);
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: var(--emerald);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--emerald);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--emerald-hover);
            text-decoration: underline;
        }

        /* Buttons */
        .btn-submit {
            max-width: 380px;
            width: 100%;
            background-color: var(--emerald);
            border: none;
            outline: none;
            height: 48px;
            border-radius: 9999px;
            color: #ffffff;
            font-family: 'Manrope', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            margin: 10px 0;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
        }

        .btn-submit:hover {
            background-color: var(--emerald-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 22px rgba(16, 185, 129, 0.45);
        }

        .btn-submit i {
            transition: transform 0.2s ease;
        }

        .btn-submit:hover i {
            transform: translateX(4px);
        }

        /* Demo Quick-Fill Bar */
        .demo-bar {
            max-width: 380px;
            width: 100%;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px dashed var(--gray-200);
            display: flex;
            flex-direction: column;
            gap: 6px;
            text-align: center;
        }

        .demo-title {
            font-family: 'DM Mono', monospace;
            font-size: 0.72rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .demo-pills {
            display: flex;
            gap: 6px;
            justify-content: center;
        }

        .demo-pill {
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--gray-800);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .demo-pill:hover {
            background: var(--emerald-soft);
            border-color: var(--emerald);
            color: var(--emerald-hover);
            transform: translateY(-1px);
        }

        /* Flash Error Box */
        .auth-errors {
            max-width: 380px;
            width: 100%;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 12px;
            padding: 8px 14px;
            margin-bottom: 12px;
            font-size: 0.8rem;
            line-height: 1.4;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .auth-success {
            max-width: 380px;
            width: 100%;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 12px;
            padding: 8px 14px;
            margin-bottom: 12px;
            font-size: 0.8rem;
            line-height: 1.4;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Panels Container (Left & Right) */
        .panels-container {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

        .panel {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-around;
            text-align: center;
            z-index: 6;
        }

        .left-panel {
            pointer-events: all;
            padding: 3.5rem 17% 2.5rem 12%;
        }

        .right-panel {
            pointer-events: none;
            padding: 3.5rem 12% 2.5rem 17%;
        }

        .panel .content {
            color: #ffffff;
            transition: transform 0.9s cubic-bezier(0.22, 1, 0.36, 1);
            transition-delay: 0.55s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .panel-brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .panel h3 {
            font-family: 'Anton', sans-serif;
            font-size: 2.1rem;
            letter-spacing: 0.03em;
            line-height: 1.1;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .panel p {
            font-size: 0.92rem;
            padding: 0.6rem 0 1.5rem;
            line-height: 1.55;
            color: #d1fae5;
            max-width: 320px;
        }

        .btn-transparent {
            background: transparent;
            border: 2px solid #ffffff;
            width: 150px;
            height: 46px;
            border-radius: 9999px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #ffffff;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-transparent:hover {
            background: #ffffff;
            color: var(--obsidian);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .right-panel .content {
            transform: translateX(850px);
        }

        /* -------------------------------------------------------------
           The Sliding Curved Mask (White, Black & Emerald Theme)
           ------------------------------------------------------------- */
        .auth-container:before {
            content: "";
            position: absolute;
            height: 2200px;
            width: 2200px;
            top: -10%;
            right: 48%;
            transform: translateY(-50%);
            background: linear-gradient(-45deg, var(--obsidian-deep) 0%, var(--obsidian) 40%, var(--forest) 75%, var(--emerald) 100%);
            transition: 1.6s cubic-bezier(0.22, 1, 0.36, 1);
            border-radius: 50%;
            z-index: 6;
            box-shadow: 0 0 60px rgba(16, 185, 129, 0.3);
        }

        /* Sign-Up Active Mode */
        .auth-container.sign-up-mode:before {
            transform: translate(100%, -50%);
            right: 52%;
        }

        .auth-container.sign-up-mode .left-panel .content {
            transform: translateX(-850px);
        }

        .auth-container.sign-up-mode .signin-signup {
            left: 25%;
        }

        .auth-container.sign-up-mode form.sign-up-form {
            opacity: 1;
            z-index: 2;
            pointer-events: all;
        }

        .auth-container.sign-up-mode form.sign-in-form {
            opacity: 0;
            z-index: 1;
            pointer-events: none;
        }

        .auth-container.sign-up-mode .right-panel .content {
            transform: translateX(0%);
        }

        .auth-container.sign-up-mode .left-panel {
            pointer-events: none;
        }

        .auth-container.sign-up-mode .right-panel {
            pointer-events: all;
        }

        /* Mobile-only components hidden on desktop */
        .mobile-auth-switch {
            display: none;
        }

        .mobile-switch-prompt {
            display: none;
        }

        /* -------------------------------------------------------------
           Mobile & Tablet Responsive Layout (<= 920px)
           ------------------------------------------------------------- */
        @media (max-width: 920px) {
            body {
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                align-items: center !important;
                padding: 16px 14px 40px !important;
                min-height: 100vh !important;
                width: 100% !important;
                overflow-x: hidden !important;
            }

            .auth-top-bar {
                position: static !important;
                width: 100% !important;
                max-width: 480px !important;
                margin: 0 auto 16px auto !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                flex-shrink: 0 !important;
            }

            .auth-back-link {
                padding: 7px 14px !important;
                font-size: 0.8rem !important;
            }

            .auth-top-brand-name {
                font-size: 1.25rem !important;
            }

            .auth-container {
                position: relative !important;
                min-height: auto !important;
                height: auto !important;
                max-width: 480px !important;
                width: 100% !important;
                border-radius: 24px !important;
                padding: 24px 18px 28px !important;
                overflow: visible !important;
                margin: 0 auto !important;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(16, 185, 129, 0.25) !important;
                flex-shrink: 0 !important;
            }

            /* Disable sliding circular overlay completely on mobile/tablet to avoid intercepting touches */
            .auth-container:before,
            .auth-container.sign-up-mode:before {
                display: none !important;
                content: none !important;
            }

            /* Hide sliding desktop panels */
            .panels-container {
                display: none !important;
            }

            /* Segmented switcher visible on mobile */
            .mobile-auth-switch {
                display: flex !important;
                background: var(--gray-100);
                border: 1.5px solid var(--gray-200);
                border-radius: 9999px;
                padding: 4px;
                margin-bottom: 20px;
                gap: 4px;
                width: 100%;
                position: relative;
                z-index: 15;
            }

            .mobile-switch-tab {
                flex: 1;
                border: none;
                background: transparent;
                padding: 9px 12px;
                border-radius: 9999px;
                font-family: 'Manrope', sans-serif;
                font-weight: 700;
                font-size: 0.82rem;
                color: var(--gray-600);
                cursor: pointer;
                transition: all 0.25s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                touch-action: manipulation;
                white-space: nowrap;
            }

            .mobile-switch-tab.active {
                background: var(--obsidian);
                color: #ffffff;
                box-shadow: 0 4px 12px rgba(9, 26, 19, 0.25);
            }

            .mobile-switch-tab.active i {
                color: var(--emerald);
            }

            /* Mobile In-form helper prompt */
            .mobile-switch-prompt {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 6px;
                margin-top: 14px;
                font-size: 0.82rem;
                color: var(--gray-600);
                width: 100%;
                text-align: center;
                flex-wrap: wrap;
            }

            .mobile-switch-link {
                background: none;
                border: none;
                color: var(--emerald);
                font-weight: 700;
                font-size: 0.82rem;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 2px 4px;
                transition: color 0.2s ease;
            }

            .mobile-switch-link:hover {
                color: var(--emerald-hover);
                text-decoration: underline;
            }

            /* Form container and placement */
            .forms-container {
                position: static !important;
                width: 100% !important;
                height: auto !important;
            }

            .signin-signup,
            .auth-container.sign-up-mode .signin-signup {
                position: static !important;
                width: 100% !important;
                transform: none !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                display: block !important;
                z-index: 10 !important;
            }

            form,
            form.sign-in-form,
            form.sign-up-form {
                position: static !important;
                width: 100% !important;
                max-width: 100% !important;
                transform: none !important;
                padding: 0 !important;
                grid-column: auto !important;
                grid-row: auto !important;
                overflow: visible !important;
                transition: opacity 0.25s ease !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
            }

            /* Display correct form based on mode */
            .auth-container:not(.sign-up-mode) form.sign-in-form {
                display: flex !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }

            .auth-container:not(.sign-up-mode) form.sign-up-form {
                display: none !important;
            }

            .auth-container.sign-up-mode form.sign-up-form {
                display: flex !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }

            .auth-container.sign-up-mode form.sign-in-form {
                display: none !important;
            }

            .form-header {
                width: 100% !important;
                margin-bottom: 1rem !important;
                text-align: center !important;
            }

            .input-field {
                max-width: 100% !important;
                width: 100% !important;
                grid-template-columns: 44px 1fr 40px !important;
                margin: 6px 0 !important;
            }

            .input-field.two-col {
                grid-template-columns: 44px 1fr !important;
            }

            .input-field input {
                font-size: 16px !important; /* Prevents auto-zoom in iOS Safari */
                width: 100% !important;
            }

            .btn-submit {
                max-width: 100% !important;
                width: 100% !important;
                height: 48px !important;
                margin: 10px 0 !important;
            }

            .role-selector-wrap {
                max-width: 100% !important;
                width: 100% !important;
                margin: 6px 0 !important;
            }

            .role-pills {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 6px !important;
                width: 100% !important;
            }

            .role-pill-label {
                padding: 8px 4px !important;
                min-height: 44px !important;
                font-size: 0.72rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .form-helpers {
                max-width: 100% !important;
                width: 100% !important;
                margin: 6px 0 10px !important;
            }

            .demo-bar {
                max-width: 100% !important;
                width: 100% !important;
                margin-top: 12px !important;
                padding-top: 10px !important;
            }

            .demo-pills {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 6px !important;
                justify-content: center !important;
            }

            .demo-pill {
                padding: 6px 10px !important;
                font-size: 0.72rem !important;
            }

            .auth-errors,
            .auth-success {
                max-width: 100% !important;
                width: 100% !important;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px 10px 32px !important;
            }

            .auth-top-bar {
                margin-bottom: 12px !important;
            }

            .auth-container {
                padding: 18px 14px 22px !important;
                border-radius: 20px !important;
            }

            .form-title {
                font-size: 1.55rem !important;
            }

            .form-subtitle {
                font-size: 0.78rem !important;
            }

            .mobile-switch-tab {
                font-size: 0.76rem !important;
                padding: 8px 8px !important;
            }

            .role-pills {
                grid-template-columns: 1fr 1fr 1fr !important;
                gap: 4px !important;
            }

            .role-pill-label {
                font-size: 0.66rem !important;
                padding: 6px 2px !important;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Background Mesh -->
    <div class="auth-ambient-mesh" aria-hidden="true">
        <div class="auth-radial auth-radial-1"></div>
        <div class="auth-radial auth-radial-2"></div>
    </div>

    <!-- Top Bar Navigation -->
    <div class="auth-top-bar">
        <a href="{{ route('home') }}" class="auth-back-link">
            <i class="fas fa-arrow-left"></i>
            <span>Back to FurShield</span>
        </a>

        <a href="{{ route('home') }}" class="auth-top-brand">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="11" fill="#047857" stroke="#10b981" stroke-width="1.8"/>
                <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#ffffff"/>
                <circle cx="8" cy="10" r="1.6" fill="#ffffff"/>
                <circle cx="10.8" cy="8" r="1.6" fill="#ffffff"/>
                <circle cx="13.2" cy="8" r="1.6" fill="#ffffff"/>
                <circle cx="16" cy="10" r="1.6" fill="#ffffff"/>
            </svg>
            <span class="auth-top-brand-name">FURSHIELD</span>
        </a>
    </div>

    <!-- Sliding Auth Card Container -->
    @php
        $isSignUpMode = (old('_form') === 'signup' || (isset($mode) && $mode === 'signup') || session('mode') === 'signup');
    @endphp
    <div class="auth-container {{ $isSignUpMode ? 'sign-up-mode' : '' }}" id="authContainer">
        <!-- Mobile Segmented Auth Tab Switcher (Visible on Mobile & Tablet <= 920px) -->
        <div class="mobile-auth-switch" id="mobileAuthSwitch">
            <button type="button" class="mobile-switch-tab {{ !$isSignUpMode ? 'active' : '' }}" id="mobileSignInTab" onclick="switchToSignIn()">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
            <button type="button" class="mobile-switch-tab {{ $isSignUpMode ? 'active' : '' }}" id="mobileSignUpTab" onclick="switchToSignUp()">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </div>

        <div class="forms-container">
            <div class="signin-signup">

                <!-- 1. SIGN IN FORM -->
                <form action="{{ route('login.submit') }}" method="POST" class="sign-in-form" id="signInForm">
                    @csrf
                    <input type="hidden" name="_form" value="signin">

                    <div class="form-header">
                        <div class="brand-badge">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#10b981"/>
                                <circle cx="8" cy="10" r="1.6" fill="#10b981"/>
                                <circle cx="10.8" cy="8" r="1.6" fill="#10b981"/>
                                <circle cx="13.2" cy="8" r="1.6" fill="#10b981"/>
                                <circle cx="16" cy="10" r="1.6" fill="#10b981"/>
                            </svg>
                        </div>
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Access your companion medical history, clinical consultations & appointments.</p>
                    </div>

                    @if(session('status'))
                        <div class="auth-success">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if($errors->any() && old('_form', 'signin') === 'signin')
                        <div class="auth-errors">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Email Field -->
                    <div class="input-field two-col">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" id="loginEmail" value="{{ old('_form') === 'signin' ? old('email') : '' }}" placeholder="Email Address" required autocomplete="email">
                    </div>

                    <!-- Password Field -->
                    <div class="input-field">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="loginPassword" placeholder="Password" required autocomplete="current-password">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('loginPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Helpers: Remember me & Forgot Password -->
                    <div class="form-helpers">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>
                        <a href="mailto:support@furshield.com?subject=FurShield%20Password%20Reset" class="forgot-link">Forgot password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <!-- Quick Fill Demo Accounts -->
                    <div class="demo-bar">
                        <span class="demo-title">Quick Demo Logins</span>
                        <div class="demo-pills">
                            <button type="button" class="demo-pill" onclick="fillDemo('sarah@example.com', 'password')">
                                <i class="fa-solid fa-paw" style="color: #10b981; margin-right: 4px;"></i> Sarah (Owner)
                            </button>
                            <button type="button" class="demo-pill" onclick="fillDemo('emily@vet.com', 'password')">
                                <i class="fa-solid fa-stethoscope" style="color: #10b981; margin-right: 4px;"></i> Dr. Emily (Vet)
                            </button>
                            <button type="button" class="demo-pill" onclick="fillDemo('shelter@furshield.com', 'password')">
                                <i class="fa-solid fa-shield-heart" style="color: #10b981; margin-right: 4px;"></i> Shelter
                            </button>
                            <button type="button" class="demo-pill" onclick="fillDemo('admin@furshield.test', 'password')">
                                <i class="fa-solid fa-shield-halved" style="color: #10b981; margin-right: 4px;"></i> Admin
                            </button>
                        </div>
                    </div>

                    <!-- Mobile In-Form Switch Helper -->
                    <div class="mobile-switch-prompt">
                        <span>Don't have an account yet?</span>
                        <button type="button" class="mobile-switch-link" onclick="switchToSignUp()">
                            <span>Create account here</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- 2. SIGN UP FORM -->
                <form action="{{ route('register.submit') }}" method="POST" class="sign-up-form" id="signUpForm">
                    @csrf
                    <input type="hidden" name="_form" value="signup">

                    <div class="form-header">
                        <div class="brand-badge">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#10b981"/>
                                <circle cx="8" cy="10" r="1.6" fill="#10b981"/>
                                <circle cx="10.8" cy="8" r="1.6" fill="#10b981"/>
                                <circle cx="13.2" cy="8" r="1.6" fill="#10b981"/>
                                <circle cx="16" cy="10" r="1.6" fill="#10b981"/>
                            </svg>
                        </div>
                        <h2 class="form-title">Create Account</h2>
                        <p class="form-subtitle">Register your companion profile and access trusted veterinary network.</p>
                    </div>

                    @if($errors->any() && old('_form') === 'signup')
                        <div class="auth-errors">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Name Field -->
                    <div class="input-field two-col">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" name="name" value="{{ old('_form') === 'signup' ? old('name') : '' }}" placeholder="Full Name" required autocomplete="name">
                    </div>

                    <!-- Email Field -->
                    <div class="input-field two-col">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" name="email" value="{{ old('_form') === 'signup' ? old('email') : '' }}" placeholder="Email Address" required autocomplete="email">
                    </div>

                    <!-- Password Field -->
                    <div class="input-field">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" name="password" id="registerPassword" placeholder="Password (min. 6 chars)" required autocomplete="new-password">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('registerPassword', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="input-field two-col">
                        <i class="fas fa-shield-alt field-icon"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                    </div>

                    <!-- Role Selector -->
                    <div class="role-selector-wrap">
                        <span class="role-selector-label">I am joining as:</span>
                        <div class="role-pills">
                            <label class="role-pill-label">
                                <input type="radio" name="role" value="owner" {{ old('role', 'owner') === 'owner' ? 'checked' : '' }}>
                                <span><i class="fa-solid fa-paw" style="color: #10b981; margin-right: 4px;"></i> Pet Owner</span>
                            </label>
                            <label class="role-pill-label">
                                <input type="radio" name="role" value="vet" {{ old('role') === 'vet' ? 'checked' : '' }}>
                                <span><i class="fa-solid fa-stethoscope" style="color: #10b981; margin-right: 4px;"></i> Clinician</span>
                            </label>
                            <label class="role-pill-label">
                                <input type="radio" name="role" value="shelter" {{ old('role') === 'shelter' ? 'checked' : '' }}>
                                <span><i class="fa-solid fa-shield-heart" style="color: #10b981; margin-right: 4px;"></i> Shelter</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Register Account</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <!-- Mobile In-Form Switch Helper -->
                    <div class="mobile-switch-prompt">
                        <span>Already have an account?</span>
                        <button type="button" class="mobile-switch-link" onclick="switchToSignIn()">
                            <i class="fas fa-arrow-left"></i>
                            <span>Sign in here</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- 3. SLIDING PROMO PANELS -->
        <div class="panels-container">
            <!-- Left Panel (Displayed during Sign In) -->
            <div class="panel left-panel">
                <div class="content">
                    <div class="panel-brand-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="12" cy="15" rx="3.5" ry="2.8" fill="#10b981"/>
                            <circle cx="7.8" cy="9.8" r="1.8" fill="#ffffff"/>
                            <circle cx="10.8" cy="7.2" r="1.8" fill="#ffffff"/>
                            <circle cx="13.2" cy="7.2" r="1.8" fill="#ffffff"/>
                            <circle cx="16.2" cy="9.8" r="1.8" fill="#ffffff"/>
                        </svg>
                    </div>
                    <h3>New to FurShield?</h3>
                    <p>
                        Every paw deserves a shield of love. Create your account in seconds to manage health records, schedule clinic checkups, and adopt rescue pets.
                    </p>
                    <button type="button" class="btn-transparent" id="signUpBtn">
                        <span>Sign Up</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Right Panel (Displayed during Sign Up) -->
            <div class="panel right-panel">
                <div class="content">
                    <div class="panel-brand-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="12" cy="15" rx="3.5" ry="2.8" fill="#10b981"/>
                            <circle cx="7.8" cy="9.8" r="1.8" fill="#ffffff"/>
                            <circle cx="10.8" cy="7.2" r="1.8" fill="#ffffff"/>
                            <circle cx="13.2" cy="7.2" r="1.8" fill="#ffffff"/>
                            <circle cx="16.2" cy="9.8" r="1.8" fill="#ffffff"/>
                        </svg>
                    </div>
                    <h3>Already One of Us?</h3>
                    <p>
                        Welcome back! Sign in to access your companion profiles, review clinical diagnostic notes, and communicate with verified clinicians.
                    </p>
                    <button type="button" class="btn-transparent" id="signInBtn">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Interactive Switcher -->
    <script>
        const authContainer = document.getElementById('authContainer');
        const signUpBtn = document.getElementById('signUpBtn');
        const signInBtn = document.getElementById('signInBtn');
        const mobileSignInTab = document.getElementById('mobileSignInTab');
        const mobileSignUpTab = document.getElementById('mobileSignUpTab');

        function switchToSignUp() {
            if (!authContainer) return;
            authContainer.classList.add('sign-up-mode');
            if (mobileSignInTab) mobileSignInTab.classList.remove('active');
            if (mobileSignUpTab) mobileSignUpTab.classList.add('active');
            if (window.history.pushState) {
                window.history.pushState({ mode: 'signup' }, '', '{{ route('register') }}');
            }
            if (window.innerWidth <= 920) {
                authContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function switchToSignIn() {
            if (!authContainer) return;
            authContainer.classList.remove('sign-up-mode');
            if (mobileSignInTab) mobileSignInTab.classList.add('active');
            if (mobileSignUpTab) mobileSignUpTab.classList.remove('active');
            if (window.history.pushState) {
                window.history.pushState({ mode: 'signin' }, '', '{{ route('login') }}');
            }
            if (window.innerWidth <= 920) {
                authContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Desktop Sliding Panel Buttons
        if (signUpBtn) {
            signUpBtn.addEventListener('click', switchToSignUp);
        }

        if (signInBtn) {
            signInBtn.addEventListener('click', switchToSignIn);
        }

        // Handle Browser Back / Forward
        window.addEventListener('popstate', (e) => {
            if (window.location.pathname.includes('register')) {
                authContainer.classList.add('sign-up-mode');
                if (mobileSignInTab) mobileSignInTab.classList.remove('active');
                if (mobileSignUpTab) mobileSignUpTab.classList.add('active');
            } else {
                authContainer.classList.remove('sign-up-mode');
                if (mobileSignInTab) mobileSignInTab.classList.add('active');
                if (mobileSignUpTab) mobileSignUpTab.classList.remove('active');
            }
        });

        // Toggle Password Visibility
        function togglePasswordVisibility(fieldId, btn) {
            const input = document.getElementById(fieldId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Quick Fill Demo Credentials
        function fillDemo(email, password) {
            const emailInput = document.getElementById('loginEmail');
            const passInput = document.getElementById('loginPassword');
            if (emailInput && passInput) {
                emailInput.value = email;
                passInput.value = password;
                emailInput.focus();
            }
        }
    </script>
</body>
</html>
