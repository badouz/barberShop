<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes réservations - BarberChop</title>
    <style>
        :root { color-scheme: dark; --gold: #d6ad62; --muted: #b6ad9e; }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh; margin: 0; padding: 28px 18px 48px; color: #f8fafc;
            background: radial-gradient(circle at 12% 8%, #302418 0, #110f0b 42%, #080807 100%);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }
        a { color: inherit; }
        .page { width: min(1050px, 100%); margin: 0 auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 42px; }
        .brand { font-size: 15px; font-weight: 900; letter-spacing: 1.5px; }
        .brand span { color: var(--gold); }
        .link { color: #b7c4d7; text-decoration: none; font-size: 13px; }
        .link:hover { color: white; }
        .heading { margin-bottom: 22px; }
        .eyebrow { color: var(--gold); font-size: 11px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
        h1 { margin: 9px 0 7px; font-size: clamp(29px, 5vw, 42px); letter-spacing: -1.5px; }
        .heading p { margin: 0; color: var(--muted); font-size: 14px; line-height: 1.6; }
        .layout { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(280px, .8fr); gap: 20px; align-items: start; }
        .panel { border: 1px solid #403522; border-radius: 18px; background: #17140ff2; box-shadow: 0 20px 55px #0007; }
        .panel-body { padding: clamp(18px, 3vw, 27px); }
        .panel-title { display: flex; align-items: center; gap: 10px; margin: 0 0 18px; font-size: 17px; }
        .step { display: grid; width: 28px; height: 28px; place-items: center; border-radius: 50%; color: #f0d99f; background: #514124; font-size: 12px; }
        .service-list { display: grid; gap: 12px; }
        .service { display: grid; grid-template-columns: 90px minmax(0, 1fr) auto; align-items: center; gap: 14px; padding: 11px; border: 1px solid #403722; border-radius: 13px; background: #100e0b; }
        .service img { display: block; width: 90px; height: 75px; border-radius: 9px; object-fit: cover; background: #282219; }
        .service h3 { margin: 0 0 5px; font-size: 14px; }
        .service p { margin: 0; color: var(--muted); font-size: 11px; }
        .service-price { color: #e4c47f; font-size: 14px; font-weight: 800; white-space: nowrap; }
        .shop-note { margin: 0 0 16px; color: var(--muted); font-size: 13px; }
        .divider { height: 1px; margin: 22px 0; background: #403722; }
        .fields { display: grid; grid-template-columns: 1fr 1fr; gap: 0 13px; }
        .field { min-width: 0; }
        .field.full { grid-column: 1 / -1; }
        label { display: block; margin: 12px 0 7px; color: #e0d7c6; font-size: 12px; font-weight: 700; }
        input, select {
            width: 100%; min-height: 46px; padding: 0 12px; border: 1px solid #51452f; border-radius: 10px;
            outline: none; color: white; background: #201b13; font: inherit; font-size: 14px;
        }
        input:focus, select:focus { border-color: var(--gold); box-shadow: 0 0 0 3px #d6ad6233; }
        select option { color: white; background: #201b13; }
        .notice { margin-bottom: 17px; padding: 13px 15px; border: 1px solid; border-radius: 11px; font-size: 13px; line-height: 1.55; }
        .success { color: #bbf7d0; border-color: #166534; background: #14532d55; }
        .error { color: #fecaca; border-color: #991b1b; background: #7f1d1d55; }
        .error ul { margin: 5px 0 0; padding-left: 18px; }
        .summary { overflow: hidden; }
        .summary-head { padding: 20px 22px; background: linear-gradient(135deg, #765a2c, #302415); }
        .summary-head h2 { margin: 0 0 4px; font-size: 18px; }
        .summary-head p { margin: 0; color: #f0dfbd; font-size: 12px; }
        .summary-body { padding: 20px 22px 22px; }
        .summary-row { display: flex; justify-content: space-between; gap: 12px; padding: 11px 0; border-bottom: 1px solid #403722; color: var(--muted); font-size: 13px; }
        .summary-row strong { color: #f8fafc; text-align: right; }
        .total { display: flex; justify-content: space-between; align-items: baseline; padding-top: 17px; }
        .total span { color: var(--muted); font-size: 13px; }
        .total strong { color: #e4c47f; font-size: 25px; }
        .submit { width: 100%; min-height: 49px; margin-top: 19px; border: 0; border-radius: 11px; color: #171108; background: #d6ad62; font-size: 14px; font-weight: 800; cursor: pointer; }
        .submit:hover { background: #e7c982; }
        .submit:disabled { color: #c4bcae; background: #45413a; cursor: not-allowed; }
        .small-note { margin: 11px 0 0; color: #a59a87; text-align: center; font-size: 11px; line-height: 1.5; }
        .empty { padding: 30px 20px; border: 1px dashed #55472d; border-radius: 15px; color: var(--muted); text-align: center; line-height: 1.7; }
        .empty a { display: inline-block; margin-top: 10px; color: #e4c47f; }
        .confirmation { max-width: 720px; margin: 30px auto; text-align: center; }
        .confirmation h2 { margin: 10px 0; color: #bbf7d0; }
        .confirmation p { color: #cbd5e1; line-height: 1.7; }
        .confirmation .link { display: inline-block; margin: 8px; }
        @media (max-width: 780px) {
            .layout { grid-template-columns: 1fr; }
            .summary { grid-row: 1; }
        }
        @media (max-width: 480px) {
            body { padding: 20px 13px 35px; }
            .topbar { margin-bottom: 32px; }
            .fields { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
            .service { grid-template-columns: 72px minmax(0, 1fr); gap: 11px; }
            .service img { width: 72px; height: 68px; }
            .service-price { grid-column: 2; }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div class="brand">💈 BARBER<span>CHOP</span></div>
            <a class="link" href="{{ route('index') }}">← Accueil</a>
        </header>

        @if(session('success'))
            <section class="panel panel-body confirmation" role="status">
                <div class="eyebrow">BarberChop · Confirmation</div>
                <h2>{{ session('success') }}</h2>
                @if($confirmation = session('confirmed_reservation'))
                    <p>
                        {{ implode(', ', $confirmation['services']) }}<br>
                        {{ $confirmation['date'] }} à {{ $confirmation['time'] }} · {{ $confirmation['price'] }} DH<br>
                        Barbier : {{ $confirmation['barber'] ?: 'à confirmer' }}
                    </p>
                @endif
                <a class="link" href="{{ route('reservation.services') }}">Faire une autre réservation →</a>
            </section>
        @else
            <div class="heading">
                <div class="eyebrow">Étape 2 · Vérifiez avant d’envoyer</div>
                <h1>Mes réservations.</h1>
                <p>Vérifiez les services et le prix, puis choisissez votre date et votre barbier.</p>
            </div>

            @if($errors->any())
                <div class="notice error" role="alert">
                    <strong>Vérifiez les informations de réservation :</strong>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @if($selectedServices->isEmpty() || ! $shop)
                <div class="empty">
                    Vous n’avez pas encore choisi de service.<br>
                    <a href="{{ route('reservation.services') }}">Choisir mes services →</a>
                </div>
            @else
                @php
                    $totalPrice = $selectedServices->sum(fn ($item) => $item['service']->price);
                    $totalDuration = $selectedServices->sum(fn ($item) => $item['service']->duration);
                @endphp
                <div class="layout">
                    <section class="panel">
                        <div class="panel-body">
                            <h2 class="panel-title"><span class="step">1</span> Vos services</h2>
                            <p class="shop-note">Salon : <strong>{{ $shop->name ?: 'Salon' }}{{ $shop->city ? ' · ' . $shop->city : '' }}</strong></p>
                            <div class="service-list">
                                @foreach($selectedServices as $item)
                                    <article class="service">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['service']->name ?: 'Service' }}">
                                        <div>
                                            <h3>{{ $item['service']->name ?: 'Prestation' }}</h3>
                                            <p>{{ $item['service']->duration ? $item['service']->duration . ' min' : 'Durée à confirmer' }}</p>
                                        </div>
                                        <div class="service-price">{{ number_format($item['service']->price, 2) }} DH</div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="divider"></div>
                            <h2 class="panel-title"><span class="step">2</span> Votre rendez-vous</h2>
                            <form method="POST" action="{{ route('reservation.store') }}">
                                @csrf
                                <div class="fields">
                                    <div class="field full">
                                        <label for="barberman_id">Barbier</label>
                                        <select id="barberman_id" name="barberman_id" required>
                                            <option value="">Choisissez un barbier</option>
                                            @foreach($shop->barberMen as $barber)
                                                <option value="{{ $barber->id }}" @selected((string) old('barberman_id') === (string) $barber->id)>
                                                    {{ $barber->name ?: 'Barbier' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($shop->barberMen->isEmpty())
                                            <p class="small-note" style="text-align: left;">Aucun barbier n’est encore enregistré pour ce salon.</p>
                                        @endif
                                    </div>
                                    <div class="field">
                                        <label for="date">Date</label>
                                        <input id="date" type="date" name="date" min="{{ $minimumDate }}" value="{{ old('date') }}" required>
                                    </div>
                                    <div class="field">
                                        <label for="time">Heure</label>
                                        <select id="time" name="time" required>
                                            <option value="">Choisissez une heure</option>
                                            @foreach($appointmentTimes as $time)
                                                <option value="{{ $time }}" @selected(old('time') === $time)>{{ $time }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="name">Nom complet</label>
                                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" maxlength="255" placeholder="Votre nom" required>
                                    </div>
                                    <div class="field">
                                        <label for="phone">Téléphone</label>
                                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" maxlength="20" placeholder="06 00 00 00 00" required>
                                    </div>
                                </div>
                                <button class="submit" type="submit" @disabled($shop->barberMen->isEmpty())>Envoyer ma réservation →</button>
                                <p class="small-note">Le prix est calculé automatiquement depuis les services choisis.</p>
                            </form>
                        </div>
                    </section>

                    <aside class="panel summary">
                        <div class="summary-head">
                            <h2>Récapitulatif</h2>
                            <p>Votre réservation avant envoi.</p>
                        </div>
                        <div class="summary-body">
                            <div class="summary-row"><span>Salon</span><strong>{{ $shop->name ?: 'Salon' }}</strong></div>
                            <div class="summary-row"><span>Services</span><strong>{{ $selectedServices->count() }}</strong></div>
                            <div class="summary-row"><span>Durée totale</span><strong>{{ $totalDuration }} min</strong></div>
                            <div class="total"><span>Total à payer</span><strong>{{ number_format($totalPrice, 2) }} DH</strong></div>
                        </div>
                    </aside>
                </div>
            @endif
        @endif
    </main>
</body>
</html>
