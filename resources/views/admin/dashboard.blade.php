@extends('layouts.app')

@section('content')
    <x-navigation />

    <main>
        <section class="content">
            <article class="content__container">
                <div class="content__inner--flex">
                    <h2 class="content__subtitle">Admin Dashboard</h2>
                    <a class="button__back" href="{{route('settings')}}"><i class="bi bi-x-lg button__add--inner"></i></a>
                </div>
                <div class="content__inner">
                    <article class="admin__inner">
                        <a class="admin__card" href="{{route('scrape')}}">
                            <h1 class="admin__title">{{ucfirst(__('scrape products'))}}</h1>
                        </a>
                    </article>
                    <article class="admin__inner">
                        <a class="admin__card" href="{{route('admin.products')}}">
                            <h1 class="admin__title">{{ucfirst(__('all products'))}}</h1>
                        </a>
                    </article>
                </div>
            </article>
        </section>
    </main>
@endsection
