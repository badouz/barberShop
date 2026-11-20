@extends('layouts.client')

@section('title', 'My bookings — CHAIR')

@push('styles')
<style>
    .bookings-page-wrap {
        padding: 24px 0 48px;
    }

    .bookings-hero {
        margin-bottom: 24px;
    }
    .bookings-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 6px;
    }
    .bookings-subtitle {
        color: var(--text-slate);
        font-size: 1.05rem;
    }

    /* Tabs */
    .tabs-bar {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid var(--border-light);
        margin-bottom: 24px;
        padding-bottom: 2px;
    }
    .tab-item {
        padding: 10px 20px;
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-slate);
        border-bottom: 3px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tab-item:hover {
        color: var(--primary-blue);
    }
    .tab-item.active {
        color: var(--primary-blue);
        border-bottom-color: var(--primary-blue);
    }

    /* Cards grid */
    .bookings-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 1024px) {
        .bookings-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }

    .booking-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 22px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-shop-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 16px;
    }
    .card-shop-thumb {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        background: #e2e8f0;
    }
    .card-shop-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .card-shop-info {
        flex: 1;
        min-width: 0;
    }
    .card-shop-name {
        font-size: 1.1rem;
        font-weight: 800;
    }
    .card-shop-address {
        font-size: 0.82rem;
        color: var(--text-slate);
    }
    .status-badge {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
    }
    .status-confirmed {
        background: #ecfdf5;
        color: #065f46;
    }
    .status-completed {
        background: #f1f5f9;
        color: #475569;
    }
    .status-cancelled {
        background: #fef2f2;
        color: #991b1b;
    }

    .booking-info-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    .info-label {
        color: var(--text-slate);
    }
    .info-val {
        font-weight: 700;
        color: var(--text-navy);
        text-align: right;
    }

    .booking-card-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid var(--border-light);
    }
    .action-row-buttons {
        display: flex;
        gap: 10px;
    }
    .btn-action-small {
        flex: 1;
        padding: 10px;
        font-size: 0.88rem;
        font-weight: 700;
        text-align: center;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-subtle);
        background: #ffffff;
        color: var(--text-navy);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-action-small:hover {
        background: var(--primary-blue-light);
        border-color: var(--primary-blue-border);
        color: var(--primary-blue);
    }
    .btn-action-cancel {
        color: var(--danger-red);
    }
    .btn-action-cancel:hover {
        background: var(--danger-light);
        border-color: #fca5a5;
        color: var(--danger-red);
    }

    .empty-state-box {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 48px 24px;
        text-align: center;
        border: 1px solid var(--border-light);
        margin-top: 16px;
    }
</style>
@endpush

@section('content')
<div class="chair-container bookings-page-wrap">
    <div class="bookings-hero">
        <h1 class="bookings-title">Your next good hair day.</h1>
        <p class="bookings-subtitle">All your appointments, in one place.</p>
    </div>

    <!-- Tabs -->
    <div class="tabs-bar">
        <a href="{{ route('client.bookings', ['tab' => 'upcoming']) }}" class="tab-item {{ $tab === 'upcoming' ? 'active' : '' }}">
            Upcoming ({{ $upcoming->count() }})
        </a>
        <a href="{{ route('client.bookings', ['tab' => 'past']) }}" class="tab-item {{ $tab === 'past' ? 'active' : '' }}">
            Past ({{ $past->count() }})
        </a>
    </div>

    @php
        $list = ($tab === 'past') ? $past : $upcoming;
    @endphp

    @if($list->isEmpty())
        <div class="empty-state-box">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.8" style="margin: 0 auto 12px;">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <h3 style="font-size:1.15rem; font-weight:700; margin-bottom:6px;">No {{ $tab }} appointments</h3>
            <p style="color:var(--text-slate); font-size:0.92rem; margin-bottom:18px;">
                {{ $tab === 'upcoming' ? "You don't have any appointments scheduled yet." : "You don't have any past appointments in your history." }}
            </p>
            @if($tab === 'upcoming')
                <a href="{{ route('client.home') }}" class="chair-btn-primary">Find a barber</a>
            @endif
        </div>
    @else
        <div class="bookings-grid">
            @foreach($list as $r)
                @php
                    $shop = $r->barberMan?->barberShop;
                    $statusClass = match($r->status) {
                        'confirmed' => 'status-confirmed',
                        'cancelled' => 'status-cancelled',
                        default => 'status-completed',
                    };
                    $statusLabel = match($r->status) {
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        default => 'Completed',
                    };
                    $thumbUrl = $shop?->barberShopImages?->first()?->path ?? 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=200&q=80';
                @endphp
                <div class="booking-card">
                    <div>
                        <div class="card-shop-header">
                            <div class="card-shop-thumb">
                                <img src="{{ $thumbUrl }}" alt="{{ $shop->name ?? 'Shop' }}">
                            </div>
                            <div class="card-shop-info">
                                <div class="card-shop-name">{{ $shop->name ?? 'Salon' }}</div>
                                <div class="card-shop-address">{{ $shop->address ?? 'SoHo, New York' }}</div>
                            </div>
                            <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </div>

                        <div class="booking-info-row">
                            <span class="info-label">Barber</span>
                            <span class="info-val">{{ $r->barberMan->name ?? 'Alex Morgan' }}</span>
                        </div>

                        <div class="booking-info-row">
                            <span class="info-label">Package</span>
                            <span class="info-val">{{ $r->services->pluck('name')->join(', ') ?: 'Haircut' }}</span>
                        </div>

                        <div class="booking-info-row">
                            <span class="info-label">Date & Time</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($r->dateReservation)->format('M d, Y') }} at {{ $r->time }}</span>
                        </div>

                        <div class="booking-info-row">
                            <span class="info-label">Total</span>
                            <span class="info-val" style="color:var(--primary-blue); font-size:1.05rem;">${{ $r->price }}</span>
                        </div>
                    </div>

                    <div class="booking-card-actions">
                        @if($r->status === 'confirmed')
                            <div class="action-row-buttons">
                                <a href="{{ route('client.booking-detail', $r->id) }}#reschedule-form" class="btn-action-small">
                                    Reschedule
                                </a>
                                <form action="{{ route('client.cancel', $r->id) }}" method="POST" style="flex:1;" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action-small btn-action-cancel" style="width:100%;">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endif

                        <a href="{{ route('client.booking-detail', $r->id) }}" class="chair-btn-primary" style="padding:10px; font-size:0.92rem;">
                            View reservation details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
