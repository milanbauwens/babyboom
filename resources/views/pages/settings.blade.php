@extends('layouts.app')

@section('content')
    <x-navigation />

    <header class="header--mini">
        <div class="header__inner">
           <img class="header__logo" src="{{asset('images/logo.png')}}" alt="">
        </div>
    </header>

    <main>
        <section class="content">
            <article class="content__container--solo">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">Preferences</h2>
                    <button id="editSettings" class="button__edit"><i class="bi bi-pen-fill button__edit--inner"></i></button>
                </div>

                <div class="settings__container">
                    <form id="userData" class="settings__user">
                        <div class="settings__inner">
                            <h3 class="settings__title">Firstname</h3>
                            <p class="settings__data">{{$user->firstname}}</p>
                        </div>
                        <div class="settings__inner">
                            <h3 class="settings__title">Lastname</h3>
                            <p class="settings__data">{{$user->lastname}}</p>
                        </div>
                        <div class="settings__inner">
                            <h3 class="settings__title">Email</h3>
                            <p class="settings__data">{{$user->email}}</p>
                        </div>
                    </form>
                    <img class="settings__img" src="{{asset('images/child.png')}}" alt="">
                </div>

                <div class="settings__container--bottom">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link class="button__logout" :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                        <a href="{{route('settings.delete')}}" class="button__delete" >
                            Delete account
                        </a>
                </div>


            </article>
        </section>
    </main>
@endsection
