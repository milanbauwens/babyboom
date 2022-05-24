@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <div class="header--xl">
            <img class="header__img" src="{{asset('images/bird.svg')}}" alt="">
        </div>

        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">My wishlists</h2>
                    <a class="button__add" href="{{route('wishlists.new')}}"><i class="bi bi-plus-lg button__add--inner"></i></a>
                </div>

                @if(session()->has('status'))
                    <div class='content__status'>
                        {{session('status')}}
                    </div>
                @endif

                <div class="content__inner--grid">
                    @foreach ($wishlists as $wishlist )
                        @include('components.wishlist-component')
                    @endforeach
                </div>
            </article>
        </section>
    </main>
@endsection
