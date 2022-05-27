@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--bottom">
                    <a class="button__back" href="{{route('admin.dashboard')}}"><i class="bi bi-arrow-left button__add--inner"></i></a>
                </div>
                <h1 class="content__subtitle">Scrape products</h1>

                <form class="admin__form" action="{{route('scrape.categories')}}" method="POST">
                    @csrf
                    <div class="div">
                        <label class="admin__label" for="shop">Webshop</label>
                        <select class="form__input" name="shop" id="shop" >
                            @foreach ($shops as $key => $shop)
                                <option value="{{$key}}">{{$shop}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="div">
                        <label class="admin__label" for="url">Url collection</label>
                        <input type="url" style="background-image:url('{{ asset('images/link.svg')}}')" class="form__input" required name="url" id="id" placeholder="e.g. http://bol.com/speelgoed">
                    </div>
                    <div class="div">
                        <button class="button__submit" type="submit">Scrape categories</button>
                    </div>
                </form>


                <article class="content__container">
                    <div class="content__inner">
                        <h2 class="content__subtitle">May Mays Categories</h2>
                    </div>
                    <table class="admin__table">
                            @foreach ($maymaysCategories as $maymaysCategory )
                                <tr class="admin__table--row">
                                    <td class="admin__table--cell">{{$maymaysCategory->name}}</td>
                                    <td>
                                        <form action="{{ route('scrape.articles') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="url" value="{{$maymaysCategory->url}}">
                                            <input type="hidden" name="shop" value="maymays">
                                            <button class="admin__table--button" type="submit">Scrape all articles</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </article>

                <article class="content__container">
                    <div class="content__inner">
                        <h2 class="content__subtitle">Mimi Baby Categories</h2>
                    </div>
                    <table class="admin__table">
                            @foreach ($mimibabyCategories as $mimibabyCategory )
                                <tr class="admin__table--row">
                                    <td class="admin__table--cell">{{$mimibabyCategory->name}}</td>
                                    <td>
                                        <form action="{{ route('scrape.articles') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="url" value="{{$mimibabyCategory->url}}">
                                            <input type="hidden" name="shop" value="mimibaby">
                                            <button class="admin__table--button" type="submit">Scrape all articles</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </article>

                <article class="content__container">
                    <div class="content__inner">
                        <h2 class="content__subtitle">Bollebuik Categories</h2>
                    </div>
                    <table class="admin__table">
                            @foreach ($bollebuikCategories as $bollebuikCategory )
                                <tr class="admin__table--row">
                                    <td class="admin__table--cell">{{$bollebuikCategory->name}}</td>
                                    <td>
                                        <form action="{{ route('scrape.articles') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="url" value="{{$bollebuikCategory->url}}">
                                            <input type="hidden" name="shop" value="bollebuik">
                                            <button class="admin__table--button" type="submit">Scrape all articles</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </article>
            </article>
        </section>
</main>
@endsection
