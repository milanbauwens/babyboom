@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
                <article class="content__container">
                    @auth
                        <div class="content__inner--flex">
                            <a class="button__back" href="{{route('wishlists')}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                        </div>
                    @endauth
                </article>

            <article class="content__container">
                <div class="content__inner--grid">
                    <img class="detail__img--wishlist" src="{{asset('images/father.svg')}}" alt="">
                    <div>
                        <h2 class="content__subtitle">{{ucfirst(__('wishlist details'))}}</h2>

                        @if(session()->has('expiration'))
                            <div class='content__status'>
                                {{session('expiration')}}
                            </div>
                        @endif

                        <div class="detail__wrapper">
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">{{ucfirst(__('name'))}}</h3>
                                <p class="detail__data">{{$wishlist->name}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">{{ucfirst(__('description'))}}</h3>
                                <p class="detail__data">{{$wishlist->description}}</p>
                            </div>
                            @auth
                                <div class="detail__inner">
                                    <h3 class="detail__subtitle--pink">{{ucfirst(__('password'))}}</h3>
                                    <div class="content__inner--flex">
                                        <p id="wishlistPasswordVisible" hidden class="detail__data">{{$wishlist->password}}</p>
                                        <p id="wishlistPasswordInvisible" class="detail__data">******</p>
                                        <button id="show" class="button__simple"><i class="bi bi-eye-fill"></i></button>
                                        <button id="hide" hidden class="button__simple"><i class="bi bi-eye-slash-fill"></i></button>
                                    </div>
                                </div>
                            @endauth
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">{{ucfirst(__('creator'))}}</h3>
                                <p class="detail__data">{{$wishlist->user->firstname . ' ' . $wishlist->user->firstname}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">{{ucfirst(__('expiration date'))}}</h3>
                                <p class="detail__data">{{$wishlist->expiration_date}}</p>
                            </div>
                            @auth
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">{{ucfirst(__('link for guests'))}} <button id="copyLink" class="button__simple"><i class="bi bi-clipboard-fill"></i></button></h3>
                                    <p id='linkWishlist' class="detail__data">{{ URL::route( 'guest', ['slug' => $wishlist->slug])}}</p>
                            </div>
                            <div class="settings__container--bottom">
                                @if ($wishlist->expired)
                                    <a class="button__register--bottom" href="{{route('wishlists.edit-wishlist', ['wishlist_id' => $wishlist->id])}}">{{ ucfirst(__('reopen wishlist')) }}</a>
                                @else
                                    <a class="button__login" href="{{route('wishlists.edit-wishlist', ['wishlist_id' => $wishlist->id])}}">{{ ucfirst(__('close wishlist')) }}</a>
                                @endif
                                <a class="button__delete" href="{{route('wishlists.delete-wishlist', ['wishlist_id' => $wishlist->id])}}">{{ ucfirst(__('delete wishlist')) }}</a>
                            </div>
                            @endauth
                        </div>
                    </div>

                </div>
            </article>

            <article class="content__container">
                <h2 class="content__subtitle">{{ucfirst(__('products'))}}</h2>

            @auth
                @if(session()->has('status'))
                    <div class='content__status'>
                        {{session('status')}}
                    </div>
                @endif

                @if (count($articles) === 0)
                    <div class="favorites__container">
                        <img class="favorites__img" src="{{asset('images/favorites.svg')}}" alt="">
                        <a class="button__submit" href="{{route('products')}}">{{ucfirst(__('add products'))}}</a>
                    </div>
                @else
                    <div class="content__inner--grid">
                        @foreach ($articles as $article)
                                @include('components.product-component')
                        @endforeach
                    </div>
                @endif
            @endauth

            @guest
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

                @if (count($articles) === 0)
                    <div class="favorites__container">
                        <img class="favorites__img" src="{{asset('images/favorites.svg')}}" alt="">
                        <p class="favorites__title">{{ucfirst(__('this list is still empty'))}}</p>
                    </div>
                @else
                    <div class="content__inner--grid">
                        @foreach ($articles as $article)
                                @include('components.product-component')
                        @endforeach
                @endif
            @endguest
            </article>

        </section>
    </main>
@endsection
