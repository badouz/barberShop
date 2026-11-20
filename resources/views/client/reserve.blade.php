@extends('layouts.client')

@section('title', 'Make a reservation — ' . $shop->name)

@push('styles')
<style>
    .reserve-page-wrap {
        padding: 16px 0 40px;
    }

    .reserve-layout {
        display: flex;
        flex-direction: column;
        gap: 24px;
        margin-top: 16px;
    }
    @media (min-width: 1024px) {
        .reserve-layout {
            display: grid;
            grid-template-columns: 7fr 5fr;
            gap: 32px;
            align-items: start;
        }
    }

    /* Back link */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--text-navy);
        font-weight: 700;
        font-size: 0.95rem;
    }

    /* Shop mini card */
    .shop-summary-pill {
        background: #ffffff;
        border-radius: 18px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        margin-top: 12px;
    }
    .shop-mini-thumb {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .shop-mini-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .shop-mini-info h2 {
        font-size: 1.05rem;
        font-weight: 800;
        margin-bottom: 2px;
    }
    .shop-mini-info p {
        font-size: 0.82rem;
        color: var(--text-slate);
    }

    /* Step section cards */
    .step-section {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 20px 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
    }
    .step-header {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 16px;
    }
    .step-number {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--primary-blue);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .step-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-navy);
    }

    /* Barber selection cards */
    .barber-pick-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    .barber-pick-item {
        border: 2px solid var(--border-subtle);
        border-radius: 16px;
        padding: 14px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .barber-pick-item:hover {
        border-color: var(--primary-blue-border);
        background: var(--primary-blue-light);
    }
    .barber-pick-item.selected {
        border-color: var(--primary-blue);
        background: var(--primary-blue-light);
        box-shadow: 0 0 0 1px var(--primary-blue);
    }
    .barber-pick-item img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 8px;
        display: block;
    }
    .barber-pick-name {
        font-size: 0.92rem;
        font-weight: 700;
    }
    .barber-pick-rating {
        font-size: 0.78rem;
        color: var(--text-slate);
    }

    /* Packages / Services list */
    .service-pick-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .service-pick-item {
        border: 2px solid var(--border-subtle);
        border-radius: 16px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .service-pick-item:hover {
        border-color: var(--primary-blue-border);
        background: var(--primary-blue-light);
    }
    .service-pick-item.selected {
        border-color: var(--primary-blue);
        background: var(--primary-blue-light);
        box-shadow: 0 0 0 1px var(--primary-blue);
    }
    .service-pick-name {
        font-size: 0.98rem;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .service-pick-desc {
        font-size: 0.82rem;
        color: var(--text-slate);
    }
    .service-pick-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-blue);
        text-align: right;
    }
    .service-pick-dur {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    /* Date and Time slots */
    .form-input-date {
        width: 100%;
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle);
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-navy);
        background: #ffffff;
        outline: none;
    }
    .form-input-date:focus {
        border-color: var(--primary-blue);
    }

    .time-slots-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    @media (min-width: 640px) {
        .time-slots-grid {
            grid-template-columns: repeat(6, 1fr);
        }
    }
    .time-slot-btn {
        padding: 10px 4px;
        border-radius: 12px;
        border: 1px solid var(--border-subtle);
        background: #ffffff;
        color: var(--text-navy);
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        transition: all 0.15s ease;
    }
    .time-slot-btn:hover {
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }
    .time-slot-btn.selected {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: #ffffff;
    }

    /* Client inputs */
    .input-field-group {
        margin-bottom: 12px;
    }
    .input-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-slate);
        margin-bottom: 6px;
        display: block;
    }
    .input-text {
        width: 100%;
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-subtle);
        font-size: 0.95rem;
        font-weight: 500;
        outline: none;
    }
    .input-text:focus {
        border-color: var(--primary-blue);
    }

    /* Summary Card (Right column on desktop) */
    .booking-summary-card {
        background: #ffffff;
        border-radius: var(--radius-card);
        padding: 24px;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-card);
        position: sticky;
        top: 84px;
    }
    .summary-title {
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-light);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.92rem;
    }
    .summary-label {
        color: var(--text-slate);
    }
    .summary-val {
        font-weight: 700;
        color: var(--text-navy);
        text-align: right;
    }
    .summary-total-divider {
        height: 1px;
        background: var(--border-light);
        margin: 18px 0;
    }
    .summary-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .summary-total-label {
        font-size: 1.1rem;
        font-weight: 800;
    }
    .summary-total-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-blue);
    }

    /* Mobile bottom button */
    .mobile-confirm-bar {
        position: fixed;
        bottom: 70px;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-top: 1px solid var(--border-light);
        padding: 12px 20px;
        z-index: 85;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    @media (min-width: 1024px) {
        .mobile-confirm-bar {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
<div class="chair-container reserve-page-wrap">
    <div style="display:flex; align-items:center; justify-content:space-between;">
        <a href="{{ route('client.shop', $shop->id) }}" class="back-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Back to shop</span>
        </a>
        <h1 style="font-size:1.15rem; font-weight:800;">Make a reservation</h1>
    </div>

    <!-- Shop mini summary -->
    <div class="shop-summary-pill">
        <div class="shop-mini-thumb">
            <img src="{{ $image }}" alt="{{ $shop->name }}">
        </div>
        <div class="shop-mini-info">
            <h2>{{ $shop->name }}</h2>
            <p>{{ $shop->address }}, {{ $shop->city }} · ★ 4.9</p>
        </div>
    </div>

    <form id="reservationForm" action="{{ route('client.store', $shop->id) }}" method="POST">
        @csrf

        <input type="hidden" name="barberman_id" id="input_barberman_id" value="{{ old('barberman_id', $barbers->first()->id ?? '') }}" required>
        <input type="hidden" name="service_id" id="input_service_id" value="{{ old('service_id', $services->first()->id ?? '') }}" required>
        <input type="hidden" name="time" id="input_time" value="{{ old('time', '10:00') }}" required>

        <div class="reserve-layout">
            <!-- Left Column: Steps -->
            <div class="reserve-steps-col">
                <!-- Step 01: Barber -->
                <section class="step-section">
                    <div class="step-header">
                        <span class="step-number">01 /</span>
                        <h2 class="step-title">Choose your barber</h2>
                    </div>
                    <div class="barber-pick-grid">
                        @foreach($barbers as $b)
                            <div class="barber-pick-item {{ (old('barberman_id', $barbers->first()->id ?? null) == $b->id) ? 'selected' : '' }}"
                                 data-id="{{ $b->id }}"
                                 data-name="{{ $b->name }}"
                                 onclick="selectBarber(this)">
                                <img src="{{ $b->avatar }}" alt="{{ $b->name }}">
                                <div class="barber-pick-name">{{ $b->name }}</div>
                                <div class="barber-pick-rating">★ 4.9 Master</div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Step 02: Service / Package -->
                <section class="step-section">
                    <div class="step-header">
                        <span class="step-number">02 /</span>
                        <h2 class="step-title">Select a package</h2>
                    </div>
                    <div class="service-pick-list">
                        @foreach($services as $s)
                            <div class="service-pick-item {{ (old('service_id', $services->first()->id ?? null) == $s->id) ? 'selected' : '' }}"
                                 data-id="{{ $s->id }}"
                                 data-name="{{ $s->name }}"
                                 data-price="{{ $s->price }}"
                                 data-dur="{{ $s->duration }}"
                                 onclick="selectService(this)">
                                <div>
                                    <div class="service-pick-name">{{ $s->name }}</div>
                                    <div class="service-pick-desc">{{ $s->description ?: 'Precision grooming' }}</div>
                                </div>
                                <div>
                                    <div class="service-pick-price">${{ $s->price }}</div>
                                    <div class="service-pick-dur">{{ $s->duration }} mins</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Step 03: Date -->
                <section class="step-section">
                    <div class="step-header">
                        <span class="step-number">03 /</span>
                        <h2 class="step-title">Choose date</h2>
                    </div>
                    <input type="date"
                           name="date"
                           id="input_date"
                           class="form-input-date"
                           value="{{ old('date', now()->addDay()->format('Y-m-d')) }}"
                           min="{{ now()->format('Y-m-d') }}"
                           required
                           onchange="updateSummaryDate(this.value)">
                </section>

                <!-- Step 04: Time -->
                <section class="step-section">
                    <div class="step-header">
                        <span class="step-number">04 /</span>
                        <h2 class="step-title">Choose time</h2>
                    </div>
                    <div class="time-slots-grid">
                        @foreach($times as $t)
                            <button type="button"
                                    class="time-slot-btn {{ (old('time', '10:00') === $t) ? 'selected' : '' }}"
                                    data-time="{{ $t }}"
                                    onclick="selectTime(this)">
                                {{ $t }}
                            </button>
                        @endforeach
                    </div>
                </section>

                <!-- Step 05: Your Information -->
                <section class="step-section">
                    <div class="step-header">
                        <span class="step-number">05 /</span>
                        <h2 class="step-title">Your information</h2>
                    </div>
                    <div class="input-field-group">
                        <label class="input-label" for="client_name">Full Name</label>
                        <input type="text"
                               name="name"
                               id="client_name"
                               class="input-text"
                               value="{{ old('name', $user->name ?? '') }}"
                               required>
                    </div>
                    <div class="input-field-group">
                        <label class="input-label" for="client_phone">Phone Number</label>
                        <input type="tel"
                               name="phone"
                               id="client_phone"
                               class="input-text"
                               value="{{ old('phone', $user->phone ?? '+1 (555) 234-5678') }}"
                               required>
                    </div>
                </section>
            </div>

            <!-- Right Column: Live Booking Summary -->
            <div class="reserve-summary-col">
                <div class="booking-summary-card">
                    <h3 class="summary-title">Booking summary</h3>

                    <div class="summary-row">
                        <span class="summary-label">Shop</span>
                        <span class="summary-val">{{ $shop->name }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Barber</span>
                        <span class="summary-val" id="summary_barber">{{ $barbers->first()->name ?? '—' }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Package</span>
                        <span class="summary-val" id="summary_service">{{ $services->first()->name ?? '—' }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Date</span>
                        <span class="summary-val" id="summary_date">{{ now()->addDay()->format('M d, Y') }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Time slot</span>
                        <span class="summary-val" id="summary_time">10:00 AM</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Duration</span>
                        <span class="summary-val" id="summary_dur">{{ $services->first()->duration ?? 30 }} mins</span>
                    </div>

                    <div class="summary-total-divider"></div>

                    <div class="summary-total-row">
                        <span class="summary-total-label">Total</span>
                        <span class="summary-total-price" id="summary_total">${{ $services->first()->price ?? 30 }}</span>
                    </div>

                    <button type="submit" class="chair-btn-primary" style="width:100%; padding:14px; font-size:1.05rem;">
                        Confirm booking
                    </button>
                    <p style="text-align:center; color:var(--text-muted); font-size:0.78rem; margin-top:10px;">
                        No upfront charge. Pay directly at the shop.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile Confirm Bar -->
        <div class="mobile-confirm-bar">
            <div>
                <div style="font-size:0.75rem; color:var(--text-slate); font-weight:700;">TOTAL ESTIMATE</div>
                <div style="font-size:1.3rem; font-weight:800; color:var(--primary-blue);" id="mobile_summary_total">${{ $services->first()->price ?? 30 }}</div>
            </div>
            <button type="submit" class="chair-btn-primary" style="padding:12px 28px;">
                Confirm booking
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function selectBarber(el) {
        document.querySelectorAll('.barber-pick-item').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        const id = el.getAttribute('data-id');
        const name = el.getAttribute('data-name');
        document.getElementById('input_barberman_id').value = id;
        document.getElementById('summary_barber').textContent = name;
    }

    function selectService(el) {
        document.querySelectorAll('.service-pick-item').forEach(s => s.classList.remove('selected'));
        el.classList.add('selected');
        const id = el.getAttribute('data-id');
        const name = el.getAttribute('data-name');
        const price = el.getAttribute('data-price');
        const dur = el.getAttribute('data-dur');

        document.getElementById('input_service_id').value = id;
        document.getElementById('summary_service').textContent = name;
        document.getElementById('summary_dur').textContent = dur + ' mins';
        document.getElementById('summary_total').textContent = '$' + price;
        const mobTotal = document.getElementById('mobile_summary_total');
        if (mobTotal) mobTotal.textContent = '$' + price;
    }

    function selectTime(btn) {
        document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        const timeVal = btn.getAttribute('data-time');
        document.getElementById('input_time').value = timeVal;
        document.getElementById('summary_time').textContent = timeVal;
    }

    function updateSummaryDate(val) {
        if (!val) return;
        const d = new Date(val + 'T00:00:00');
        const formatted = d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        document.getElementById('summary_date').textContent = formatted;
    }

    // Initialize summary with selected values
    document.addEventListener('DOMContentLoaded', () => {
        const dateInput = document.getElementById('input_date');
        if (dateInput && dateInput.value) {
            updateSummaryDate(dateInput.value);
        }
    });
</script>
@endpush
