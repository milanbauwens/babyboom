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
            <div class="content__container--solo">
                    <form action="{{route('settings.update')}}" method="POST">
                        <div class="content__inner--flex">
                            @csrf
                            <h2 class="content__subtitle">{{ ucfirst(__('profile settings')) }}</h2>
                                @if (Route::getCurrentRoute()->getName() === 'settings.edit')
                                    <button type="submit" id="editSettings" class="button__edit">
                                        <i class="bi bi-check-lg button__edit--inner"></i>
                                    </button>
                                @else
                                    <a id="editSettings" href="{{route('settings.edit')}}" class="button__edit">
                                        <i class="bi bi-pen-fill button__edit--inner"></i>
                                    </a>
                                @endif
                        </div>

                        <div class="settings__container">
                            @if(session()->has('status'))
                                <div class='content__status'>
                                    {{session('status')}}
                                </div>
                            @endif
                            <div id="userData" class="settings__user">
                                <div class="settings__inner">
                                    <h3 class="settings__title">{{ ucfirst(__('firstname')) }}</h3>
                                    @if (Route::getCurrentRoute()->getName() === 'settings.edit')
                                        <input class="settings__input" type="text" name="firstname" value="{{$user->firstname}}">
                                    @else
                                        <p class="settings__data">{{$user->firstname}}</p>
                                    @endif
                                </div>
                                <div class="settings__inner">
                                    <h3 class="settings__title">{{ ucfirst(__('lastname')) }}</h3>
                                    @if (Route::getCurrentRoute()->getName() === 'settings.edit')
                                        <input class="settings__input" type="text" name="lastname" value="{{$user->lastname}}">
                                    @else
                                        <p class="settings__data">{{$user->lastname}}</p>
                                    @endif
                                </div>
                                <div class="settings__inner">
                                    <h3 class="settings__title">{{ ucfirst(__('email')) }}</h3>
                                    @if (Route::getCurrentRoute()->getName() === 'settings.edit')
                                        <input class="settings__input" type="text" name="email" value="{{$user->email}}">
                                    @else
                                        <p class="settings__data">{{$user->email}}</p>
                                    @endif
                                </div>
                        </div>
                        <img class="settings__img" src="{{asset('images/child.png')}}" alt="">
                    </form>
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
                </div>

                <div class="settings__container--bottom">
                    @if (auth()->user()->role)
                        <a class="button__delete" href="{{route('admin.dashboard')}}">Admin Dashboard</a>
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection
