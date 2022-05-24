@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                        <a class="button__back" href="{{route('wishlists')}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                </div>
            </article>

            <article class="content__container">
                <div class="content__inner--grid">
                    <img class="detail__img--wishlist" src="{{asset('images/father.svg')}}" alt="">
                    <div>
                        <h2 class="content__subtitle">Wishlist details</h2>
                        <div class="detail__wrapper">
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Name</h3>
                                <p class="detail__data">{{$wishlist->name}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Description</h3>
                                <p class="detail__data">{{$wishlist->description}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Password</h3>
                                <div class="content__inner--flex">
                                    <p id="wishlistPasswordVisible" hidden class="detail__data">{{$wishlist->password}}</p>
                                    <p id="wishlistPasswordInvisible" class="detail__data">******</p>
                                    <button id="show" class="button__simple"><i class="bi bi-eye-fill"></i></button>
                                    <button id="hide" hidden class="button__simple"><i class="bi bi-eye-slash-fill"></i></button>
                                </div>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Creator</h3>
                                <p class="detail__data">{{auth()->user()->firstname . ' ' . auth()->user()->firstname}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Expiration date</h3>
                                <p class="detail__data">{{$wishlist->expiration_date}}</p>
                            </div>
                            <div class="detail__inner">
                                <h3 class="detail__subtitle--pink">Link for guests</h3>
                                <p class="detail__data">{{$wishlist->slug}}</p>
                            </div>
                            <div class="settings__container--bottom">
                                <a class="button__login" href="{{route('wishlists')}}">Close wishlist for guests</a>
                                <a class="button__delete" href="{{route('wishlists')}}">Delete wishlist</a>
                            </div>
                        </div>
                    </div>

                </div>
            </article>

            <article class="content__container">
                <h2 class="content__subtitle">Products</h2>

                @if (count($articles) === 0)
                    <div class="favorites__container">
                        <img class="favorites__img" src="{{asset('images/favorites.svg')}}" alt="">
                        <a class="button__submit" href="{{route('products')}}">Add Products</a>
                    </div>
                @else
                    <div class="content__inner--grid">
                        @foreach ($articles as $article)
                            @include('components.product-component')
                        @endforeach
                    </div>
                @endif
            </article>

        </section>
    </main>
@endsection
