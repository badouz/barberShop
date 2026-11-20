@extends('layouts.client')

@section('title', $shop->name . ' — CHAIR')

@push('styles')
<style>
    .shop-page-wrap {
        padding: 16px 0 32px;
    }

    .back-nav-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--text-navy);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .back-btn:hover {
        color: var(--primary-blue);
    }

    /* Layout grid */
    .shop-hero-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    @media (min-width: 1024px) {
        .shop-hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            align-items: start;
        }
    }

    .shop-main-img-box {
        width: 100%;
        height: 260px;
        border-radius: var(--radius-card);
        overflow: hidden;
        background: #e2e8f0;
        box-shadow: var(--shadow-card);
    }
    @media (min-width: 1024px) {
        .shop-main-img-box {
            height: 380px;
        }
    }
    .shop-main-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .shop-info-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
    }
    .shop-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
    }
    .shop-name {
        font-size: 1.65rem;
        font-weight: 800;
        line-height: 1.2;
    }
    .shop-rating-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: var(--primary-blue-light);
        color: var(--primary-blue);
        padding: 6px 12px;
        border-radius: var(--radius-pill);
        font-weight: 700;
        font-size: 0.88rem;
        flex-shrink: 0;
    }
    .shop-meta-line {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-slate);
        font-size: 0.92rem;
        margin-bottom: 12px;
    }
    .shop-hours-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ecfdf5;
        color: #065f46;
        padding: 6px 12px;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 16px;
    }
    .shop-desc {
        color: var(--text-slate);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 24px;
    }
    .desktop-book-btn {
        display: none;
        width: 100%;
        text-align: center;
        padding: 14px;
        font-size: 1rem;
    }
    @media (min-width: 1024px) {
        .desktop-book-btn {
            display: inline-flex;
        }
    }

    /* Barbers section */
    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        margin: 28px 0 16px;
    }
    .barbers-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
    }
    @media (min-width: 768px) {
        .barbers-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (min-width: 1024px) {
        .barbers-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }
    .barber-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 16px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        text-align: center;
    }
    .barber-avatar-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 10px;
        background: #e2e8f0;
    }
    .barber-avatar-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .barber-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-navy);
        margin-bottom: 2px;
    }
    .barber-role {
        font-size: 0.78rem;
        color: var(--text-slate);
    }

    /* Services section */
    .services-list-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }
    @media (min-width: 768px) {
        .services-list-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
    }
    .service-row-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 20px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .service-info-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .service-info-desc {
        font-size: 0.85rem;
        color: var(--text-slate);
    }
    .service-price-block {
        text-align: right;
        flex-shrink: 0;
        margin-left: 14px;
    }
    .service-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-blue);
    }
    .service-dur {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    /* Mobile Sticky Bottom CTA */
    .mobile-bottom-cta {
        position: fixed;
        bottom: 70px;
        left: 0;
        right: 0;
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-top: 1px solid var(--border-light);
        z-index: 85;
    }
    .mobile-bottom-cta .chair-btn-primary {
        width: 100%;
        padding: 14px;
        font-size: 1rem;
    }
    @media (min-width: 1024px) {
        .mobile-bottom-cta {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="chair-container shop-page-wrap">
    <!-- Top back navigation -->
    <div class="back-nav-bar">
        <a href="{{ route('client.home') }}" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>All shops</span>
        </a>
        <button type="button" class="btn-icon-round" aria-label="Share shop">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
        </button>
    </div>

    <!-- Hero / Info Grid -->
    <div class="shop-hero-grid">
        <div class="shop-main-img-box">
            <img src="{{ $image }}" alt="{{ $shop->name }}">
        </div>

        <div class="shop-info-card">
            <div class="shop-title-row">
                <h1 class="shop-name">{{ $shop->name }}</h1>
                <div class="shop-rating-pill">
                    <span style="color:#f59e0b;">★</span>
                    <span>4.9</span>
                </div>
            </div>

            <div class="shop-meta-line">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>{{ $shop->address }}, {{ $shop->city }} · 0.8 km</span>
            </div>

            <div class="shop-hours-badge">
                <span style="width:8px; height:8px; border-radius:50%; background:#10b981; display:inline-block;"></span>
                <span>OPEN NOW · Mon–Sat · 9:00 AM – 8:00 PM</span>
            </div>

            <p class="shop-desc">
                A premium grooming destination in the heart of {{ $shop->city }}. Classic techniques meet modern precision with top-rated master barbers.
            </p>

            <a href="{{ route('client.reserve', $shop->id) }}" class="chair-btn-primary desktop-book-btn">
                Book appointment
            </a>
        </div>
    </div>

    <!-- Meet your barbers -->
    <h2 class="section-title">Meet your barbers</h2>
    <div class="barbers-grid">
        @forelse($barbers as $barber)
            <div class="barber-card">
                <div class="barber-avatar-wrap">
                    <img src="{{ $barber->avatar }}" alt="{{ $barber->name }}">
                </div>
                <div class="barber-name">{{ $barber->name }}</div>
                <div class="barber-role">Master Barber · ★ 4.9</div>
            </div>
        @empty
            <p style="color:var(--text-slate);">No barbers assigned yet.</p>
        @endforelse
    </div>

    <!-- Services list -->
    <h2 class="section-title">Available packages & services</h2>
    <div class="services-list-grid">
        @forelse($services as $svc)
            <div class="service-row-card">
                <div>
                    <h3 class="service-info-title">{{ $svc->name }}</h3>
                    <p class="service-info-desc">{{ $svc->description ?: 'Precision cut & warm finish.' }}</p>
                </div>
                <div class="service-price-block">
                    <div class="service-price">${{ $svc->price }}</div>
                    <div class="service-dur">{{ $svc->duration }} mins</div>
                </div>
            </div>
        @empty
            <p style="color:var(--text-slate);">No services listed for this shop.</p>
        @endforelse
    </div>
</div>

<!-- Mobile Sticky Book CTA -->
<div class="mobile-bottom-cta">
    <a href="{{ route('client.reserve', $shop->id) }}" class="chair-btn-primary">
        Book appointment
    </a>
</div>
@endsection
