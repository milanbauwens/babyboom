@extends('layouts.app')

@section('content')
    <main>
        <section class="content">
            <article class="content__container--success">
                <article class="content__inner--success">
                    <div class="success__container">
                        <img class="success__img" src="{{asset('images/success.svg')}}" alt="">
                        <h1 class="success__title">Order is placed!</h1>
                    </div>
                    <h2 class="success__subtitle">You have ordered</h2>
                    <article class="content__inner--grid">
                        @foreach ($articles as $article )
                            @include('components.payment-productcard')
                        @endforeach
                    </article>
                    <div class="success__container--top">
                        <a class="button__submit" href="{{route('guest.wishlist', ['slug' => Route::input('slug')])}}">Return to wishlist</a>
                    </div>
                </article>
            </article>
        </section>
    </main>
@endsection
