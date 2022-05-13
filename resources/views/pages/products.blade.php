@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--small">
            <div class="header__inner">
                <form action="">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" value="" type="text" placeholder="Search products" name="search" id="search">
                </form>
            </div>
        </header>
    </main>
@endsection
