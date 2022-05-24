<a href="{{route('wishlists.detail', ['id' => $wishlist->id])}}" class="wishlist">
    <div class="wishlist__inner">
        <h3 class="wishlist__name">{{$wishlist->name}}</h3>
        <p class="wishlist__progress">20% completed</p>
    </div>
    <div class="wishlist__in    ner">
        <img class="wishlist__img" src="{{asset('images/wishlist.svg')}}" alt="Illustration of a gifts from wishlists - Babyboom">
    </div>
</a>
