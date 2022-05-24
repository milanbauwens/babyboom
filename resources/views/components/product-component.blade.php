
 @if (str_contains(Request::path(), 'wishlists/detail'))
    <div class="product">
        <a href="{{route('products.detail', ['id' => $article->article_id])}}"><img class="product__img" loading="lazy" src="{{asset('storage/' . $article->path)}}" alt="{{$article->alt}}"></a>
        <div class="product__inner">
            <a class="product__link" href="{{route('products.detail', ['id' => $article->article_id])}}"><h3 class="product__title">{{Str::limit($article->alt, 20, '...')}}</h3></a>
            @if ($article->name ==='Bollebuik')
                <img class="product__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->name}}">
            @elseif ($article->name === 'Mimi Baby')
                <img class="product__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->name}}">
            @elseif ($article->name === 'May Mays')
                <img class="product__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->name}}">
            @endif
            <div class="product__inner--flex">
                <h4 class="product__price">{{'€ ' . ($article->price)}}</h4>
                <a class="product__action" onclick="window.location='{{route('wishlists.delete', ['wishlist_id' => $wishlist->id])}}'" ><i class="bi bi-trash "></i></a>
            </div>
        </div>
    </div>
 @else
    <div class="product">
        <a href="{{route('products.detail', ['id' => $article->id])}}"><img class="product__img" loading="lazy" src="{{asset('storage/' . $article->image->path)}}" alt="{{$article->image->alt}}"></a>
        <div class="product__inner">
            <a class="product__link" href="{{route('products.detail', ['id' => $article->id])}}"><h3 class="product__title">{{Str::limit($article->image->alt, 20, '...')}}</h3></a>
            @if ($article->category->name ==='Bollebuik')
                <img class="product__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->category->name }}">
            @elseif ($article->category->name === 'Mimi Baby')
                <img class="product__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->category->name }}">
            @elseif ($article->category->name === 'May Mays')
                <img class="product__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->category->name }}">
            @endif
            <div class="product__inner--flex">
                <h4 class="product__price">{{'€ ' . ($article->price)}}</h4>
                <a class="product__action" onclick="window.location='{{route('wishlists.addProduct', ['article_id' => $article->id])}}'" ><i class="bi bi-plus-lg "></i></a>
            </div>
        </div>
    </div>
@endif
