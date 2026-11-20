@props(['shop'])

<article class="featured-card shop-item" 
         data-shop-id="{{ $shop['id'] }}" 
         data-name="{{ strtolower($shop['name']) }}" 
         data-location="{{ strtolower($shop['location']) }}" 
         data-category="{{ implode(' ', $shop['categories']) }}"
         aria-labelledby="shop-title-{{ $shop['id'] }}">
    <a href="{{ route('reservation.services', ['shop_id' => $shop['id']]) }}" class="featured-image-wrapper" style="display:block;">
        <img src="{{ $shop['image'] }}" 
             alt="{{ $shop['name'] }} interior" 
             class="featured-image" 
             loading="eager" />
        <span class="featured-badge" aria-label="Featured shop">Featured</span>
    </a>

    <div class="featured-content">
        <div class="featured-header">
            <h3 id="shop-title-{{ $shop['id'] }}" class="featured-title">
                <a href="{{ route('reservation.services', ['shop_id' => $shop['id']]) }}" style="color:inherit; text-decoration:none;">{{ $shop['name'] }}</a>
            </h3>
            <div class="shop-rating" aria-label="Rating: {{ $shop['rating'] }} out of 5 stars">
                <span class="star-icon" aria-hidden="true" style="color:#f59e0b;">★</span>
                <span class="rating-value">{{ number_format($shop['rating'], 1) }}</span>
            </div>
        </div>

        <p class="featured-location">
            <svg class="icon-inline" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>{{ $shop['location'] }}</span>
        </p>

        <div class="featured-footer">
            <div class="price-box">
                @if($shop['price_from'] !== null)
                    <span class="price-label">À PARTIR DE</span>
                    <p class="price-amount">
                        <strong>{{ $shop['price_from'] }} DH</strong> 
                        <span class="price-unit">/ prestation</span>
                    </p>
                @else
                    <span class="price-label">SERVICES</span>
                    <p class="price-amount">
                        <span class="price-unit" style="font-weight:600; color:var(--text-slate);">Aucun service</span>
                    </p>
                @endif
            </div>

            <a href="{{ route('reservation.services', ['shop_id' => $shop['id']]) }}" 
               class="btn-book-primary" 
               aria-label="Book now at {{ $shop['name'] }}">
                Book now
            </a>
        </div>
    </div>
</article>
