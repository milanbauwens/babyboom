<div class="product">
    <img class="product__img" loading="lazy" src="{{asset('storage/' . $article->image->path)}}" alt="{{$article->image->alt}}"></a>
    <div class="product__inner">
        <h3 class="product__title">{{$article->name}}</h3></a>
        @if ($article->shop->name ==='Bollebuik')
            <img class="product__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->shop->name }}">
        @elseif ($article->shop->name === 'Mimi Baby')
            <img class="product__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->shop->name }}">
        @elseif ($article->shop->name === 'May Mays')
            <img class="product__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->shop->name }}">
        @endif
        <div class="product__inner--flex">
            <h4 class="product__price">{{'€ ' . number_format($article->price,2,',')}}</h4>
        </div>
    </div>
</div>
