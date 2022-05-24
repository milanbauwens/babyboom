@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--bottom">
                    <a class="button__back" href="{{url()->previous()}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                </div>
                <form class="wishlist__form" action="{{route('wishlists.create')}}" method="POST">
                    @csrf
                    <h2 class="content__subtitle">Create wishlist</h2>

                    <div class="wishlist__container">

                        {{-- Display errors to user --}}
                        @if($errors->any())
                            @foreach ($errors->all() as $error )
                            <div class='radius flex items-center justify-center h-12 bg-red-200 text-red-800'>
                                    <p>{{$error}}</p>
                            </div>
                            @endforeach
                        @endif

                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="name" class="wishlist__title">Give your list a name</label>
                                <input class="wishlist__input" type="text" name="name" id="name" placeholder="e.g George">
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="description" class="wishlist__title">Write a short description</label>
                                <textarea class="wishlist__input--textarea" name="description" id="description" placeholder="Yay! There is a new baby in town"></textarea>
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="expiration" class="wishlist__title">Choose an expiration date</label>
                                <input class="wishlist__input" type="date" name="expiration" min="{{$today}}}" id="expiration" value="{{date('d/m/Y')}}" />
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="expiration" class="wishlist__title">Pick a password for guests</label>
                                <input class="wishlist__input" type="text" name="password" id="expiration"/>
                            </div>
                        </div>
                        <button type="submit" class="button__submit">Create</button>
                    </div>
                </form>
            </article>
        </section>
    </main>
@endsection
