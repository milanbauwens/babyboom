<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <link rel="stylesheet" href={{ asset('css/app.css')}}>
    <title>Babyboom</title>
</head>
<body>
    <main class="landing">
        <div class="landing__container">
            <img class="landing__img" src="{{asset('images/landingpage.png')}}" alt="https://www.freepik.com/vectors/different-ages'>Different ages vector created by pch.vector - www.freepik.com">
            <div class="landing__inner">
                <div class="landing__text">
                    <h1 class="landing__header">Welcome to <span class="landing__header--pink">babyboom</span></h1>
                    <p class="landing__paragraph--guest">Someone is expecting a baby. Help them out by buying what they need most!</p>
                </div>

                @if(session()->has('error'))
                    <div class='content__error'>
                        {{session('error')}}
                    </div>
                @endif

                <form class="auth__form" method="POST" >
                    @csrf
                    <!-- Password -->
                        <input type="hidden" name="wishlist_slug" value="{{Route::input('slug')}}">
                        <x-label  class="form__label--block" for="password" :value="__('Password')" />

                        <x-input  style="background-image:url('{{ asset('images/lock-fill.svg')}}')" class="form__input" id="password"
                                        type="password"
                                        name="password"
                                        required />

                        <button type="submit" class="button__login">
                            Visit Wishlist
                        </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
