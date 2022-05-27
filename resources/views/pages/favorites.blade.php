@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--mini">
            <div class="header__inner">
               <img class="header__img--full" src="{{asset('images/hearts.svg')}}" alt="">
            </div>
        </header>

        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">Favorites</h2>
                </div>
                @if (count($articles) === 0)
                    <div class="favorites__container">
                        <img class="favorites__img" src="{{asset('images/favorites.svg')}}" alt="">
                        <p class="favorites__title"> You have no favorite items.. </p>
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
