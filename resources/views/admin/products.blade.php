@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--small">
            <div class="header__inner">
                <form action="">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" value="" type="text" placeholder="{{ucfirst(__('search products'))}}" name="search" id="search">
                </form>
            </div>
        </header>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">{{ucfirst(__('products'))}}</h2>
                </div>

                @if(session()->has('status'))
                    <div class='content__status'>
                        {{session('status')}}
                    </div>
                @endif

                <div class="content__inner--grid">
                    @foreach ($articles as $article)
                        @include('components.product-component')
                    @endforeach
                </div>
            </article>
            {!! $articles->links('components.pagination') !!}
        </section>

    </main>
@endsection
