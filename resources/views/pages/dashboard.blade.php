@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--big">
            <div class="header__inner">
                <h1 class="header__title">{{ucfirst(__("welcome"))}}, <span class="header__title--pink">{{Auth::user()->firstname}}</span></h1>
                <form action="{{route('products.search')}}">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" value="{{Request::old('search')}}" type="text" placeholder="{{ucfirst(__('search products'))}}" name="search" id="search">
                </form>
            </div>
        </header>

        <section class="content">
            <article class="content__container shops">
                <h2 class="content__subtitle">{{ucfirst(__('shops'))}}</h2>
                <div class="shops__container">
                    @foreach ($shops as $shop )
                        @include('components.shop-component')
                    @endforeach
                </div>
            </article>

            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">{{ucfirst(__('my wishlists'))}}</h2>
                    <a class="button__add" href="{{route('wishlists.new')}}"><i class="bi bi-plus-lg button__add--inner"></i></a>
                </div>
                @if (count($wishlists) === 0 )
                    <div class="favorites__container">
                        <img style="margin-bottom: 30px" class="detail__img--solo" src="{{asset('images/father.svg')}}" alt="">
                        <a class="button__login" href="{{route('wishlists.create')}}">{{ucfirst(__('create wishlist'))}}</a>
                    </div>
                @else
                    <div class="content__inner--grid">
                        @foreach ($wishlists as $wishlist )
                            @include('components.wishlist-component')
                        @endforeach
                    </div>
                @endif
            </article>
        </section>
    </main>
@endsection
