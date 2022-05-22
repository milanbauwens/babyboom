<nav class="nav">
    <div class="nav__inner">
        <div class="nav__page">
            @if (Route::current()->getName() === 'dashboard')
                <a href="{{ route('dashboard')}}" class='nav__icon--active'><i class="bi bi-grid-1x2-fill"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('dashboard')}}" class='nav__icon'><i class="bi bi-grid-1x2-fill"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (Route::current()->getName() === 'products')
                <a href="{{ route('products')}}" class='nav__icon--active'><i class="bi bi-search"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('products')}}" class='nav__icon'><i class="bi bi-search"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (Route::current()->getName() === 'basket')
                <a href="{{ route('basket')}}" class='nav__icon--active'><i class="bi bi-basket2-fill"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('basket')}}" class='nav__icon'><i class="bi bi-basket2-fill"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (Route::current()->getName() === 'wishlists')
                <a href="{{ route('wishlists')}}" class='nav__icon--active'><i class="bi bi-list-check"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('wishlists')}}" class='nav__icon'><i class="bi bi-list-check"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (Route::current()->getName() === 'settings')
                <a href="{{ route('settings')}}" class='nav__icon--active'><i class="bi bi-person-circle"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('settings')}}" class='nav__icon'><i class="bi bi-person-circle"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
    </div>
</nav>
