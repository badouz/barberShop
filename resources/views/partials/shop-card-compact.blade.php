@props(['shop'])

<article class="compact-card shop-item" 
         data-shop-id="{{ $shop['id'] }}" 
         data-name="{{ strtolower($shop['name']) }}" 
         data-location="{{ strtolower($shop['location']) }}" 
         data-category="{{ implode(' ', $shop['categories']) }}"
         aria-labelledby="compact-title-{{ $shop['id'] }}">
    <a href="{{ route('client.shop', $shop['id']) }}" class="compact-image-wrapper" style="display:block;">
        <img src="{{ $shop['image'] }}" 
             alt="{{ $shop['name'] }}" 
             class="compact-image" 
             loading="lazy" />
    </a>

    <div class="compact-content">
        <div class="compact-top">
            <h3 id="compact-title-{{ $shop['id'] }}" class="compact-title">
                <a href="{{ route('client.shop', $shop['id']) }}" style="color:inherit; text-decoration:none;">{{ $shop['name'] }}</a>
            </h3>
            <div class="shop-rating" aria-label="Rating: {{ $shop['rating'] }} out of 5 stars">
                <span class="star-icon" aria-hidden="true" style="color:#f59e0b;">★</span>
                <span class="rating-value">{{ number_format($shop['rating'], 1) }}</span>
            </div>
        </div>

        <p class="compact-location">
            <svg class="icon-inline" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>{{ $shop['location'] }}</span>
        </p>

        <div class="compact-bottom">
            <div class="compact-price">
                <span class="price-label">FROM</span>
                <strong>${{ $shop['price_from'] }}</strong>
            </div>

            <a href="{{ route('client.reserve', $shop['id']) }}" 
               class="btn-book-secondary" 
               aria-label="Book now at {{ $shop['name'] }}">
                Book now
            </a>
        </div>
    </div>
</article>
