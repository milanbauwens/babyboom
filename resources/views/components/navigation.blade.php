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
            @if (str_contains(Request::path(), 'products'))
                <a href="{{ route('products')}}" class='nav__icon--active'><i class="bi bi-search"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('products')}}" class='nav__icon'><i class="bi bi-search"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (str_contains(Request::path(), 'favorites'))
                <a href="{{ route('favorites')}}" class='nav__icon--active'><i class="bi bi-heart-fill"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('favorites')}}" class='nav__icon'><i class="bi bi-heart-fill"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (str_contains(Request::path(), 'wishlists'))
                <a href="{{ route('wishlists')}}" class='nav__icon--active'><i class="bi bi-list-check"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('wishlists')}}" class='nav__icon'><i class="bi bi-list-check"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
        <div class="nav__page">
            @if (str_contains(Request::path(), 'settings'))
                <a href="{{ route('settings')}}" class='nav__icon--active'><i class="bi bi-person-circle"></i></a>
                <div class="nav__status--active"></div>
            @else
                <a href="{{ route('settings')}}" class='nav__icon'><i class="bi bi-person-circle"></i></a>
                <div class="nav__status"></div>
            @endif
        </div>
    </div>
</nav>
