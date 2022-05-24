@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <div class="header--xl">
            <img class="header__img" src="{{asset('images/bear.svg')}}" alt="">
        </div>

        <section class="content">
            <article class="content__container">
                        @if (count($wishlists) === 0)
                            <div class="content__container--center">
                                <h2 class="content__subtitle">You have no wishlists...</h2>
                                <a class="button__login" href="{{route('wishlists.create')}}">Create one now</a>
                            </div>
                        @else
                            <div class="content__inner">
                                <h2 class="content__subtitle">Select a wishlist</h2>
                                <p class="content__paragraph">Select one or more wishlists where you want to add the product </p>
                            </div>

                            {{-- Display errors to user --}}
                            @if($errors->any())
                                @foreach ($errors->all() as $error )
                                <div class='content__error'>
                                        <p>{{$error}}</p>
                                </div>
                                @endforeach
                            @endif

                            <form class="content__container" action="{{route('wishlists.storeProduct')}}" method="POST">
                                @csrf
                                @foreach ($wishlists as $wishlist )
                                    <input class="wishlist__input--checkbox" type="checkbox" name="{{'wishlists[' . $wishlist->id . ']'}}" id="{{$wishlist->id}}" value="{{$wishlist->id}}">
                                    <label class="wishlist" for="{{$wishlist->id}}">
                                        <div class="wishlist__inner">
                                            <h3 class="wishlist__name">{{$wishlist->name}}</h3>
                                            <p class="wishlist__progress">20% completed</p>
                                        </div>
                                        <div class="wishlist__in    ner">
                                            <img class="wishlist__img" src="{{asset('images/wishlist.svg')}}" alt="Illustration of a gifts from wishlists - Babyboom">
                                        </div>
                                    </label>
                                @endforeach

                                <input type="hidden" name="article_id" value="{{$article_id}}">

                                <button type="submit" class="button__submit" id="wishlistSubmit"> Add product </button>
                            </form>
                        @endif
            </article>
        </section>
    </main>
@endsection
