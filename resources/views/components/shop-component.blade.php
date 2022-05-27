<a class="shop" href="{{route('products.byShop', ['shop' => $shop->name])}}">
    <div class="shop__inner">
        @if ($shop->name === 'Bollebuik')
            <img class="shop__img" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$shop->name}}">
        @elseif ($shop->name === 'Mimi Baby')
            <img class="shop__img" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$shop->name}}">
        @elseif ($shop->name === 'May Mays')
            <img class="shop__img" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$shop->name}}">
        @endif
    </div>
</a>
