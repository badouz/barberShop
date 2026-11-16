<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisissez vos services - BarberChop</title>
    <style>
        :root { color-scheme: dark; --gold: #d6ad62; --muted: #b6ad9e; }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh; margin: 0; padding: 28px 18px 48px; color: #f8fafc;
            background: radial-gradient(circle at 15% 5%, #302418 0, #110f0b 42%, #080807 100%);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }
        .page { width: min(1160px, 100%); margin: 0 auto; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 48px; }
        .brand { font-size: 15px; font-weight: 900; letter-spacing: 1.5px; }
        .brand span { color: var(--gold); }
        a { color: inherit; }
        .nav-link { color: #b7c4d7; text-decoration: none; font-size: 13px; }
        .nav-link:hover { color: white; }
        .heading { max-width: 700px; margin: 0 auto 30px; text-align: center; }
        .eyebrow { color: var(--gold); font-size: 11px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
        h1 { margin: 12px 0 9px; font-size: clamp(30px, 5vw, 46px); letter-spacing: -1.5px; }
        h1 span { color: var(--gold); }
        .heading p { margin: 0; color: var(--muted); font-size: 14px; line-height: 1.7; }
        .notice { margin: 0 auto 18px; padding: 12px 14px; border: 1px solid #991b1b; border-radius: 11px; color: #fecaca; background: #7f1d1d55; font-size: 13px; }
        .notice ul { margin: 4px 0 0; padding-left: 18px; }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .card {
            position: relative; overflow: hidden; min-width: 0; border: 1px solid #403522;
            border-radius: 18px; background: #17140f; transition: .2s ease;
        }
        .card:hover { transform: translateY(-4px); border-color: #b58b45; box-shadow: 0 18px 35px #0007; }
        .card.selected { border-color: var(--gold); box-shadow: 0 0 0 2px #d6ad6277, 0 18px 35px #0007; }
        .image-wrap { position: relative; height: 190px; overflow: hidden; background: #282219; }
        .image-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
        .card:hover .image-wrap img { transform: scale(1.05); }
        .check { position: absolute; top: 13px; right: 13px; display: grid; width: 34px; height: 34px; place-items: center; border: 1px solid #ffffff99; border-radius: 50%; background: #07101dcc; cursor: pointer; }
        .check input { width: 19px; height: 19px; margin: 0; accent-color: #d6ad62; cursor: pointer; }
        .card-body { padding: 17px 18px 18px; }
        .shop { color: #d6ad62; font-size: 10px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
        .card h2 { margin: 8px 0 7px; font-size: 19px; }
        .description { min-height: 40px; margin: 0; color: var(--muted); font-size: 12px; line-height: 1.6; }
        .meta { display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: 15px; padding-top: 13px; border-top: 1px solid #403722; }
        .price { color: #e4c47f; font-size: 21px; font-weight: 900; white-space: nowrap; }
        .duration { color: #d2c8b7; font-size: 12px; white-space: nowrap; }
        .actions { position: sticky; bottom: 12px; z-index: 3; display: flex; justify-content: space-between; align-items: center; gap: 16px; max-width: 700px; margin: 24px auto 0; padding: 13px 15px 13px 20px; border: 1px solid #655333; border-radius: 16px; background: #17140ff2; box-shadow: 0 12px 32px #0009; }
        .selection-info { color: #c4cfdf; font-size: 13px; }
        .selection-info strong { display: block; margin-bottom: 3px; color: white; }
        .continue { min-height: 46px; padding: 0 19px; border: 0; border-radius: 11px; color: #171108; background: #d6ad62; font-size: 13px; font-weight: 800; cursor: pointer; }
        .continue:hover { background: #e7c982; }
        .continue:disabled { color: #c4bcae; background: #45413a; cursor: not-allowed; }
        .empty { grid-column: 1 / -1; padding: 35px; border: 1px dashed #55472d; border-radius: 16px; color: var(--muted); text-align: center; }
        @media (max-width: 850px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 560px) {
            body { padding: 20px 13px 30px; }
            .topbar { margin-bottom: 35px; }
            .grid { grid-template-columns: 1fr; gap: 14px; }
            .image-wrap { height: 210px; }
            .actions { bottom: 8px; padding: 11px; }
            .continue { padding: 0 13px; }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div class="brand">💈 BARBER<span>CHOP</span></div>
            <a class="nav-link" href="{{ route('index') }}">← Accueil</a>
        </header>

        <section class="heading">
            <div class="eyebrow">Ben Guerir · Nos prestations</div>
            <h1>Choisissez vos <span>services.</span></h1>
            <p>Sélectionnez une ou plusieurs prestations du même salon. Votre choix reste enregistré pour l’étape suivante.</p>
        </section>

        @if($errors->any())
            <div class="notice" role="alert">{{ $errors->first() }}</div>
        @endif

        <form id="services-form" method="POST" action="{{ route('reservation.selection') }}">
            @csrf
            <div class="grid">
                @forelse($servicesList as $service)
                    <article class="card" data-shop-id="{{ $service['shop_id'] }}">
                        <div class="image-wrap">
                            <img src="{{ $service['image'] }}" alt="{{ $service['name'] }}" loading="lazy">
                            <label class="check" aria-label="Choisir {{ $service['name'] }}">
                                <input
                                    type="checkbox"
                                    name="service_ids[]"
                                    value="{{ $service['id'] }}"
                                    data-shop-id="{{ $service['shop_id'] }}"
                                    data-price="{{ $service['price'] ?? '' }}"
                                    @disabled($service['price'] === null)
                                    @checked($service['price'] !== null && in_array($service['id'], $selectedServiceIds))
                                >
                            </label>
                        </div>
                        <div class="card-body">
                            <div class="shop">{{ $service['shop_name'] }}</div>
                            <h2>{{ $service['name'] }}</h2>
                            <p class="description">{{ $service['description'] }}</p>
                            <div class="meta">
                                <div class="price">{{ $service['price'] !== null ? number_format($service['price'], 2) . ' DH' : 'Prix à définir' }}</div>
                                <div class="duration">⏱ {{ $service['duration'] ? $service['duration'] . ' min' : 'Durée à confirmer' }}</div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty">Aucun service n’est disponible pour le moment.</div>
                @endforelse
            </div>
            @if($servicesList->isNotEmpty())
                <div class="actions">
                    <div class="selection-info">
                        <strong><span id="selected-count">0</span> service(s) sélectionné(s)</strong>
                        <span id="selection-total">Choisissez vos prestations</span>
                    </div>
                    <button class="continue" id="continue-button" type="submit" disabled>Voir mes réservations →</button>
                </div>
            @endif
        </form>

        <p style="margin: 25px 0 0; text-align: center;"><a class="nav-link" href="{{ route('index') }}">← Retour à l’accueil</a></p>
    </main>
    <script>
        const cards = [...document.querySelectorAll('.card[data-shop-id]')];
        const checkboxes = [...document.querySelectorAll('input[name="service_ids[]"]')];
        const continueButton = document.getElementById('continue-button');
        const selectedCount = document.getElementById('selected-count');
        const selectionTotal = document.getElementById('selection-total');

        function updateSelection() {
            const selected = checkboxes.filter(input => input.checked);
            const shopId = selected[0]?.dataset.shopId;
            const total = selected.reduce((amount, input) => amount + Number(input.dataset.price), 0);

            checkboxes.forEach(input => {
                input.disabled = Boolean(shopId && input.dataset.shopId !== shopId && !input.checked);
            });
            cards.forEach(card => {
                const checkbox = card.querySelector('input');
                card.classList.toggle('selected', checkbox.checked);
            });

            selectedCount.textContent = selected.length;
            selectionTotal.textContent = selected.length
                ? `Total : ${total.toFixed(2)} DH · votre choix sera gardé`
                : 'Choisissez vos prestations';
            continueButton.disabled = selected.length === 0;
        }

        checkboxes.forEach(input => input.addEventListener('change', updateSelection));
        cards.forEach(card => card.addEventListener('click', event => {
            if (event.target.closest('input')) return;
            const checkbox = card.querySelector('input');
            if (!checkbox.disabled) {
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change', { bubbles: true }));
            }
        }));
        if (continueButton) updateSelection();
    </script>
</body>
</html>
