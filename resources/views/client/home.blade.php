@extends('layouts.client')

@section('title', 'CHAIR — Find the best barber near you')

@push('styles')
<style>
    .home-hero {
        padding: 24px 0 16px;
    }
    .hero-top-row {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    @media (min-width: 1024px) {
        .hero-top-row {
            flex-direction: row;
            align-items: flex-end;
            justify-content: space-between;
            padding: 20px 0 10px;
        }
        .hero-left {
            flex: 1;
            max-width: 500px;
        }
        .hero-right {
            flex: 1;
            max-width: 580px;
        }
    }

    .location-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--primary-blue);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .hero-title {
        font-size: 2.1rem;
        font-weight: 800;
        color: var(--text-navy);
        line-height: 1.15;
        letter-spacing: -0.03em;
        margin-bottom: 6px;
    }

    .hero-subtitle {
        color: var(--text-slate);
        font-size: 1.05rem;
        font-weight: 400;
    }

    /* Search bar */
    .search-wrapper {
        margin: 18px 0 16px;
    }
    .search-bar {
        background-color: #ffffff;
        border-radius: var(--radius-pill);
        padding: 6px 8px 6px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
    }
    .search-bar input {
        border: none;
        outline: none;
        background: transparent;
        flex: 1;
        font-size: 0.95rem;
        color: var(--text-navy);
    }
    .search-bar input::placeholder {
        color: var(--text-muted);
    }
    .filter-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: var(--primary-blue-light);
        color: var(--primary-blue);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    /* Categories */
    .categories-group {
        margin: 14px 0 8px;
    }
    .categories-pills {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 4px;
    }
    .cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 22px;
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-pill);
        color: var(--text-navy);
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .cat-pill.active {
        background-color: var(--primary-blue-light);
        border-color: var(--primary-blue-border);
        color: var(--primary-blue);
    }
    .cat-caption {
        font-size: 0.86rem;
        color: var(--primary-blue);
        font-weight: 600;
        margin-top: 10px;
    }

    /* Recommended shops */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 28px 0 16px;
    }
    .section-title {
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }
    .see-all-link {
        color: var(--primary-blue);
        font-weight: 700;
        font-size: 0.92rem;
    }

    /* Grid for desktop */
    .shops-layout {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    @media (min-width: 1024px) {
        .shops-layout {
            display: grid;
            grid-template-columns: 6fr 4fr;
            gap: 24px;
            align-items: start;
        }
    }

    /* Featured Shop Card */
    .shop-featured-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        overflow: hidden;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: block;
    }
    .shop-featured-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }
    .featured-img-wrap {
        position: relative;
        width: 100%;
        height: 240px;
        overflow: hidden;
        background: #e2e8f0;
    }
    @media (min-width: 1024px) {
        .featured-img-wrap {
            height: 310px;
        }
    }
    .featured-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .featured-body {
        padding: 20px;
    }
    .featured-name-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .featured-shop-name {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-navy);
    }
    .featured-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-navy);
    }
    .featured-location {
        color: var(--text-slate);
        font-size: 0.9rem;
        margin-bottom: 16px;
    }
    .featured-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid var(--border-light);
    }
    .price-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 0.05em;
    }
    .price-val {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text-navy);
    }

    /* Compact Shop Cards List */
    .compact-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .shop-compact-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 14px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        display: flex;
        gap: 16px;
        align-items: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-decoration: none;
        color: inherit;
    }
    .shop-compact-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }
    .compact-thumb {
        width: 88px;
        height: 88px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        background: #e2e8f0;
    }
    .compact-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .compact-info {
        flex: 1;
        min-width: 0;
    }
    .compact-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }
    .compact-name {
        font-size: 1.05rem;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .compact-rating {
        font-size: 0.88rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 3px;
        flex-shrink: 0;
    }
    .compact-address {
        font-size: 0.85rem;
        color: var(--text-slate);
        margin-bottom: 8px;
    }
    .compact-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .compact-price {
        font-size: 0.92rem;
        font-weight: 800;
        color: var(--text-navy);
    }
    .btn-compact-book {
        background: var(--primary-blue);
        color: #fff;
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="chair-container">
    <!-- Hero / Top Section -->
    <section class="home-hero">
        <div class="hero-top-row">
            <div class="hero-left">
                <a href="#" class="location-badge">
                    <span>SOHO, NEW YORK</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                </a>
                <h1 class="hero-title">Hello, Welcome Back!</h1>
                <p class="hero-subtitle">Find the best barber near you.</p>
            </div>

            <div class="hero-right">
                <!-- Search Form -->
                <form action="{{ route('client.home') }}" method="GET" class="search-wrapper">
                    <div class="search-bar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--text-slate)" stroke-width="2.2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search shops, barbers, services">
                        <button type="submit" class="filter-btn" aria-label="Search and filter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <line x1="7" y1="12" x2="17" y2="12"></line>
                                <line x1="10" y1="18" x2="14" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Categories -->
                <div class="categories-group">
                    <div class="categories-pills">
                        <a href="{{ route('client.home', ['category' => 'haircut']) }}" class="cat-pill {{ ($category ?? 'haircut') === 'haircut' ? 'active' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="6" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><line x1="20" y1="4" x2="8.12" y2="15.88"></line><line x1="14.47" y1="14.48" x2="20" y2="20"></line><line x1="8.12" y1="8.12" x2="12" y2="12"></line></svg>
                            <span>Haircut</span>
                        </a>
                        <a href="{{ route('client.home', ['category' => 'beard']) }}" class="cat-pill {{ ($category ?? '') === 'beard' ? 'active' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 8c1 7 4 12 8 12s7-5 8-12c-3-2-8-2-8-2s-5 0-8 2z"></path></svg>
                            <span>Beard</span>
                        </a>
                        <a href="{{ route('client.home', ['category' => 'styling']) }}" class="cat-pill {{ ($category ?? '') === 'styling' ? 'active' : '' }}">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><line x1="10" y1="3" x2="8" y2="21"></line><line x1="16" y1="3" x2="14" y2="21"></line></svg>
                            <span>Styling</span>
                        </a>
                    </div>
                    <p class="cat-caption">Precision cuts, expertly done.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Shops -->
    <section id="shops-section">
        <div class="section-header">
            <h2 class="section-title">Recommended shops</h2>
            <a href="{{ route('client.home') }}" class="see-all-link">See all</a>
        </div>

        @if($shops->isEmpty())
            <div style="background:#fff; border-radius:18px; padding:48px 24px; text-align:center; border:1px solid var(--border-light); margin-top:16px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.8" style="margin: 0 auto 12px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <h3 style="font-size:1.15rem; font-weight:700; margin-bottom:6px;">No barbershops found</h3>
                <p style="color:var(--text-slate); font-size:0.92rem;">Try adjusting your search or filters to find what you're looking for.</p>
            </div>
        @else
            @php
                $featuredShop = $shops->first();
                $otherShops = $shops->slice(1);
            @endphp

            <div class="shops-layout">
                <!-- Featured Shop (Left on laptop, top on mobile) -->
                @if($featuredShop)
                    <div class="shop-featured-card">
                        <a href="{{ route('client.shop', $featuredShop->id) }}" class="featured-img-wrap" style="display:block;">
                            <img src="{{ $featuredShop->image }}" alt="{{ $featuredShop->name }}">
                        </a>
                        <div class="featured-body">
                            <div class="featured-name-row">
                                <a href="{{ route('client.shop', $featuredShop->id) }}" class="featured-shop-name">{{ $featuredShop->name }}</a>
                                <div class="featured-rating">
                                    <span style="color:#f59e0b;">★</span>
                                    <span>{{ $featuredShop->rating }}</span>
                                </div>
                            </div>
                            <p class="featured-location">{{ $featuredShop->city }} · {{ $featuredShop->distance }}</p>

                            <div class="featured-footer">
                                <div>
                                    <div class="price-label">FROM</div>
                                    <div class="price-val">${{ $featuredShop->minPrice }} <span style="font-size:0.85rem; font-weight:500; color:var(--text-slate);">/ service</span></div>
                                </div>
                                <a href="{{ route('client.reserve', $featuredShop->id) }}" class="chair-btn-primary" style="padding: 10px 22px;">Book now</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Other Compact Shops -->
                <div class="compact-list">
                    @foreach($otherShops as $shop)
                        <div class="shop-compact-card">
                            <a href="{{ route('client.shop', $shop->id) }}" class="compact-thumb">
                                <img src="{{ $shop->image }}" alt="{{ $shop->name }}">
                            </a>
                            <div class="compact-info">
                                <div class="compact-title-row">
                                    <a href="{{ route('client.shop', $shop->id) }}" class="compact-name">{{ $shop->name }}</a>
                                    <div class="compact-rating">
                                        <span style="color:#f59e0b;">★</span>
                                        <span>{{ $shop->rating }}</span>
                                    </div>
                                </div>
                                <p class="compact-address">{{ $shop->city }} · {{ $shop->distance }}</p>
                                <div class="compact-footer">
                                    <span class="compact-price">From ${{ $shop->minPrice }}</span>
                                    <a href="{{ route('client.reserve', $shop->id) }}" class="btn-compact-book">Book now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
</div>
@endsection
