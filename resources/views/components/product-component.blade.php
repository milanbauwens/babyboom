

<a class="product" href="{{route('products.detail', ['id' => $article->article_id])}}">
    <img class="product__img" loading="lazy" src="{{asset('storage/' . $article->path)}}" alt="{{$article->alt}}">
    <div class="product__inner">
        <h3 class="product__title">{{Str::limit($article->alt, 20, '...')}}</h3>
        @if ($article->name ==='Bollebuik')
            <img class="product__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->name}}">
        @elseif ($article->name === 'Mimi Baby')
            <img class="product__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->name}}">
        @elseif ($article->name === 'May Mays')
            <img class="product__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->name}}">
        @endif
        <div class="product__inner--flex">
            <h4 class="product__price">{{'€ ' . ($article->price)}}</h4>
            <button class="product__action" onclick="window.location='{{route('wishlists.addProduct', ['article_id' => $article->id])}}'" ><i class="bi bi-plus-lg "></i></button>
        </div>
    </div>
</a>
