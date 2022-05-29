<a href="{{route('wishlists.detail', ['id' => $wishlist->id])}}" class="wishlist">
    <div class="wishlist__inner">
        <h3 class="wishlist__name">{{$wishlist->name}}</h3>
        <p class="wishlist__progress">{{ ucfirst(__('expires')) . ': ' . date_format(date_create($wishlist->expiration_date), 'd/m/Y')}}</p>
    </div>
    <div class="wishlist__in    ner">
        <img class="wishlist__img" src="{{asset('images/wishlist.svg')}}" alt="Illustration of a gifts from wishlists - Babyboom">
    </div>
</a>
