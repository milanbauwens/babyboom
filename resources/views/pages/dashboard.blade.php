@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--big">
            <div class="header__inner">
                <h1 class="header__title">Welcome, <span class="header__title--pink">{{Auth::user()->firstname}}</span></h1>
                <form action="">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" type="text" placeholder="Search products" name="search" id="search">
                </form>
            </div>
        </header>

    </main>
@endsection
