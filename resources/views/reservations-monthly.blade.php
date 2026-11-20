<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservations du mois - BarberChop</title>
    <style>
        :root { color-scheme: dark; --gold: #d6ad62; --muted: #aaa59b; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; color: #f7f5f0; background: radial-gradient(circle at top left, #302418 0, #110f0b 38%, #080807 100%); font-family: Inter, "Segoe UI", Arial, sans-serif; }
        a { color: inherit; }
        .page { width: min(1180px, calc(100% - 36px)); margin: 0 auto; padding: 28px 0 50px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-bottom: 34px; }
        .brand { font-size: 15px; font-weight: 900; letter-spacing: 1.5px; }
        .brand span { color: var(--gold); }
        .back { color: #c5bdaf; text-decoration: none; font-size: 13px; }
        .back:hover { color: var(--gold); }
        .heading { display: flex; align-items: end; justify-content: space-between; gap: 20px; margin-bottom: 22px; }
        .eyebrow { color: var(--gold); font-size: 11px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
        h1 { margin: 8px 0 0; font-size: clamp(28px, 5vw, 42px); letter-spacing: -1px; }
        .month-picker { display: flex; align-items: center; gap: 8px; }
        .month-button { display: grid; width: 38px; height: 38px; place-items: center; border: 1px solid #51452f; border-radius: 8px; color: #e5d8bc; background: #201b13; text-decoration: none; }
        .month-button:hover { border-color: var(--gold); color: var(--gold); }
        .month-picker input { height: 38px; border: 1px solid #51452f; border-radius: 8px; color: #f7f5f0; background: #201b13; padding: 0 10px; font: inherit; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 16px; }
        .stat { border: 1px solid #403722; border-radius: 13px; background: #17140f; padding: 16px 18px; }
        .stat span { color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: .8px; }
        .stat strong { display: block; margin-top: 7px; color: #edcc83; font-size: 24px; }
        .table-panel { overflow: hidden; border: 1px solid #403722; border-radius: 16px; background: #17140ff2; box-shadow: 0 20px 55px #0007; }
        .table-scroll { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 850px; }
        th { padding: 14px 16px; border-bottom: 1px solid #403722; color: #cdbf9f; background: #211c14; text-align: left; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; }
        td { padding: 15px 16px; border-bottom: 1px solid #30281c; color: #ddd7cb; font-size: 13px; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: 0; }
        tbody tr:hover { background: #211c1455; }
        .date { color: #f1dfb6; font-weight: 800; }
        .time { display: inline-block; min-width: 66px; padding: 7px 9px; border: 1px solid #51452f; border-radius: 20px; color: #e5d8bc; text-align: center; }
        .services { max-width: 260px; }
        .service-name { display: block; line-height: 1.5; }
        .price { color: #edcc83; font-weight: 900; white-space: nowrap; }
        .phone { color: #bcb3a3; white-space: nowrap; }
        .empty { padding: 54px 20px; color: var(--muted); text-align: center; }
        .empty strong { display: block; margin-bottom: 7px; color: #e8dfcf; font-size: 17px; }
        @media (max-width: 700px) {
            .page { width: min(100% - 24px, 1180px); padding-top: 20px; }
            .heading { align-items: stretch; flex-direction: column; }
            .stats { grid-template-columns: 1fr; }
            .topbar { margin-bottom: 26px; }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div class="brand">BARBER<span>CHOP</span></div>
            <a class="back" href="{{ route('index') }}">← Accueil</a>
        </header>

        <section class="heading">
            <div>
                <div class="eyebrow">Gestion des rendez-vous</div>
                <h1>Réservations du mois</h1>
            </div>
            <form class="month-picker" method="GET" action="{{ route('reservation.index') }}">
                <a class="month-button" href="{{ route('reservation.index', ['month' => $previousMonth]) }}" aria-label="Mois précédent">‹</a>
                <input type="month" name="month" value="{{ $monthValue }}" aria-label="Choisir un mois" onchange="this.form.submit()">
                <a class="month-button" href="{{ route('reservation.index', ['month' => $nextMonth]) }}" aria-label="Mois suivant">›</a>
            </form>
        </section>

        <section class="stats" aria-label="Statistiques du mois">
            <article class="stat"><span>Mois affiché</span><strong>{{ $selectedMonth->translatedFormat('F Y') }}</strong></article>
            <article class="stat"><span>Nombre de réservations</span><strong>{{ $reservations->count() }}</strong></article>
            <article class="stat"><span>Revenu estimé</span><strong>{{ number_format($totalRevenue, 2) }} DH</strong></article>
        </section>

        <section class="table-panel">
            @if($reservations->isEmpty())
                <div class="empty"><strong>Aucune réservation</strong>Il n’y a aucun rendez-vous pour {{ $selectedMonth->translatedFormat('F Y') }}.</div>
            @else
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Barbier</th>
                                <th>Services</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td><span class="date">{{ \Carbon\Carbon::parse($reservation->dateReservation)->translatedFormat('d/m/Y') }}</span></td>
                                    <td><span class="time">{{ substr($reservation->time ?? '—', 0, 5) }}</span></td>
                                    <td>{{ $reservation->name ?: '—' }}</td>
                                    <td><span class="phone">{{ $reservation->phone ?: '—' }}</span></td>
                                    <td>{{ $reservation->barberMan?->name ?: '—' }}</td>
                                    <td class="services">
                                        @forelse($reservation->services as $service)
                                            <span class="service-name">{{ $service->name ?: 'Prestation' }}</span>
                                        @empty
                                            —
                                        @endforelse
                                    </td>
                                    <td><span class="price">{{ number_format($reservation->price, 2) }} DH</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </main>
</body>
</html>
