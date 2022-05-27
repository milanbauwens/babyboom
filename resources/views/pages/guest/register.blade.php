@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <form class="wishlist__form"  method="POST">
                    @csrf
                    <h2 class="content__subtitle">Who are you?</h2>

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
                                <label for="firstname" class="wishlist__title">Firstname</label>
                                <input class="wishlist__input" type="text" name="firstname" id="firstname">
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="lastname" class="wishlist__title">Lastname</label>
                                <input class="wishlist__input" type="text" name="lastname" id="lastname">
                            </div>
                        </div>
                        <div class="wishlist__wrapper">
                            <div class="wishlist__inner">
                                <label for="email" class="wishlist__title">Email</label>
                                <input class="wishlist__input" type="email" name="email" id="email">
                            </div>
                        </div>
                        <button type="submit" class="button__submit">Go to list</button>
                    </div>
                </form>
            </article>
        </section>
    </main>
@endsection
