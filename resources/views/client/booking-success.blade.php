@extends('layouts.client')

@section('title', "You're all booked! — CHAIR")

@push('styles')
<style>
    .success-page-wrap {
        padding: 40px 0 60px;
        display: flex;
        justify-content: center;
    }
    .success-container {
        width: 100%;
        max-width: 520px;
        text-align: center;
    }

    .check-icon-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: var(--primary-blue-light);
        color: var(--primary-blue);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px -4px rgba(24, 119, 242, 0.25);
    }

    .success-title {
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        margin-bottom: 8px;
    }
    .success-subtitle {
        color: var(--text-slate);
        font-size: 1.05rem;
        margin-bottom: 32px;
    }

    /* Summary Card */
    .success-summary-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        text-align: left;
        margin-bottom: 28px;
    }

    .shop-header-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border-light);
        margin-bottom: 18px;
    }
    .shop-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        background: #e2e8f0;
    }
    .shop-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-info-text {
        flex: 1;
        min-width: 0;
    }
    .shop-name {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 2px;
    }
    .shop-address {
        font-size: 0.82rem;
        color: var(--text-slate);
    }
    .badge-confirmed {
        background: #ecfdf5;
        color: #065f46;
        font-weight: 700;
        font-size: 0.78rem;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        flex-shrink: 0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.92rem;
    }
    .detail-label {
        color: var(--text-slate);
    }
    .detail-value {
        font-weight: 700;
        color: var(--text-navy);
        text-align: right;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 14px;
        border-top: 1px solid var(--border-light);
        margin-top: 14px;
    }
    .total-label {
        font-size: 1.05rem;
        font-weight: 800;
    }
    .total-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--primary-blue);
    }

    .btn-view-booking {
        width: 100%;
        padding: 14px;
        font-size: 1rem;
        margin-bottom: 14px;
    }
    .back-home-link {
        color: var(--text-slate);
        font-size: 0.95rem;
        font-weight: 600;
        transition: color 0.2s;
    }
    .back-home-link:hover {
        color: var(--primary-blue);
    }
</style>
@endpush

@section('content')
<div class="chair-container success-page-wrap">
    <div class="success-container">
        <!-- Blue Checkmark -->
        <div class="check-icon-circle">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <h1 class="success-title">You’re all booked!</h1>
        <p class="success-subtitle">A little time for yourself. A whole new look.</p>

        <!-- Summary Card -->
        <div class="success-summary-card">
            <div class="shop-header-row">
                <div class="shop-avatar">
                    <img src="{{ $image }}" alt="{{ $shop->name ?? 'Shop' }}">
                </div>
                <div class="shop-info-text">
                    <h2 class="shop-name">{{ $shop->name ?? 'Salon' }}</h2>
                    <p class="shop-address">{{ $shop->address ?? 'SoHo, New York' }}</p>
                </div>
                <span class="badge-confirmed">Confirmed</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Barber</span>
                <span class="detail-value">{{ $reservation->barberMan->name ?? 'Alex Morgan' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Package</span>
                <span class="detail-value">{{ $reservation->services->pluck('name')->join(', ') ?: 'Haircut + Beard' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Date</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($reservation->dateReservation)->format('M d, Y') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Time</span>
                <span class="detail-value">{{ $reservation->time }}</span>
            </div>

            <div class="total-row">
                <span class="total-label">Total</span>
                <span class="total-value">${{ $reservation->price }}</span>
            </div>
        </div>

        <a href="{{ route('client.booking-detail', $reservation->id) }}" class="chair-btn-primary btn-view-booking">
            View my booking
        </a>
        <div>
            <a href="{{ route('client.home') }}" class="back-home-link">
                Back to home
            </a>
        </div>
    </div>
</div>
@endsection
