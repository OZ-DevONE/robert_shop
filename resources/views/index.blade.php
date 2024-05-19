@extends('layout.site')

@section('content')
    <h1>Интернет-магазин</h1>
    <p>
        Добро пожаловать в наш интернет-магазин, где мы предлагаем широкий ассортимент брендовых вещей. 
        Наша коллекция включает в себя самые актуальные и модные товары от известных мировых брендов. 
        Мы гарантируем качество и подлинность каждого товара, представленного на нашем сайте. 
        У нас вы найдете одежду, обувь, аксессуары и многое другое, что поможет вам подчеркнуть ваш уникальный стиль.
    </p>

    @if($new->count())
        <h2>Новинки</h2>
        <div class="row">
        @foreach($new as $item)
            @include('catalog.part.product', ['product' => $item])
        @endforeach
        </div>
    @endif

    @if($hit->count())
        <h2>Лидеры продаж</h2>
        <div class="row">
            @foreach($hit as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif

    @if($sale->count())
        <h2>Распродажа</h2>
        <div class="row">
            @foreach($sale as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif
@endsection
