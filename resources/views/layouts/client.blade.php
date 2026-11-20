<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>@yield('title', 'CHAIR — Barber Booking')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #1877f2;
            --primary-blue-hover: #1464cc;
            --primary-blue-light: #eef5ff;
            --primary-blue-border: #bfdbfe;
            --bg-page: #f8f9fd;
            --bg-card: #ffffff;
            --text-navy: #0f172a;
            --text-slate: #64748b;
            --text-muted: #94a3b8;
            --border-subtle: #e2e8f0;
            --border-light: #edf2f7;
            --danger-red: #ef4444;
            --danger-light: #fef2f2;
            --success-green: #10b981;
            --shadow-card: 0 4px 20px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.04);
            --shadow-hover: 0 12px 30px -4px rgba(24, 119, 242, 0.12), 0 4px 10px -2px rgba(15, 23, 42, 0.05);
            --radius-pill: 9999px;
            --radius-card: 22px;
            --radius-sm: 14px;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-navy);
            line-height: 1.5;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        .chair-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ─── Header ─────────────────────────────────────────── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-light);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .brand-group {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-navy);
        }

        .brand-logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: var(--primary-blue);
        }

        .brand-name {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .header-nav {
            display: none;
            align-items: center;
            gap: 8px;
        }

        .header-nav-link {
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text-slate);
            transition: all 0.2s ease;
        }

        .header-nav-link:hover {
            color: var(--primary-blue);
            background-color: var(--primary-blue-light);
        }

        .header-nav-link.active {
            color: var(--primary-blue);
            background-color: var(--primary-blue-light);
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-icon-round {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-navy);
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-icon-round:hover {
            background: var(--primary-blue-light);
            border-color: var(--primary-blue-border);
            color: var(--primary-blue);
        }

        .user-avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        /* ─── Main Content ────────────────────────────────────── */
        main.chair-main {
            flex: 1;
            padding-bottom: 96px; /* space for mobile bottom nav */
        }

        /* ─── Mobile Bottom Nav ───────────────────────────────── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: #ffffff;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-around;
            z-index: 90;
            padding: 0 10px;
            box-shadow: 0 -4px 16px rgba(15, 23, 42, 0.05);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            color: var(--text-slate);
            font-size: 0.75rem;
            font-weight: 600;
            width: 25%;
            height: 100%;
            transition: color 0.15s ease;
        }

        .bottom-nav-item svg {
            width: 22px;
            height: 22px;
            stroke-width: 2;
        }

        .bottom-nav-item.active {
            color: var(--primary-blue);
        }

        .bottom-nav-item:hover {
            color: var(--primary-blue);
        }

        /* ─── Desktop Breakpoint (>= 1024px) ─────────────────── */
        @media (min-width: 1024px) {
            .header-nav {
                display: flex;
            }
            .bottom-nav {
                display: none !important;
            }
            main.chair-main {
                padding-bottom: 48px;
            }
        }

        /* ─── Alerts & Flash Messages ─────────────────────────── */
        .flash-alert {
            margin: 16px auto;
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.92rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .flash-alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .flash-alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Common buttons */
        .chair-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            text-decoration: none;
        }
        .chair-btn-primary:hover {
            background-color: var(--primary-blue-hover);
            transform: translateY(-1px);
        }
        .chair-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            color: var(--text-navy);
            border: 1px solid var(--border-subtle);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .chair-btn-secondary:hover {
            background-color: var(--primary-blue-light);
            border-color: var(--primary-blue-border);
            color: var(--primary-blue);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- ─── Site Header ─────────────────────────────────────────── -->
    <header class="site-header">
        <div class="chair-container header-inner">
            <!-- Brand -->
            <a href="{{ route('client.home') }}" class="brand-group" aria-label="CHAIR Home">
                <span class="brand-logo-icon">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="6" cy="6" r="3"></circle>
                        <circle cx="6" cy="18" r="3"></circle>
                        <line x1="20" y1="4" x2="8.12" y2="15.88"></line>
                        <line x1="14.47" y1="14.48" x2="20" y2="20"></line>
                        <line x1="8.12" y1="8.12" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span class="brand-name">CHAIR</span>
            </a>

            <!-- Desktop Nav -->
            <nav class="header-nav" aria-label="Desktop Navigation">
                <a href="{{ route('client.home') }}" class="header-nav-link {{ request()->routeIs('client.home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('client.home') }}#shops-section" class="header-nav-link {{ request()->routeIs('client.shop') || request()->routeIs('client.reserve') ? 'active' : '' }}">Reserve</a>
                <a href="{{ route('client.bookings') }}" class="header-nav-link {{ request()->routeIs('client.bookings*') || request()->routeIs('client.booking-detail') ? 'active' : '' }}">My bookings</a>
                <a href="{{ route('client.settings') }}" class="header-nav-link {{ request()->routeIs('client.settings*') ? 'active' : '' }}">Settings</a>
            </nav>

            <!-- User Icons -->
            <div class="user-actions">
                <a href="{{ route('client.settings') }}" aria-label="Profile">
                    <img class="user-avatar-img"
                         src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces"
                         alt="{{ Auth::user()->name ?? 'User' }}">
                </a>
                <button type="button" class="btn-icon-round" aria-label="Notifications">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- ─── Flash Messages ──────────────────────────────────────── -->
    @if(session('success'))
        <div class="chair-container">
            <div class="flash-alert flash-alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(isset($errors) && $errors->any())
        <div class="chair-container">
            <div class="flash-alert flash-alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <!-- ─── Main Content ────────────────────────────────────────── -->
    <main class="chair-main">
        @yield('content')
    </main>

    <!-- ─── Mobile Bottom Nav ───────────────────────────────────── -->
    <nav class="bottom-nav" aria-label="Mobile Navigation">
        <a href="{{ route('client.home') }}" class="bottom-nav-item {{ request()->routeIs('client.home') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('client.home') }}#shops-section" class="bottom-nav-item {{ request()->routeIs('client.shop') || request()->routeIs('client.reserve') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Reserve</span>
        </a>
        <a href="{{ route('client.bookings') }}" class="bottom-nav-item {{ request()->routeIs('client.bookings*') || request()->routeIs('client.booking-detail') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <span>My bookings</span>
        </a>
        <a href="{{ route('client.settings') }}" class="bottom-nav-item {{ request()->routeIs('client.settings*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
            <span>Settings</span>
        </a>
    </nav>

    @stack('scripts')
</body>
</html>
