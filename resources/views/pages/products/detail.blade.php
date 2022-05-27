@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    @if(str_contains(url()->previous(), 'wishlists'))
                        <a class="button__back" href="{{url()->previous()}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                    @else
                        <a class="button__back" href="{{route('products')}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                    @endif
                </div>

                @if(session()->has('status'))
                    <div class='content__status'>
                        {{session('status')}}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class='content__error'>
                        {{session('error')}}
                    </div>
                @endif

                <article class="detail">
                    <img class="detail__img"  src="{{asset('storage/' . $article->image->path)}}" alt="">

                    <article class="detail__container">
                        <div class="detail__inner">
                            <h2 class="detail__category">{{$article->category->name}}</h2>
                            <h1 class="detail__title">{{$article->name}}</h1>
                            <h4 class="detail__price">{{'€ ' . $article->price}}</h4>
                        </div>

                        <div class="detail__inner">
                            <h3 class="detail__subtitle">Shop</h3>
                            <a class="detail__shop--link" href="{{$article->shop->url}}" target="_blank">
                                @if ($article->shop->name ==='Bollebuik')
                                    <img class="detail__shop" src="{{asset('storage/logos/bollebuik-logo.jpeg')}}" alt="Logo of {{$article->shop->name}}">
                                @elseif ($article->shop->name === 'Mimi Baby')
                                    <img class="detail__shop" src="{{asset('storage/logos/mimi-baby-logo.jpeg')}}" alt="Logo of {{$article->shop->name}}">
                                @elseif ($article->shop->name === 'May Mays')
                                    <img class="detail__shop" src="{{ asset('storage/logos/may-mays-logo.png')}}" alt="Logo of {{$article->shop->name}}">
                                @endif
                            </a>
                        </div>

                        <div class="detail__inner">
                            <h3 class="detail__subtitle">Description</h3>
                            @if ($article->description)
                                <p class="detail__description">{{$article->description}}</p>
                            @else
                                <p class="detail__description">This product has no description</p>
                            @endif
                        </div>

                        <div class="detail__inner">
                            <h3 class="detail__subtitle">Identifier</h3>
                            <p class="detail__identifier">{{$article->identifier}}</p>
                        </div>

                        <div class="detail__inner">
                            <a href="{{route('wishlists.add-product', ['article_id' => $article->id])}}" class="button__submit">Add to wishlist <i style="margin-left: 5px" class="bi bi-plus-lg "></i></a>
                            @if ($favorite)
                                <a href="{{route('favorites.delete', ['favorite_id' => $favorite->id, 'article_id' => $article->id])}}" class="button__register">Remove from favorites <i style="margin-left: 5px" class="bi bi-heart-fill "></i></a>
                            @else
                                <a href="{{route('favorites.add', ['article_id' => $article->id])}}" class="button__login">Add to favorites <i style="margin-left: 5px" class="bi bi-heart "></i></a>
                            @endif
                        </div>
                    </article>
                </article>
            </article>
        </section>
    </main>
@endsection
