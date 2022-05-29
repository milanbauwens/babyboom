@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--small">
            <div class="header__inner">
                <form action="{{route('products.search')}}">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" value="{{old('search')}}" type="text" placeholder="Search products" name="search" id="search">
                </form>
            </div>
        </header>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">Products</h2>
                    {{-- <a href="{{route('products.filters')}}" class="button__filter"><i class="bi bi-funnel-fill button__filter--inner"></i>Filters</a> --}}
                </div>
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
