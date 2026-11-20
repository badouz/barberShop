@php
    $isHome = request()->routeIs('index');
    $isReserve = request()->routeIs('reservation.*') || request()->is('reservation*') || request()->is('mes-reservations*');
@endphp

<style>
    /* ─── CHAIR Navigation Shared Styles ─────────────────────────── */
    .site-header {
        position: sticky;
        top: 0;
        z-index: 50;
        background-color: #ffffff;
        border-bottom: 1px solid var(--border-light, #edf2f7);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        width: 100%;
    }

    .site-header .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
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
        color: var(--text-navy, #0f172a);
        transition: opacity 0.2s ease;
        flex-shrink: 0;
        min-width: 120px;
    }

    .brand-group:hover {
        opacity: 0.9;
    }

    .brand-icon {
        color: var(--primary-blue, #1877f2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .brand-name {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--text-navy, #0f172a);
    }

    /* Desktop Nav in Header (centered on laptop >= 1024px) */
    .desktop-nav {
        display: none;
    }

    .desktop-nav-link {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-slate, #64748b);
        padding: 8px 18px;
        border-radius: 9999px;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .desktop-nav-link:hover {
        color: var(--primary-blue, #1877f2);
        background-color: var(--primary-blue-light, #eef5ff);
    }

    .desktop-nav-link.active {
        color: var(--primary-blue, #1877f2);
        background-color: var(--primary-blue-light, #eef5ff);
        font-weight: 700;
    }

    /* Invisible spacer balancing the logo on laptop to keep nav centered */
    .header-balance {
        display: none;
        min-width: 120px;
    }

    @media (min-width: 1024px) {
        .header-inner {
            height: 76px;
        }

        .desktop-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .header-balance {
            display: block;
        }
    }

    /* ─── Mobile Fixed Bottom Navigation (< 1024px) ─────────────── */
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 60;
        height: 68px;
        background-color: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 4px 10px calc(env(safe-area-inset-bottom, 0px) + 4px);
        box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.03);
    }

    .nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        flex: 1;
        padding: 6px 0;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        transition: color 0.15s ease;
        text-decoration: none;
    }

    .nav-item svg {
        stroke: currentColor;
        transition: stroke 0.15s ease;
    }

    .nav-item.active {
        color: var(--primary-blue, #1877f2);
    }

    @media (min-width: 1024px) {
        .bottom-nav {
            display: none !important;
        }
    }
</style>

<!-- ==========================================================================
     TOP HEADER (Identical across Home and all Reservation pages)
     ========================================================================== -->
<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <!-- Brand logo with blue scissors -->
            <a href="{{ route('index') }}" class="brand-group" aria-label="CHAIR Home">
                <span class="brand-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="6" cy="6" r="3"></circle>
                        <circle cx="6" cy="18" r="3"></circle>
                        <line x1="20" y1="4" x2="8.12" y2="15.88"></line>
                        <line x1="14.47" y1="14.48" x2="20" y2="20"></line>
                        <line x1="8.12" y1="8.12" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span class="brand-name">CHAIR</span>
            </a>

            <!-- Centered Desktop Navigation (laptop only >= 1024px) -->
            <nav class="desktop-nav" aria-label="Main navigation">
                <a href="{{ route('index') }}" class="desktop-nav-link {{ $isHome ? 'active' : '' }}">Home</a>
                <a href="{{ route('reservation.services') }}" class="desktop-nav-link {{ $isReserve ? 'active' : '' }}">Reserve</a>
            </nav>

            <!-- Spacer balancing the logo so navigation remains centered -->
            <div class="header-balance" aria-hidden="true"></div>
        </div>
    </div>
</header>

<!-- ==========================================================================
     FIXED BOTTOM NAVIGATION (Mobile only, hidden on laptop >= 1024px)
     ========================================================================== -->
<nav class="bottom-nav" aria-label="Bottom Navigation">
    <!-- Home -->
    <a href="{{ route('index') }}" class="nav-item {{ $isHome ? 'active' : '' }}" {!! $isHome ? 'aria-current="page"' : '' !!}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        <span>Home</span>
    </a>

    <!-- Reserve -->
    <a href="{{ route('reservation.services') }}" class="nav-item {{ $isReserve ? 'active' : '' }}" {!! $isReserve ? 'aria-current="page"' : '' !!}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span>Reserve</span>
    </a>
</nav>
