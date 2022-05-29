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
                    <h2 class="content__subtitle">{{ucfirst(__('create a wishlist'))}}</h2>

                    <div class="wishlist__container">

                        {{-- Display errors to user --}}
                        @if($errors->any())
                            @foreach ($errors->all() as $error )
                            <div class='content__error'>
                                    <p>{{$error}}</p>
                            </div>
                            @endforeach
                        @endif

                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="name" class="wishlist__title">{{ucfirst(__('give your list a name'))}}</label>
                                <input class="wishlist__input" type="text" name="name" id="name" placeholder="e.g George">
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="description" class="wishlist__title">{{ucfirst(__('write a short description'))}}</label>
                                <textarea class="wishlist__input--textarea" name="description" id="description" placeholder="Yay! There is a new baby in town"></textarea>
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="expiration" class="wishlist__title">{{ucfirst(__('choose an expiration date'))}}</label>
                                <input class="wishlist__input" type="date" name="expiration" min="{{$today}}}" id="expiration" value="{{date('d/m/Y')}}" />
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="expiration" class="wishlist__title">{{ucfirst(__('pick a password for guests'))}}</label>
                                <input class="wishlist__input" type="text" name="password" id="expiration"/>
                            </div>
                        </div>
                        <button type="submit" class="button__submit">{{ucfirst(__("Create"))}}</button>
                    </div>
                </form>
            </article>
        </section>
    </main>
@endsection
