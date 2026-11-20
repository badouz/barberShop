<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>CHAIR — Find the best barber near you</title>
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

        button, input {
            font-family: inherit;
        }

        /* Container helper */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }



        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            display: block;
        }

        .notification-btn {
            background: transparent;
            border: none;
            color: var(--text-navy);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: background 0.2s ease;
        }

        .notification-btn:hover {
            background-color: var(--border-light);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 7px;
            height: 7px;
            background-color: var(--primary-blue);
            border-radius: 50%;
            border: 1.5px solid #ffffff;
        }

        /* ==========================================================================
           MAIN CONTENT
           ========================================================================== */
        main.main-content {
            flex: 1;
            padding: 24px 0 110px; /* Ample bottom padding for mobile bottom nav */
        }

        /* Top Hero Area */
        .hero-layout {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .hero-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .location-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: var(--primary-blue);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .location-tag svg {
            transition: transform 0.2s ease;
        }

        .location-tag:hover svg {
            transform: translate(2px, -2px);
        }

        .hero-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--text-navy);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 15px;
            color: var(--text-slate);
            font-weight: 500;
        }

        .hero-controls {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Search Bar */
        .search-form {
            position: relative;
            display: flex;
            align-items: center;
            background-color: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-pill);
            padding: 6px 8px 6px 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-form:focus-within {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(24, 119, 242, 0.15);
        }

        .search-icon {
            color: var(--text-slate);
            display: flex;
            align-items: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .search-input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14.5px;
            font-weight: 500;
            color: var(--text-navy);
        }

        .search-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .filter-btn {
            background: transparent;
            border: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-blue);
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.2s ease;
        }

        .filter-btn:hover {
            background-color: var(--primary-blue-light);
        }

        /* Categories Row */
        .categories-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .categories-list {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scrollbar-width: none;
            padding-bottom: 2px;
        }

        .categories-list::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            flex: 1;
            min-width: 100px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 16px;
            background-color: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            color: var(--text-navy);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .category-pill svg {
            color: var(--text-slate);
            transition: color 0.2s ease;
        }

        .category-pill:hover {
            border-color: #cbd5e1;
            background-color: #ffffff;
            transform: translateY(-1px);
        }

        .category-pill.active {
            background-color: var(--primary-blue-light);
            border-color: var(--primary-blue-border);
            color: var(--primary-blue);
            font-weight: 700;
        }

        .category-pill.active svg {
            color: var(--primary-blue);
        }

        .category-slogan {
            font-size: 13.5px;
            color: var(--primary-blue);
            font-weight: 600;
            padding-left: 2px;
        }

        /* ==========================================================================
           RECOMMENDED SHOPS SECTION
           ========================================================================== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.4px;
            color: var(--text-navy);
        }

        .section-link {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-blue);
            transition: opacity 0.2s ease;
        }

        .section-link:hover {
            text-decoration: underline;
        }

        /* Shops Layout Container */
        .shops-grid-wrapper {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ==========================================================================
           FEATURED SHOP CARD (Large Panoramic)
           ========================================================================== */
        .featured-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-card);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .featured-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
        }

        .featured-image-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
            background-color: #0f172a;
        }

        .featured-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .featured-card:hover .featured-image {
            transform: scale(1.03);
        }

        .featured-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
        }

        .featured-content {
            padding: 18px 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .featured-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 10px;
        }

        .featured-title {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: var(--text-navy);
        }

        .shop-rating {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            font-weight: 800;
            color: var(--text-navy);
            flex-shrink: 0;
        }

        .star-icon {
            color: #0f172a;
            font-size: 15px;
        }

        .featured-location {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            color: var(--text-slate);
            font-weight: 500;
        }

        .icon-inline {
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .featured-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 6px;
        }

        .price-box {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .price-amount {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-navy);
            letter-spacing: -0.3px;
        }

        .price-unit {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-slate);
        }

        .btn-book-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-blue);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            padding: 12px 26px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 14px rgba(24, 119, 242, 0.3);
        }

        .btn-book-primary:hover {
            background-color: var(--primary-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(24, 119, 242, 0.4);
        }

        .btn-book-primary:active {
            transform: translateY(0);
        }

        /* ==========================================================================
           COMPACT SHOP CARDS
           ========================================================================== */
        .compact-shops-stack {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .compact-card {
            background-color: var(--bg-card);
            border-radius: var(--radius-card);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .compact-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .compact-image-wrapper {
            width: 88px;
            height: 88px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            flex-shrink: 0;
            background-color: #0f172a;
        }

        .compact-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .compact-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .compact-top {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
        }

        .compact-title {
            font-size: 15.5px;
            font-weight: 700;
            color: var(--text-navy);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .compact-location {
            font-size: 12.5px;
            color: var(--text-slate);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .compact-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }

        .compact-price {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .compact-price .price-label {
            font-size: 9px;
        }

        .compact-price strong {
            font-size: 14.5px;
            font-weight: 800;
            color: var(--text-navy);
        }

        .btn-book-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-blue-light);
            color: var(--primary-blue);
            font-size: 12.5px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            transition: all 0.2s ease;
        }

        .btn-book-secondary:hover {
            background-color: var(--primary-blue);
            color: #ffffff;
        }

        /* Empty State */
        .empty-shops-state {
            display: none;
            text-align: center;
            padding: 40px 20px;
            background-color: var(--bg-card);
            border-radius: var(--radius-card);
            border: 1px dashed var(--border-subtle);
        }

        .empty-shops-state.visible {
            display: block;
        }

        .empty-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 14px;
            color: var(--text-muted);
        }

        .empty-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-navy);
        }

        .empty-text {
            font-size: 14px;
            color: var(--text-slate);
            margin-bottom: 16px;
        }

        .btn-reset-filter {
            background-color: var(--primary-blue);
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: var(--radius-pill);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-reset-filter:hover {
            background-color: var(--primary-blue-hover);
        }



        /* ==========================================================================
           MEDIA QUERIES (Tablet & Laptop)
           ========================================================================== */
        
        /* Tablet: 768px */
        @media (min-width: 768px) {
            .container {
                padding: 0 32px;
            }

            .hero-title {
                font-size: 34px;
            }

            .featured-image-wrapper {
                height: 280px;
            }

            .featured-title {
                font-size: 21px;
            }

            .compact-image-wrapper {
                width: 96px;
                height: 96px;
            }
        }

        /* Laptop: >= 1024px */
        @media (min-width: 1024px) {
            /* Hide bottom mobile nav */
            .bottom-nav {
                display: none !important;
            }

            /* Adjust content bottom padding */
            main.main-content {
                padding: 40px 0 60px;
            }



            /* Two-column Hero Area */
            .hero-layout {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 48px;
                align-items: center;
                margin-bottom: 40px;
            }

            .hero-title {
                font-size: 40px;
                letter-spacing: -1px;
            }

            .hero-subtitle {
                font-size: 16px;
            }

            /* Two-column Recommended Shops Grid */
            .shops-grid-wrapper {
                display: grid;
                grid-template-columns: 1.4fr 1fr;
                gap: 28px;
                align-items: start;
            }

            .featured-card {
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .featured-image-wrapper {
                height: 290px;
            }

            .featured-content {
                flex: 1;
                justify-content: space-between;
                padding: 24px;
            }

            .compact-shops-stack {
                gap: 16px;
            }

            .compact-card {
                padding: 14px;
            }

            .compact-image-wrapper {
                width: 92px;
                height: 92px;
            }
        }

        /* Large screens: 1440px */
        @media (min-width: 1440px) {
            .container {
                max-width: 1240px;
            }

            .featured-image-wrapper {
                height: 320px;
            }
        }
    </style>
</head>
<body>

    @php
        $shopsList = $shopsList ?? collect();
        $featuredShop = $featuredShop ?? ($shopsList->firstWhere('is_featured', true) ?? $shopsList->first());
        $compactShops = $compactShops ?? ($featuredShop ? $shopsList->reject(fn ($s) => $s['id'] === $featuredShop['id']) : collect());
    @endphp

    <!-- ==========================================================================
         TOP HEADER
         ========================================================================== -->
    @include('partials.chair-nav')

    <!-- ==========================================================================
         MAIN CONTENT AREA
         ========================================================================== -->
    <main class="main-content">
        <div class="container">

            <!-- Hero & Controls Section (Two columns on laptop) -->
            <section class="hero-layout" aria-labelledby="page-title">
                
                <!-- Left Column: Location & Welcome Heading -->
                <div class="hero-info">
                    <a href="#recommended" class="location-tag" aria-label="Current location: SOHO, NEW YORK">
                        <span>SOHO, NEW YORK</span>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                    <h1 id="page-title" class="hero-title">Hello, Welcome Back!</h1>
                    <p class="hero-subtitle">Find the best barber near you.</p>
                </div>

                <!-- Right Column: Search bar & Category filters -->
                <div class="hero-controls">
                    <!-- Search input -->
                    <form class="search-form" id="search-form" role="search" onsubmit="event.preventDefault();">
                        <span class="search-icon" aria-hidden="true">
                            <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                        <input type="search" 
                               id="search-input"
                               class="search-input" 
                               placeholder="Search shops, barbers, services" 
                               aria-label="Search shops, barbers, services" 
                               autocomplete="off" />
                        <button class="filter-btn" type="button" aria-label="Open filter options" id="filter-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="4" y1="17" x2="20" y2="17"></line>
                                <circle cx="8" cy="7" r="2" fill="currentColor"></circle>
                                <circle cx="16" cy="17" r="2" fill="currentColor"></circle>
                            </svg>
                        </button>
                    </form>

                    <!-- Categories Selector -->
                    <div class="categories-wrapper">
                        <div class="categories-list" role="tablist" aria-label="Barbershop service categories">
                            <!-- Haircut (Active by default) -->
                            <button type="button" 
                                    class="category-pill active" 
                                    data-category="haircut" 
                                    data-slogan="Precision cuts, expertly done."
                                    role="tab" 
                                    aria-selected="true">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="6" cy="6" r="3"></circle>
                                    <circle cx="6" cy="18" r="3"></circle>
                                    <line x1="20" y1="4" x2="8.12" y2="15.88"></line>
                                    <line x1="14.47" y1="14.48" x2="20" y2="20"></line>
                                    <line x1="8.12" y1="8.12" x2="12" y2="12"></line>
                                </svg>
                                <span>Haircut</span>
                            </button>

                            <!-- Beard -->
                            <button type="button" 
                                    class="category-pill" 
                                    data-category="beard" 
                                    data-slogan="Beard shaping, trims & hot towel treatments."
                                    role="tab" 
                                    aria-selected="false">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M4 8c1 3 3 7 8 7s7-4 8-7"></path>
                                    <path d="M7 13c1 4 3 7 5 7s4-3 5-7"></path>
                                </svg>
                                <span>Beard</span>
                            </button>

                            <!-- Styling -->
                            <button type="button" 
                                    class="category-pill" 
                                    data-category="styling" 
                                    data-slogan="Modern styling, pomades & texturizing."
                                    role="tab" 
                                    aria-selected="false">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="4" y1="9" x2="20" y2="9"></line>
                                    <line x1="4" y1="15" x2="20" y2="15"></line>
                                    <line x1="10" y1="3" x2="8" y2="21"></line>
                                    <line x1="16" y1="3" x2="14" y2="21"></line>
                                </svg>
                                <span>Styling</span>
                            </button>
                        </div>

                        <!-- Active category tagline -->
                        <p class="category-slogan" id="category-slogan" aria-live="polite">
                            Precision cuts, expertly done.
                        </p>
                    </div>
                </div>

            </section>

            <!-- Recommended Shops Section -->
            <section id="recommended" aria-labelledby="recommended-title">
                <div class="section-header">
                    <h2 id="recommended-title" class="section-title">Recommended shops</h2>
                    <a href="{{ route('reservation.services') }}" class="section-link">See all</a>
                </div>

                <!-- Empty state when no shops match -->
                <div id="empty-state" class="empty-shops-state" role="status">
                    <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <line x1="8" y1="11" x2="14" y2="11"></line>
                    </svg>
                    <h3 class="empty-title">No barbershops found</h3>
                    <p class="empty-text">We couldn't find any salon matching your search criteria. Try a different keyword or category.</p>
                    <button type="button" class="btn-reset-filter" id="btn-reset">Reset filters</button>
                </div>

                <!-- Responsive Grid: 1 col on mobile, 60%/40% on laptop -->
                <div class="shops-grid-wrapper" id="shops-grid">
                    
                    <!-- Featured Salon (approx 60% on laptop) -->
                    @if($featuredShop)
                        @include('partials.shop-card-featured', ['shop' => $featuredShop])
                    @elseif($shopsList->isEmpty())
                        <div style="background:#fff; border-radius:18px; padding:48px 24px; text-align:center; border:1px solid var(--border-light); grid-column: 1 / -1; width:100%;">
                            <h3 style="font-size:1.15rem; font-weight:700; margin-bottom:6px;">Aucun salon disponible</h3>
                            <p style="color:var(--text-slate); font-size:0.92rem;">Aucun salon n'est encore enregistré dans l'administration.</p>
                        </div>
                    @endif

                    <!-- Compact Salons Stack (approx 40% on laptop) -->
                    <div class="compact-shops-stack" id="compact-shops-stack">
                        @foreach($compactShops as $shop)
                            @include('partials.shop-card-compact', ['shop' => $shop])
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </main>

    <!-- ==========================================================================
         FIXED BOTTOM NAVIGATION (Mobile only, hidden on laptop >= 1024px)
         ========================================================================== -->
    @{{-- bottom-nav rendered by chair-nav partial above --}}

    <!-- ==========================================================================
         CLIENT JAVASCRIPT: Search & Category Filter
         ========================================================================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const categoryPills = document.querySelectorAll('.category-pill');
            const categorySlogan = document.getElementById('category-slogan');
            const shopItems = document.querySelectorAll('.shop-item');
            const emptyState = document.getElementById('empty-state');
            const shopsGrid = document.getElementById('shops-grid');
            const btnReset = document.getElementById('btn-reset');

            let currentCategory = 'haircut';
            let searchQuery = '';

            function applyFilters() {
                let visibleCount = 0;
                const query = searchQuery.trim().toLowerCase();

                shopItems.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const location = card.getAttribute('data-location') || '';
                    const categories = (card.getAttribute('data-category') || '').split(' ');

                    const matchesCategory = currentCategory === 'all' || categories.includes(currentCategory);
                    const matchesSearch = query === '' || name.includes(query) || location.includes(query);

                    if (matchesCategory && matchesSearch) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    emptyState.classList.add('visible');
                    shopsGrid.style.display = 'none';
                } else {
                    emptyState.classList.remove('visible');
                    shopsGrid.style.display = '';
                }
            }

            // Category Selection
            categoryPills.forEach(pill => {
                pill.addEventListener('click', function () {
                    const category = this.getAttribute('data-category');
                    const slogan = this.getAttribute('data-slogan');

                    categoryPills.forEach(p => {
                        p.classList.remove('active');
                        p.setAttribute('aria-selected', 'false');
                    });

                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');

                    currentCategory = category;
                    if (slogan && categorySlogan) {
                        categorySlogan.textContent = slogan;
                    }

                    applyFilters();
                });
            });

            // Live Search
            if (searchInput) {
                searchInput.addEventListener('input', function (e) {
                    searchQuery = e.target.value;
                    applyFilters();
                });
            }

            // Reset button
            if (btnReset) {
                btnReset.addEventListener('click', function () {
                    if (searchInput) searchInput.value = '';
                    searchQuery = '';
                    
                    // Reset to Haircut by default
                    categoryPills.forEach(p => {
                        const isHaircut = p.getAttribute('data-category') === 'haircut';
                        p.classList.toggle('active', isHaircut);
                        p.setAttribute('aria-selected', isHaircut ? 'true' : 'false');
                        if (isHaircut && categorySlogan) {
                            categorySlogan.textContent = p.getAttribute('data-slogan');
                        }
                    });
                    currentCategory = 'haircut';

                    applyFilters();
                });
            }
        });
    </script>
</body>
</html>
