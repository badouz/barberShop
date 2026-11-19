<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#090909">
    <title>BarberChop — More than a cut. It's a lifestyle.</title>
    <style>
        :root { color-scheme: dark; --gold: #d6ad62; --gold-light: #edcc83; --ink: #090909; --muted: #aaa59b; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; color: #f7f5f0; background: var(--ink); font-family: Inter, "Segoe UI", Arial, sans-serif; }
        a { color: inherit; }
        .site-header { position: sticky; top: 0; z-index: 20; border-bottom: 1px solid #ffffff12; background: #090909f2; backdrop-filter: blur(14px); }
        .nav { width: min(1320px, calc(100% - 56px)); height: 82px; margin: auto; display: flex; align-items: center; justify-content: space-between; gap: 30px; }
        .brand { display: inline-flex; align-items: center; gap: 12px; min-width: max-content; text-decoration: none; }
        .brand-mark { display: grid; width: 43px; height: 48px; place-items: center; border: 1px solid #98743c; color: var(--gold); clip-path: polygon(50% 0, 94% 18%, 88% 76%, 50% 100%, 12% 76%, 6% 18%); font-size: 23px; }
        .brand-copy { display: grid; gap: 2px; }
        .brand-copy strong { font-family: Georgia, "Times New Roman", serif; font-size: 21px; letter-spacing: 2px; }
        .brand-copy small { color: #c9c4ba; font-size: 9px; font-weight: 800; letter-spacing: 2.5px; }
        .nav-links { display: flex; align-items: center; gap: clamp(14px, 2.25vw, 34px); }
        .nav-links a { position: relative; color: #e6e2da; text-decoration: none; font-size: 11px; font-weight: 800; letter-spacing: .5px; text-transform: uppercase; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--gold); }
        .nav-links a.active::after { position: absolute; right: 0; bottom: -11px; left: 0; height: 2px; background: var(--gold); content: ""; }
        .button { display: inline-flex; align-items: center; justify-content: center; gap: 9px; min-height: 48px; padding: 0 23px; border: 1px solid var(--gold); border-radius: 3px; color: #17120a; background: var(--gold); text-decoration: none; font-size: 11px; font-weight: 900; letter-spacing: .7px; text-transform: uppercase; transition: .2s; }
        .button:hover { border-color: var(--gold-light); background: var(--gold-light); transform: translateY(-1px); }
        .button-outline { color: #f2eee7; border-color: #77736b; background: #09090970; }
        .button-outline:hover { color: var(--gold-light); border-color: var(--gold); background: #090909; }
        .menu-toggle { display: none; width: 43px; height: 43px; border: 1px solid #5b4b30; border-radius: 4px; color: var(--gold); background: transparent; font-size: 22px; cursor: pointer; }
        .hero { position: relative; isolation: isolate; min-height: min(640px, calc(100vh - 82px)); display: flex; align-items: center; overflow: hidden; background: #0c0b09; }
        .hero::before { position: absolute; z-index: -2; inset: 0; background-image: url("https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=2000&q=90"); background-position: center 38%; background-size: cover; content: ""; }
        .hero::after { position: absolute; z-index: -1; inset: 0; background: linear-gradient(90deg, #090909 0%, #090909f2 31%, #090909a6 52%, #09090930 78%, #09090935 100%), linear-gradient(0deg, #09090980, transparent 26%); content: ""; }
        .hero-content { width: min(1320px, calc(100% - 56px)); margin: auto; padding: 72px 0 82px; }
        .kicker { display: flex; align-items: center; gap: 10px; color: var(--gold); font-size: 11px; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; }
        .kicker::before { width: 27px; height: 1px; background: var(--gold); content: ""; }
        h1 { max-width: 700px; margin: 20px 0 18px; font-family: Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif; font-size: clamp(50px, 7.3vw, 96px); font-weight: 900; line-height: .96; letter-spacing: 1px; text-transform: uppercase; }
        h1 span { color: var(--gold); }
        .hero-copy { max-width: 455px; color: #ccc7bd; font-size: 15px; line-height: 1.8; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 13px; margin-top: 28px; }
        .social-proof { display: flex; align-items: center; gap: 14px; margin-top: 29px; }
        .avatars { display: flex; padding-left: 4px; }
        .avatars img { width: 36px; height: 36px; margin-left: -5px; border: 2px solid #17140f; border-radius: 50%; object-fit: cover; }
        .rating { display: grid; gap: 3px; font-size: 12px; }
        .stars { color: var(--gold); letter-spacing: 2px; font-size: 17px; }
        .rating small { color: #c7c1b6; }
        .features { border-top: 1px solid #24211b; border-bottom: 1px solid #24211b; background: #10100e; }
        .feature-grid { width: min(1320px, calc(100% - 56px)); min-height: 118px; margin: auto; display: grid; grid-template-columns: repeat(4, 1fr); align-items: center; }
        .feature { display: flex; align-items: center; gap: 15px; min-height: 62px; padding: 8px 24px; border-right: 1px solid #373128; }
        .feature:first-child { padding-left: 0; }
        .feature:last-child { padding-right: 0; border-right: 0; }
        .feature-icon { color: var(--gold); font-family: Georgia, serif; font-size: 31px; }
        .feature strong { display: block; margin-bottom: 5px; color: var(--gold-light); font-size: 11px; letter-spacing: .5px; text-transform: uppercase; }
        .feature span { color: #aaa59b; font-size: 11px; line-height: 1.55; }
        .intro { width: min(960px, calc(100% - 40px)); margin: auto; padding: 82px 0 85px; text-align: center; }
        .intro h2 { margin: 13px 0; font-family: Georgia, "Times New Roman", serif; font-size: clamp(30px, 4vw, 46px); font-weight: 500; }
        .intro p { max-width: 650px; margin: 0 auto; color: var(--muted); font-size: 14px; line-height: 1.8; }
        .intro .button { margin-top: 25px; }
        footer { display: flex; justify-content: space-between; gap: 20px; padding: 22px max(28px, calc((100% - 1320px) / 2)); border-top: 1px solid #29251e; color: #938c80; font-size: 11px; }
        footer a { color: var(--gold); text-decoration: none; }
        @media (max-width: 980px) {
            .nav { width: min(100% - 36px, 1320px); gap: 16px; }
            .nav-links { gap: 15px; }
            .nav-links a { font-size: 10px; }
            .header-book { padding: 0 14px; font-size: 10px; }
            .feature { padding: 8px 13px; }
        }
        @media (max-width: 760px) {
            .nav { height: 72px; }
            .brand-mark { width: 37px; height: 41px; font-size: 20px; }
            .brand-copy strong { font-size: 18px; }
            .menu-toggle { display: block; margin-left: auto; }
            .header-book { display: none; }
            .nav-links { position: absolute; top: 71px; right: 0; left: 0; display: none; align-items: stretch; gap: 0; padding: 8px 20px 17px; border-bottom: 1px solid #4f4027; background: #0d0c0a; }
            .nav-links.open { display: flex; flex-direction: column; }
            .nav-links a { padding: 13px 6px; border-bottom: 1px solid #ffffff12; font-size: 11px; }
            .nav-links a.active::after { display: none; }
            .hero { min-height: 590px; }
            .hero::before { background-position: 61% center; }
            .hero::after { background: linear-gradient(90deg, #090909f2, #090909cf 58%, #0909096b), linear-gradient(0deg, #090909a0, transparent 45%); }
            .hero-content { width: calc(100% - 40px); padding: 66px 0; }
            .feature-grid { width: calc(100% - 36px); grid-template-columns: 1fr 1fr; padding: 10px 0; }
            .feature { min-height: 82px; border-right: 0; }
            .feature:nth-child(odd) { padding-left: 0; }
            .feature:nth-child(even) { border-left: 1px solid #373128; }
            .feature:nth-child(n+3) { border-top: 1px solid #373128; }
            footer { padding-right: 20px; padding-left: 20px; }
        }
        @media (max-width: 480px) {
            .hero { min-height: 570px; }
            .hero-content { width: calc(100% - 34px); }
            h1 { font-size: clamp(48px, 13vw, 66px); }
            .hero-copy { max-width: 340px; font-size: 13px; }
            .button { min-height: 45px; padding: 0 15px; font-size: 10px; }
            .social-proof { gap: 9px; }
            .avatars img { width: 31px; height: 31px; }
            .feature { gap: 9px; padding-right: 7px; padding-left: 8px; }
            .feature-icon { font-size: 25px; }
            .feature strong { font-size: 9px; }
            .feature span { font-size: 10px; }
            footer { flex-direction: column; align-items: center; text-align: center; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <nav class="nav" aria-label="Navigation principale">
            <a class="brand" href="{{ route('index') }}" aria-label="BarberChop accueil">
                <span class="brand-mark">♜</span>
                <span class="brand-copy"><strong>BARBERCHOP</strong><small>BARBER SHOP</small></span>
            </a>
            <button class="menu-toggle" id="menu-toggle" type="button" aria-label="Ouvrir le menu" aria-expanded="false">☰</button>
            <div class="nav-links" id="nav-links">
                <a class="active" href="{{ route('index') }}">Accueil</a>
                <a href="#about">À propos</a>
                <a href="{{ route('reservation.services') }}">Services</a>
                <a href="#barbers">Barbiers</a>
                <a href="#gallery">Galerie</a>
                <a href="{{ route('reservation.services') }}">Tarifs</a>
                <a href="#contact">Contact</a>
            </div>
            <a class="button header-book" href="{{ route('reservation.services') }}">Réserver <span aria-hidden="true">→</span></a>
        </nav>
    </header>

    <main>
        <section class="hero" id="gallery" aria-labelledby="hero-title">
            <div class="hero-content">
                <div class="kicker">Look good. Feel confident.</div>
                <h1 id="hero-title">More than a cut.<br>It's a <span>lifestyle.</span></h1>
                <p class="hero-copy">Coupes précises, dégradés nets et style intemporel — réalisés par des professionnels passionnés à Ben Guerir.</p>
                <div class="hero-actions">
                    <a class="button" href="{{ route('reservation.services') }}">Réserver un rendez-vous <span aria-hidden="true">↗</span></a>
                    <a class="button button-outline" href="{{ route('reservation.services') }}">Découvrir nos services</a>
                </div>
                <div class="social-proof">
                    <div class="avatars" aria-hidden="true">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=faces" alt="">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&h=100&fit=crop&crop=faces" alt="">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=faces" alt="">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&h=100&fit=crop&crop=faces" alt="">
                    </div>
                    <div class="rating"><span class="stars">★★★★★</span><small><strong>4.9</strong> · La confiance de nos clients</small></div>
                </div>
            </div>
        </section>

        <section class="features" id="barbers" aria-label="Nos engagements">
            <div class="feature-grid">
                <div class="feature"><span class="feature-icon">✂</span><div><strong>Barbiers experts</strong><span>Des professionnels qualifiés et expérimentés</span></div></div>
                <div class="feature"><span class="feature-icon">♧</span><div><strong>Produits premium</strong><span>Des produits de qualité pour un résultat soigné</span></div></div>
                <div class="feature"><span class="feature-icon">♙</span><div><strong>Propreté & hygiène</strong><span>Un espace propre pour chaque rendez-vous</span></div></div>
                <div class="feature"><span class="feature-icon">✧</span><div><strong>Votre satisfaction</strong><span>Votre style et votre confort sont notre priorité</span></div></div>
            </div>
        </section>

        <section class="intro" id="about">
            <div class="kicker" style="justify-content: center;">L'expérience BarberChop</div>
            <h2>Le style commence dans le fauteuil.</h2>
            <p>Un accueil chaleureux, un savoir-faire précis et une coupe faite pour vous. Choisissez votre prestation, consultez les tarifs et réservez votre moment chez BarberChop.</p>
            <a class="button" href="{{ route('reservation.services') }}">Voir les services et les prix <span aria-hidden="true">→</span></a>
        </section>
    </main>

    <footer id="contact">
        <span>© {{ date('Y') }} BarberChop · Ben Guerir</span>
        <a href="{{ route('reservation.services') }}">Services & réservation</a>
    </footer>
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');

        menuToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('open');
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            menuToggle.textContent = isOpen ? '×' : '☰';
        });

        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.textContent = '☰';
            });
        });
    </script>
</body>
</html>
