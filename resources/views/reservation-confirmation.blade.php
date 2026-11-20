<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Réservation confirmée — CHAIR</title>
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
        }

        a {
            color: inherit;
            text-decoration: none;
        }



        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px 60px;
        }
        .confirmation-card-wrap {
            width: 100%;
            max-width: 520px;
            text-align: center;
        }

        .check-badge {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: var(--primary-blue-light);
            color: var(--primary-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 24px -4px rgba(24, 119, 242, 0.25);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 6px;
        }
        .page-subtitle {
            color: var(--text-slate);
            font-size: 1rem;
            margin-bottom: 28px;
        }

        .receipt-card {
            background: #ffffff;
            border-radius: var(--radius-card);
            padding: 24px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-card);
            text-align: left;
            margin-bottom: 24px;
        }

        .shop-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 16px;
        }
        .shop-thumb {
            width: 54px;
            height: 54px;
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
        .shop-meta h2 {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 2px;
        }
        .shop-meta p {
            font-size: 0.82rem;
            color: var(--text-slate);
        }
        .badge-status {
            background: #ecfdf5;
            color: #065f46;
            font-weight: 700;
            font-size: 0.78rem;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            margin-left: auto;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            font-size: 0.92rem;
        }
        .detail-label {
            color: var(--text-slate);
        }
        .detail-val {
            font-weight: 700;
            color: var(--text-navy);
            text-align: right;
            max-width: 60%;
        }

        .total-divider {
            height: 1px;
            background: var(--border-light);
            margin: 16px 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label {
            font-size: 1.05rem;
            font-weight: 800;
        }
        .total-val {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--primary-blue);
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px;
            border-radius: var(--radius-pill);
            background: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s;
        }
        .btn-home:hover {
            background: var(--primary-blue-hover);
        }
    </style>
</head>
<body>

    @include('partials.chair-nav')

    <main class="main-content">
        <div class="confirmation-card-wrap">
            <div class="check-badge">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <h1 class="page-title">Votre réservation est confirmée !</h1>
            <p class="page-subtitle">Nous avons bien enregistré votre rendez-vous chez {{ $shop->name ?? 'notre salon' }}.</p>

            <div class="receipt-card">
                <div class="shop-row">
                    <div class="shop-thumb">
                        <img src="{{ $image }}" alt="{{ $shop->name ?? 'Shop' }}">
                    </div>
                    <div class="shop-meta">
                        <h2>{{ $shop->name ?? 'Salon' }}</h2>
                        <p>{{ $shop->address ?? '' }}, {{ $shop->city ?? '' }}</p>
                    </div>
                    <span class="badge-status">Confirmée</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Numéro de réservation</span>
                    <span class="detail-val" style="font-family:monospace; color:var(--primary-blue);">#CH-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Client</span>
                    <span class="detail-val">{{ $reservation->name }} ({{ $reservation->phone }})</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Barbier</span>
                    <span class="detail-val">{{ $reservation->barberMan->name ?? 'Non assigné' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Prestations</span>
                    <span class="detail-val">{{ $reservation->services->pluck('name')->join(', ') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Date & Heure</span>
                    <span class="detail-val">{{ \Carbon\Carbon::parse($reservation->dateReservation)->format('d/m/Y') }} à {{ $reservation->time }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Paiement</span>
                    <span class="detail-val">Sur place au salon</span>
                </div>

                <div class="total-divider"></div>

                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-val">{{ $reservation->price }} DH</span>
                </div>
            </div>

            <a href="{{ route('index') }}" class="btn-home">
                Retour à l'accueil
            </a>
        </div>
    </main>

</body>
</html>
