@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">Basket</h2>
                </div>
                @if (count($articles) === 0)
                    <div class="favorites__container">
                        <img class="favorites__img" src="{{asset('images/favorites.svg')}}" alt="">
                        <p class="favorites__title"> Your basket is still empty </p>
                    </div>
                @else
                    <div class="content__inner--grid">
                        @foreach ($articles as $article)
                            @include('components.product-component')
                        @endforeach
                    </div>
                @endif
            </article>

            @if (count($articles) > 0)
            <article class="basket">
                <div class="basket__price">
                    <div class="basket__inner--flex">
                        <h3>Total:</h3>
                        <p class="basket__price--total">€ {{$cart->getTotal()}} </p>
                    </div>
                    <a href="{{route('guest.checkout', ['slug' => Route::input('slug')])}}" class="button__checkout">Checkout</a>
                </div>
            </article>
            @endif

        </section>
    </main>
@endsection
