
<div class="product">
    <a href="{{route('products.detail', ['id' => $article->id])}}"><img class="product__img" loading="lazy" src="{{asset('storage/' . $article->image->path)}}" alt="{{$article->image->alt}}"></a>
    <div class="product__inner">
        <a class="product__link" href="{{route('products.detail', ['id' => $article->id])}}"><h3 class="product__title">{{mb_strimwidth($article->name, 0, 20, '...')}}</h3></a>
        @if ($article->shop->name ==='Bollebuik')
            <img class="product__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->shop->name }}">
        @elseif ($article->shop->name === 'Mimi Baby')
            <img class="product__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->shop->name }}">
        @elseif ($article->shop->name === 'May Mays')
            <img class="product__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->shop->name }}">
        @endif
        <div class="product__inner--flex">
            <h4 class="product__price">{{'€ ' . number_format($article->price,2,',')}}</h4>
            @if (str_contains(Request::path(), 'wishlists/detail'))
                <a class="product__action" href="{{route('wishlists.delete-product', ['article_id' => $article->id])}}" ><i class="bi bi-trash"></i></a>
            @elseif (str_contains(Request::path(), 'wishlist'))
                <form method='POST'>
                    @csrf
                    <input type="hidden" name="article_id" value="{{$article->id}}">
                    <button class="product__action" type="submit" ><i class="bi bi-basket "></i></button>
                </form>
            @elseif(str_contains(Request::path(), 'basket'))
                <form method='POST' action="{{route('guest.removeFromBasket', ['slug' => Route::input('slug')])}}">
                    @csrf
                    <input type="hidden" name="article_id" value="{{$article->id}}">
                    <button class="product__action" type="submit" ><i class="bi bi-trash "></i></button>
                </form>
            @elseif (str_contains(Request::path(), 'admin'))
                <form method='POST'>
                    @csrf
                    <input type="hidden" name="article_id" value="{{$article->id}}">
                    <button class="product__action" type="submit" ><i class="bi bi-trash "></i></button>
                </form>
            @else
                <a class="product__action" href="{{route('wishlists.add-product', ['article_id' => $article->id])}}" ><i class="bi bi-plus-lg "></i></a>
            @endif
        </div>
    </div>
</div>
