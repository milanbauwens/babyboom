@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <header class="header--small">
            <div class="header__inner">
                <form action="{{route('products.search')}}">
                    <input style="background-image: url('{{ asset('images/search.svg')}}')" class="header__search" value="{{request('search')}}" type="text" placeholder="Search products" name="search" id="search">
                </form>
            </div>
        </header>

        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h3 class="content__subtitle">Filter Products</h3>
                    <a class="button__back" href="{{url()->previous()}}"><i class="bi bi-x-lg button__add--inner"></i></a>
                </div>

                   {{-- Display errors to user --}}
                   @if($errors->any())
                        @foreach ($errors->all() as $error )
                        <div class='content__error'>
                                <p>{{$error}}</p>
                        </div>
                        @endforeach
                    @endif

                <form class="filter" action="{{route('products.filters')}}">
                    @csrf
                    <h4 class="filter__subtitle" >Categories</h4>
                    <div class="filter__container--flex">
                        @foreach ($categories as $category )
                            <div class="filter__input">
                                <input class="filter__input--checkbox" type="checkbox" name="{{'categories[' . $category->id . ']'}}" id="{{$category->name . $category->id}}"></input>
                                <label class="filter__label--checkbox" for="{{$category->name . $category->id}}">{{$category->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <h4 class="filter__subtitle">Price</h4>

                    <div class="filter__container--row">
                        <label class="filter__label--minmax" for="minPrice">Min:</label>
                        <input class="filter__input--minmax" type="number" name="minPrice" id="minPrice" min="{{$minPrice->price}}" value="{{ old('minPrice')}}" placeholder="{{$minPrice->price}}">
                        <label class="filter__label--minmax" for="maxPrice">Max:</label>
                        <input class="filter__input--minmax" type="number" name="maxPrice" id="maxPrice" max="{{$maxPrice->price}}" value="{{ old('maxPrice')}}" placeholder="{{$maxPrice->price + 1}}">
                    </div>


                    <h4 class="filter__subtitle">Shops</h4>
                    <div class="filter__container--flex">
                        @foreach ($shops as $shop )
                            <div class="filter__input">
                                <input class="filter__input--checkbox" type="checkbox" name="{{'shops[' . $shop->id . ']'}}" id="{{$shop->name . $shop->id}}"></input>
                                <label class="filter__label--checkbox" for="{{$shop->name . $shop->id}}">{{$shop->name}}</label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="button__submit">Show products</button>
                </form>
            </article>
        </section>

    </main>
@endsection
