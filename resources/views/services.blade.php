<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Choisir vos prestations — CHAIR</title>
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

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-navy);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-bottom: 120px;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select {
            font-family: inherit;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }



        /* Page Intro */
        .page-intro {
            padding: 24px 0 16px;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-slate);
            margin-bottom: 12px;
            transition: color 0.15s;
        }
        .back-link:hover {
            color: var(--primary-blue);
        }
        .page-title {
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 6px;
        }
        .page-subtitle {
            color: var(--text-slate);
            font-size: 0.98rem;
        }

        /* Shop Selector Pills */
        .shop-selector-row {
            margin: 18px 0 24px;
        }
        .shop-selector-label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 8px;
        }
        .shop-pills-list {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .shop-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: var(--radius-pill);
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            color: var(--text-navy);
            font-size: 0.92rem;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s;
        }
        .shop-pill:hover {
            border-color: var(--primary-blue-border);
            background: var(--primary-blue-light);
        }
        .shop-pill.active {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: #ffffff;
        }

        /* Active Shop Banner */
        .current-shop-banner {
            background: #ffffff;
            border-radius: var(--radius-card);
            padding: 18px 20px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
        }
        .banner-thumb {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            background: #e2e8f0;
        }
        .banner-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .banner-info h2 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 3px;
        }
        .banner-info p {
            font-size: 0.86rem;
            color: var(--text-slate);
        }

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (min-width: 1024px) {
            .services-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .service-card {
            background: #ffffff;
            border-radius: var(--radius-card);
            border: 2px solid var(--border-subtle);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .service-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary-blue-border);
            box-shadow: var(--shadow-hover);
        }
        .service-card.selected {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 2px var(--primary-blue-border), var(--shadow-hover);
            background: #fcfeff;
        }
        .service-img-wrap {
            height: 160px;
            position: relative;
            background: #e2e8f0;
            overflow: hidden;
        }
        .service-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .service-checkbox {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            background: rgba(15, 23, 42, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            transition: all 0.15s;
        }
        .service-card.selected .service-checkbox {
            background: var(--primary-blue);
            border-color: #ffffff;
        }
        .service-body {
            padding: 16px 18px 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }
        .service-name {
            font-size: 1.05rem;
            font-weight: 800;
            margin-bottom: 4px;
            color: var(--text-navy);
        }
        .service-desc {
            font-size: 0.85rem;
            color: var(--text-slate);
            line-height: 1.45;
            margin-bottom: 14px;
            flex: 1;
        }
        .service-footer {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--border-light);
        }
        .service-price {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-blue);
        }
        .service-dur {
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* Empty state */
        .empty-services-box {
            background: #ffffff;
            border-radius: var(--radius-card);
            padding: 48px 24px;
            text-align: center;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
        }

        /* Sticky Action Bar (Mobile & Desktop) */
        .sticky-action-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-subtle);
            padding: 14px 20px;
            z-index: 80;
            box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.08);
        }
        .bar-inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .bar-summary-text {
            display: flex;
            flex-direction: column;
        }
        .bar-count-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--text-slate);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .bar-total-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary-blue);
        }
        .btn-continue {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 13px 28px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-continue:hover {
            background: var(--primary-blue-hover);
            transform: translateY(-1px);
        }
        .btn-continue:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>
<body>

    <!-- Header -->
    @include('partials.chair-nav')

    <main class="container">
        <div class="page-intro">
            <a href="{{ route('index') }}" class="back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Retour à l'accueil</span>
            </a>
            <h1 class="page-title">Choisissez vos prestations</h1>
            <p class="page-subtitle">Sélectionnez une ou plusieurs prestations dans le salon de votre choix.</p>
        </div>

        @if(session('warning'))
            <div style="background:#fffbeb; color:#92400e; border:1px solid #fde68a; padding:12px 18px; border-radius:14px; font-size:0.92rem; font-weight:600; margin-bottom:20px;">
                {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:12px 18px; border-radius:14px; font-size:0.92rem; font-weight:600; margin-bottom:20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Shop Switcher Pills (If multiple shops available) -->
        @if($allShops->count() > 1)
            <div class="shop-selector-row">
                <div class="shop-selector-label">Changer de salon :</div>
                <div class="shop-pills-list">
                    @foreach($allShops as $s)
                        <a href="{{ route('reservation.services', ['shop_id' => $s->id]) }}" 
                           class="shop-pill {{ ($currentShop && $currentShop->id === $s->id) ? 'active' : '' }}">
                            <span>{{ $s->name }}</span>
                            <span style="opacity:0.75; font-size:0.8rem;">({{ $s->city }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($currentShop)
            <!-- Active Shop Card -->
            <div class="current-shop-banner">
                <div class="banner-thumb">
                    <img src="{{ $controller->shopImage($currentShop) }}" alt="{{ $currentShop->name }}">
                </div>
                <div class="banner-info">
                    <h2>{{ $currentShop->name }}</h2>
                    <p>{{ $currentShop->address }}, {{ $currentShop->city }} · ★ 4.9</p>
                </div>
            </div>

            <!-- Form -->
            <form id="servicesForm" action="{{ route('reservation.selection') }}" method="POST">
                @csrf
                <input type="hidden" name="shop_id" value="{{ $currentShop->id }}">

                @if($currentShop->services->isEmpty())
                    <!-- Empty State for shop without services -->
                    <div class="empty-services-box">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.8" style="margin: 0 auto 12px;"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        <h3 style="font-size:1.15rem; font-weight:800; margin-bottom:6px;">Aucune prestation disponible</h3>
                        <p style="color:var(--text-slate); font-size:0.92rem; margin-bottom:16px;">Ce salon n'a pas encore de services configurés dans l'administration.</p>
                        @if($allShops->count() > 1)
                            <a href="{{ route('reservation.services') }}" class="btn-continue" style="display:inline-flex;">Choisir un autre salon</a>
                        @endif
                    </div>
                @else
                    <div class="services-grid">
                        @foreach($currentShop->services as $service)
                            @php
                                $isChecked = in_array($service->id, $selectedServiceIds);
                                $img = $controller->serviceImage($service);
                            @endphp
                            <div class="service-card {{ $isChecked ? 'selected' : '' }}" 
                                 onclick="toggleCard(this)" 
                                 data-id="{{ $service->id }}" 
                                 data-price="{{ $service->price }}">
                                <div class="service-img-wrap">
                                    <img src="{{ $img }}" alt="{{ $service->name }}">
                                    <div class="service-checkbox">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="service-body">
                                    <div>
                                        <h3 class="service-name">{{ $service->name }}</h3>
                                        <p class="service-desc">{{ $service->description ?: 'Prestation professionnelle réalisée par nos barbiers experts.' }}</p>
                                    </div>
                                    <div class="service-footer">
                                        <div class="service-price">{{ number_format($service->price, 2) }} DH</div>
                                        <div class="service-dur">{{ $service->duration }} min</div>
                                    </div>
                                </div>
                                <input type="checkbox" 
                                       name="service_ids[]" 
                                       value="{{ $service->id }}" 
                                       class="real-checkbox" 
                                       style="display:none;" 
                                       {{ $isChecked ? 'checked' : '' }}>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Sticky Bottom Action Bar -->
                @if($currentShop->services->isNotEmpty())
                    <div class="sticky-action-bar">
                        <div class="bar-inner">
                            <div class="bar-summary-text">
                                <span class="bar-count-label" id="selectedCountText">0 prestation sélectionnée</span>
                                <span class="bar-total-price" id="selectedTotalText">0 DH</span>
                            </div>
                            <button type="submit" class="btn-continue" id="btnSubmit" disabled>
                                <span>Continuer vers la réservation</span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </form>
        @else
            <!-- No shops at all in database -->
            <div class="empty-services-box">
                <h3 style="font-size:1.2rem; font-weight:800; margin-bottom:6px;">Aucun salon enregistré</h3>
                <p style="color:var(--text-slate); font-size:0.95rem;">Veuillez d'abord créer un salon depuis le tableau de bord d'administration Purple.</p>
            </div>
        @endif
    </main>

    <script>
        function toggleCard(card) {
            const cb = card.querySelector('.real-checkbox');
            cb.checked = !cb.checked;
            card.classList.toggle('selected', cb.checked);
            updateBar();
        }

        function updateBar() {
            let count = 0;
            let total = 0;
            document.querySelectorAll('.service-card').forEach(card => {
                const cb = card.querySelector('.real-checkbox');
                if (cb && cb.checked) {
                    count++;
                    total += parseFloat(card.getAttribute('data-price')) || 0;
                }
            });

            const countText = document.getElementById('selectedCountText');
            const totalText = document.getElementById('selectedTotalText');
            const btn = document.getElementById('btnSubmit');

            if (countText) {
                countText.textContent = count + (count > 1 ? ' prestations sélectionnées' : ' prestation sélectionnée');
            }
            if (totalText) {
                totalText.textContent = total + ' DH';
            }
            if (btn) {
                btn.disabled = (count === 0);
            }
        }

        document.addEventListener('DOMContentLoaded', updateBar);
    </script>
</body>
</html>
