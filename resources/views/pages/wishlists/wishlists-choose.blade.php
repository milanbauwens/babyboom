@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <div class="header--xl">
            <img class="header__img" src="{{asset('images/bear.svg')}}" alt="">
        </div>

        <section class="content">
            <article class="content__container">
                <div class="content__inner--bottom">
                    <a class="button__back" href="{{route('wishlists')}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                </div>
                    @if (count($wishlists) === 0)
                            <div class="content__container--center">
                                <h2 class="content__subtitle">{{ucfirst(__('you have no wishlists...'))}}</h2>
                                <a class="button__login" href="{{route('wishlists.create')}}">{{ucfirst(__('create a wishlist'))}}</a>
                            </div>
                        @else
                            <div class="content__inner">
                                <h2 class="content__subtitle">{{ucfirst(__('select a wishlist'))}}</h2>
                                <p class="content__paragraph">{{ucfirst(__('select one or more wishlists where you want to add the product'))}}</p>
                            </div>

                            {{-- Display errors to user --}}
                            @if(session()->has('error'))
                                <div class='content__error'>
                                    {{session('error')}}
                                </div>
                            @endif


                            <form class="content__container" action="{{route('wishlists.store-product')}}" method="POST">
                                @csrf
                                @foreach ($wishlists as $wishlist )
                                    <input class="wishlist__input--checkbox" type="checkbox" name="{{'wishlists[' . $wishlist->id . ']'}}" id="{{$wishlist->id}}" value="{{$wishlist->id}}">
                                    <label class="wishlist" for="{{$wishlist->id}}">
                                        <div class="wishlist__inner">
                                            <h3 class="wishlist__name">{{$wishlist->name}}</h3>
                                            <p class="wishlist__progress">{{ ucfirst(__('expires')) . ': ' . date_format(date_create($wishlist->expiration_date), 'd/m/Y')}}</p>
                                        </div>
                                        <div class="wishlist__in    ner">
                                            <img class="wishlist__img" src="{{asset('images/wishlist.svg')}}" alt="Illustration of a gifts from wishlists - Babyboom">
                                        </div>
                                    </label>
                                @endforeach

                                <input type="hidden" name="article_id" value="{{$article_id}}">

                                <button type="submit" class="button__submit" id="wishlistSubmit">{{ ucfirst(__('add to list'))}}</button>
                            </form>
                        @endif
            </article>
        </section>
    </main>
@endsection
