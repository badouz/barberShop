@extends('layouts.client')

@section('title', 'Reservation Details — CHAIR')

@push('styles')
<style>
    .detail-page-wrap {
        padding: 24px 0 60px;
        display: flex;
        justify-content: center;
    }
    .detail-container {
        width: 100%;
        max-width: 580px;
    }

    .back-btn-row {
        margin-bottom: 20px;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--text-navy);
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* Countdown Card */
    .countdown-card {
        background: linear-gradient(135deg, #1877f2, #0d5bbd);
        color: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px 20px;
        text-align: center;
        box-shadow: 0 10px 25px -5px rgba(24, 119, 242, 0.4);
        margin-bottom: 24px;
    }
    .countdown-label {
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-weight: 700;
        opacity: 0.85;
        margin-bottom: 8px;
    }
    .countdown-timer-display {
        font-size: 1.65rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        font-variant-numeric: tabular-nums;
    }

    /* Section Card */
    .detail-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
    }

    .shop-header-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border-light);
        margin-bottom: 18px;
    }
    .shop-thumb {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        overflow: hidden;
        flex-shrink: 0;
        background: #e2e8f0;
    }
    .shop-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-info-text {
        flex: 1;
        min-width: 0;
    }
    .shop-name {
        font-size: 1.15rem;
        font-weight: 800;
        margin-bottom: 2px;
    }
    .shop-address {
        font-size: 0.85rem;
        color: var(--text-slate);
    }
    .status-badge {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: var(--radius-pill);
        background: #ecfdf5;
        color: #065f46;
    }

    .row-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 14px;
        font-size: 0.94rem;
    }
    .row-label {
        color: var(--text-slate);
    }
    .row-val {
        font-weight: 700;
        color: var(--text-navy);
        text-align: right;
    }

    .total-separator {
        height: 1px;
        background: var(--border-light);
        margin: 16px 0;
    }
    .total-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .total-label {
        font-size: 1.05rem;
        font-weight: 800;
    }
    .total-val {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary-blue);
    }

    /* Policy Card */
    .policy-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 20px 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        margin-bottom: 24px;
    }
    .policy-title {
        font-size: 0.95rem;
        font-weight: 800;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .policy-text {
        font-size: 0.85rem;
        color: var(--text-slate);
        line-height: 1.5;
    }

    /* Reschedule Box */
    .reschedule-box {
        display: none;
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        border: 1px solid var(--primary-blue-border);
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
    }
    .reschedule-box.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="chair-container detail-page-wrap">
    <div class="detail-container">
        <!-- Back Navigation -->
        <div class="back-btn-row">
            <a href="{{ route('client.bookings') }}" class="back-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>My bookings</span>
            </a>
        </div>

        <!-- Live Countdown Banner -->
        @if($reservation->status === 'confirmed' && $appointmentAt)
            <div class="countdown-card">
                <div class="countdown-label">UNTIL YOUR APPOINTMENT</div>
                <div class="countdown-timer-display" id="countdown-timer">-- DAYS : -- HOURS : -- MINUTES</div>
            </div>
        @endif

        <!-- Summary & Details Card -->
        <div class="detail-card">
            <div class="shop-header-row">
                <div class="shop-thumb">
                    <img src="{{ $image }}" alt="{{ $shop->name ?? 'Shop' }}">
                </div>
                <div class="shop-info-text">
                    <h1 class="shop-name">{{ $shop->name ?? 'Salon' }}</h1>
                    <p class="shop-address">{{ $shop->address ?? 'SoHo, New York' }}</p>
                </div>
                <span class="status-badge" style="{{ $reservation->status === 'cancelled' ? 'background:#fef2f2; color:#991b1b;' : '' }}">
                    {{ ucfirst($reservation->status ?? 'Confirmed') }}
                </span>
            </div>

            <div class="row-item">
                <span class="row-label">Barber</span>
                <span class="row-val">{{ $reservation->barberMan->name ?? 'Alex Morgan' }}</span>
            </div>

            <div class="row-item">
                <span class="row-label">Package</span>
                <span class="row-val">{{ $reservation->services->pluck('name')->join(', ') ?: 'Haircut + Beard' }}</span>
            </div>

            <div class="row-item">
                <span class="row-label">Date</span>
                <span class="row-val">{{ \Carbon\Carbon::parse($reservation->dateReservation)->format('M d, Y') }}</span>
            </div>

            <div class="row-item">
                <span class="row-label">Time</span>
                <span class="row-val">{{ $reservation->time }}</span>
            </div>

            <div class="row-item">
                <span class="row-label">Duration</span>
                <span class="row-val">{{ $reservation->services->sum('duration') ?: 45 }} mins</span>
            </div>

            <div class="row-item">
                <span class="row-label">Booking reference</span>
                <span class="row-val" style="font-family:monospace; color:var(--primary-blue);">#CH-{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>

            <div class="row-item">
                <span class="row-label">Payment method</span>
                <span class="row-val">Pay at shop</span>
            </div>

            <div class="total-separator"></div>

            <div class="total-line">
                <span class="total-label">Total</span>
                <span class="total-val">${{ $reservation->price }}</span>
            </div>
        </div>

        <!-- Cancellation Policy -->
        <div class="policy-card">
            <h2 class="policy-title">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--primary-blue)" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                <span>Cancellation policy</span>
            </h2>
            <p class="policy-text">
                Plans change. We get it. Reschedule anytime. Free cancellation until 2 hours before your appointment.
            </p>
        </div>

        <!-- Reschedule Form (Toggleable) -->
        @if($reservation->status === 'confirmed')
            <div id="reschedule-form" class="reschedule-box">
                <h3 style="font-size:1.1rem; font-weight:800; margin-bottom:14px;">Reschedule your appointment</h3>
                <form action="{{ route('client.reschedule', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom:14px;">
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-slate); margin-bottom:6px;">Select New Date</label>
                        <input type="date" name="date" class="form-input-date" style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-subtle);"
                               value="{{ $reservation->dateReservation }}" min="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <div style="margin-bottom:18px;">
                        <label style="display:block; font-size:0.85rem; font-weight:700; color:var(--text-slate); margin-bottom:6px;">Select New Time</label>
                        <select name="time" style="width:100%; padding:12px; border-radius:12px; border:1px solid var(--border-subtle); font-size:0.95rem; font-weight:600;" required>
                            @foreach(['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'] as $t)
                                <option value="{{ $t }}" {{ $reservation->time === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:flex; gap:10px;">
                        <button type="submit" class="chair-btn-primary" style="flex:1;">Save new date</button>
                        <button type="button" class="chair-btn-secondary" onclick="toggleReschedule(false)">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Action buttons -->
            <div style="display:flex; flex-direction:column; gap:12px;">
                <button type="button" class="chair-btn-secondary" onclick="toggleReschedule(true)">
                    Reschedule appointment
                </button>

                <form action="{{ route('client.cancel', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="chair-btn-secondary" style="width:100%; color:var(--danger-red); border-color:#fca5a5;">
                        Cancel reservation
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleReschedule(show) {
        const box = document.getElementById('reschedule-form');
        if (box) {
            box.classList.toggle('active', show);
            if (show) {
                box.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    // Auto-open reschedule form if hash is #reschedule-form
    if (window.location.hash === '#reschedule-form') {
        toggleReschedule(true);
    }

    // Live countdown timer
    @if($appointmentAt)
        const targetDate = new Date("{{ $appointmentAt }}").getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const diff = targetDate - now;

            const el = document.getElementById('countdown-timer');
            if (!el) return;

            if (diff <= 0) {
                el.textContent = "IT'S TIME FOR YOUR APPOINTMENT!";
                return;
            }

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            el.textContent = `${days} DAYS : ${hours} HOURS : ${minutes} MINUTES`;
        }

        updateCountdown();
        setInterval(updateCountdown, 10000);
    @endif
</script>
@endpush
