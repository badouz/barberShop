<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Finaliser votre réservation — CHAIR</title>
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
            padding-bottom: 110px;
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
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: #ffffff;
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
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .brand-icon {
            color: var(--primary-blue);
            display: flex;
        }
        .header-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-link {
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text-slate);
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary-blue);
            background: var(--primary-blue-light);
        }

        /* Page Layout */
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

        /* Shop Pill Card */
        .shop-pill-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            margin-bottom: 24px;
        }
        .shop-thumb {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            background: #e2e8f0;
        }
        .shop-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .shop-info h2 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 2px;
        }
        .shop-info p {
            font-size: 0.85rem;
            color: var(--text-slate);
        }

        /* 2-Column Grid on Laptop */
        .booking-layout {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        @media (min-width: 1024px) {
            .booking-layout {
                display: grid;
                grid-template-columns: 7fr 5fr;
                gap: 32px;
                align-items: start;
            }
        }

        /* Section Cards */
        .step-card {
            background: #ffffff;
            border-radius: var(--radius-card);
            padding: 22px 24px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            margin-bottom: 20px;
        }
        .step-header {
            display: flex;
            align-items: baseline;
            gap: 8px;
            margin-bottom: 16px;
        }
        .step-num {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--primary-blue);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .step-title {
            font-size: 1.15rem;
            font-weight: 800;
        }

        /* Service Chosen Items */
        .chosen-services-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chosen-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: var(--bg-page);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
        }
        .chosen-name {
            font-size: 0.94rem;
            font-weight: 700;
            color: var(--text-navy);
        }
        .chosen-dur {
            font-size: 0.8rem;
            color: var(--text-slate);
        }
        .chosen-price {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primary-blue);
        }

        /* Barber Pick Grid */
        .barbers-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        @media (min-width: 640px) {
            .barbers-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .barber-pick-btn {
            border: 2px solid var(--border-subtle);
            border-radius: 16px;
            padding: 14px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #ffffff;
        }
        .barber-pick-btn:hover {
            border-color: var(--primary-blue-border);
            background: var(--primary-blue-light);
        }
        .barber-pick-btn.selected {
            border-color: var(--primary-blue);
            background: var(--primary-blue-light);
            box-shadow: 0 0 0 1px var(--primary-blue);
        }
        .barber-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: var(--text-slate);
            overflow: hidden;
        }
        .barber-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .barber-name {
            font-size: 0.92rem;
            font-weight: 700;
        }
        .barber-role {
            font-size: 0.78rem;
            color: var(--text-slate);
        }

        /* Date Input */
        .date-input {
            width: 100%;
            padding: 13px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-subtle);
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-navy);
            outline: none;
            background: #ffffff;
        }
        .date-input:focus {
            border-color: var(--primary-blue);
        }

        /* Time Slots Grid */
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        @media (min-width: 640px) {
            .slots-grid {
                grid-template-columns: repeat(6, 1fr);
            }
        }
        .slot-btn {
            padding: 10px 4px;
            border-radius: 12px;
            border: 1px solid var(--border-subtle);
            background: #ffffff;
            color: var(--text-navy);
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: all 0.15s ease;
        }
        .slot-btn:hover {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }
        .slot-btn.selected {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: #ffffff;
        }

        /* Guest Inputs */
        .form-group {
            margin-bottom: 14px;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-slate);
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-subtle);
            font-size: 0.95rem;
            font-weight: 500;
            outline: none;
            background: #ffffff;
        }
        .form-input:focus {
            border-color: var(--primary-blue);
        }

        /* Summary Card (Right column on laptop) */
        .summary-card {
            background: #ffffff;
            border-radius: var(--radius-card);
            padding: 24px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            position: sticky;
            top: 84px;
        }
        .summary-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-light);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.92rem;
        }
        .summary-label {
            color: var(--text-slate);
        }
        .summary-val {
            font-weight: 700;
            color: var(--text-navy);
            text-align: right;
        }
        .summary-divider {
            height: 1px;
            background: var(--border-light);
            margin: 18px 0;
        }
        .summary-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .total-label {
            font-size: 1.1rem;
            font-weight: 800;
        }
        .total-price {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--primary-blue);
        }
        .btn-confirm {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 14px;
            border-radius: var(--radius-pill);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-confirm:hover {
            background: var(--primary-blue-hover);
            transform: translateY(-1px);
        }

        /* Mobile Bottom Sticky Confirm Bar */
        .mobile-confirm-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-subtle);
            padding: 12px 20px;
            z-index: 80;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        @media (min-width: 1024px) {
            .mobile-confirm-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('index') }}" class="brand-group" aria-label="CHAIR Home">
                <span class="brand-icon">
                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="6" cy="6" r="3"></circle>
                        <circle cx="6" cy="18" r="3"></circle>
                        <line x1="20" y1="4" x2="8.12" y2="15.88"></line>
                        <line x1="14.47" y1="14.48" x2="20" y2="20"></line>
                        <line x1="8.12" y1="8.12" x2="12" y2="12"></line>
                    </svg>
                </span>
                <span>CHAIR</span>
            </a>

            <nav class="header-nav">
                <a href="{{ route('index') }}" class="nav-link">Home</a>
                <a href="{{ route('reservation.services') }}" class="nav-link active">Reserve</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link" style="color:var(--primary-blue);">Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="page-intro">
            <a href="{{ route('reservation.services', ['shop_id' => $shop->id]) }}" class="back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Modifier les prestations</span>
            </a>
            <h1 class="page-title">Finaliser votre rendez-vous</h1>
        </div>

        @if($errors->any())
            <div style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:12px 18px; border-radius:14px; font-size:0.92rem; font-weight:600; margin-bottom:20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Salon Info Pill -->
        <div class="shop-pill-card">
            <div class="shop-thumb">
                <img src="{{ $controller->shopImage($shop) }}" alt="{{ $shop->name }}">
            </div>
            <div class="shop-info">
                <h2>{{ $shop->name }}</h2>
                <p>{{ $shop->address }}, {{ $shop->city }}</p>
            </div>
        </div>

        <!-- Booking Form -->
        <form id="bookingForm" action="{{ route('reservation.store') }}" method="POST">
            @csrf

            <input type="hidden" name="barberman_id" id="input_barberman_id" value="{{ old('barberman_id', $barbers->first()->id ?? '') }}" required>
            <input type="hidden" name="time" id="input_time" value="{{ old('time', '10:00') }}" required>

            <div class="booking-layout">
                <!-- Left Column: Form Steps -->
                <div>
                    <!-- Step 01: Prestations choisies -->
                    <section class="step-card">
                        <div class="step-header">
                            <span class="step-num">01 /</span>
                            <h2 class="step-title">Prestations sélectionnées</h2>
                        </div>
                        <div class="chosen-services-list">
                            @foreach($selectedServices as $svc)
                                <div class="chosen-item">
                                    <div>
                                        <div class="chosen-name">{{ $svc->name }}</div>
                                        <div class="chosen-dur">{{ $svc->duration }} min</div>
                                    </div>
                                    <div class="chosen-price">{{ number_format($svc->price, 2) }} DH</div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Step 02: Choix du barbier -->
                    <section class="step-card">
                        <div class="step-header">
                            <span class="step-num">02 /</span>
                            <h2 class="step-title">Choisissez votre barbier</h2>
                        </div>
                        @if($barbers->isEmpty())
                            <p style="color:var(--text-slate); font-size:0.92rem;">Aucun barbier assigné à ce salon.</p>
                        @else
                            <div class="barbers-grid">
                                @foreach($barbers as $b)
                                    <div class="barber-pick-btn {{ (old('barberman_id', $barbers->first()->id) == $b->id) ? 'selected' : '' }}"
                                         data-id="{{ $b->id }}"
                                         data-name="{{ $b->name }}"
                                         onclick="selectBarber(this)">
                                        <div class="barber-avatar">
                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        </div>
                                        <div class="barber-name">{{ $b->name }}</div>
                                        <div class="barber-role">Barbier</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>

                    <!-- Step 03: Choix de la date -->
                    <section class="step-card">
                        <div class="step-header">
                            <span class="step-num">03 /</span>
                            <h2 class="step-title">Choisissez la date</h2>
                        </div>
                        <input type="date" 
                               name="date" 
                               id="input_date"
                               class="date-input" 
                               value="{{ old('date', now()->toDateString()) }}" 
                               min="{{ $minimumDate }}" 
                               required
                               onchange="updateDateDisplay(this.value)">
                    </section>

                    <!-- Step 04: Choix de l'heure -->
                    <section class="step-card">
                        <div class="step-header">
                            <span class="step-num">04 /</span>
                            <h2 class="step-title">Choisissez le créneau horaire</h2>
                        </div>
                        <div class="slots-grid">
                            @foreach($appointmentTimes as $t)
                                <button type="button" 
                                        class="slot-btn {{ (old('time', '10:00') === $t) ? 'selected' : '' }}" 
                                        data-time="{{ $t }}"
                                        onclick="selectTime(this)">
                                    {{ $t }}
                                </button>
                            @endforeach
                        </div>
                    </section>

                    <!-- Step 05: Coordonnées invité -->
                    <section class="step-card">
                        <div class="step-header">
                            <span class="step-num">05 /</span>
                            <h2 class="step-title">Vos coordonnées (Invité)</h2>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="client_name">Nom et prénom *</label>
                            <input type="text" 
                                   name="name" 
                                   id="client_name" 
                                   class="form-input" 
                                   placeholder="Ex. Mohamed Alami" 
                                   value="{{ old('name', Auth::user()->name ?? '') }}" 
                                   required>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label" for="client_phone">Numéro de téléphone *</label>
                            <input type="tel" 
                                   name="phone" 
                                   id="client_phone" 
                                   class="form-input" 
                                   placeholder="Ex. 0612345678" 
                                   value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                                   required>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Live Summary Card -->
                <div>
                    <div class="summary-card">
                        <h3 class="summary-title">Récapitulatif</h3>

                        <div class="summary-row">
                            <span class="summary-label">Salon</span>
                            <span class="summary-val">{{ $shop->name }}</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Barbier</span>
                            <span class="summary-val" id="disp_barber">{{ $barbers->first()->name ?? '—' }}</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Prestations</span>
                            <span class="summary-val">{{ $selectedServices->count() }} ({{ $totalDuration }} min)</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Date</span>
                            <span class="summary-val" id="disp_date">{{ now()->format('d/m/Y') }}</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label">Heure</span>
                            <span class="summary-val" id="disp_time">10:00</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total-row">
                            <span class="total-label">Total à payer</span>
                            <span class="total-price">{{ number_format($totalPrice, 2) }} DH</span>
                        </div>

                        <button type="submit" class="btn-confirm">
                            Confirmer et Envoyer ma réservation
                        </button>
                        <p style="text-align:center; color:var(--text-muted); font-size:0.78rem; margin-top:10px;">
                            Paiement sur place au salon.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Mobile Sticky Bottom Confirm Bar -->
            <div class="mobile-confirm-bar">
                <div>
                    <div style="font-size:0.75rem; color:var(--text-slate); font-weight:700;">TOTAL ESTIMÉ</div>
                    <div style="font-size:1.35rem; font-weight:800; color:var(--primary-blue);">{{ $totalPrice }} DH</div>
                </div>
                <button type="submit" class="btn-confirm" style="width:auto; padding:12px 24px;">
                    Confirmer
                </button>
            </div>
        </form>
    </main>

    <script>
        function selectBarber(el) {
            document.querySelectorAll('.barber-pick-btn').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');
            const id = el.getAttribute('data-id');
            const name = el.getAttribute('data-name');
            document.getElementById('input_barberman_id').value = id;
            document.getElementById('disp_barber').textContent = name;
        }

        function selectTime(btn) {
            document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            const val = btn.getAttribute('data-time');
            document.getElementById('input_time').value = val;
            document.getElementById('disp_time').textContent = val;
        }

        function updateDateDisplay(val) {
            if (!val) return;
            const parts = val.split('-');
            if (parts.length === 3) {
                document.getElementById('disp_date').textContent = `${parts[2]}/${parts[1]}/${parts[0]}`;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const dateInput = document.getElementById('input_date');
            if (dateInput && dateInput.value) {
                updateDateDisplay(dateInput.value);
            }
        });
    </script>
</body>
</html>
