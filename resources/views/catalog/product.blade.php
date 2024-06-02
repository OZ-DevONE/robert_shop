@extends('layout.site')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 position-relative">
                        <div class="position-absolute">
                            @if($product->new)
                                <span class="badge badge-info text-white ml-1">Новинка</span>
                            @endif
                            @if($product->hit)
                                <span class="badge badge-danger ml-1">Лидер продаж</span>
                            @endif
                            @if($product->sale)
                                <span class="badge badge-success ml-1">Распродажа</span>
                            @endif
                        </div>
                        @if ($product->image)
                            @php($url = url('storage/catalog/product/image/' . $product->image))
                            <img src="{{ $url }}" alt="" class="img-fluid">
                        @else
                            <img src="https://via.placeholder.com/600x300" alt="" class="img-fluid">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <p>Цена: {{ number_format($product->price, 2, '.', '') }}</p>
                        <!-- Форма для добавления товара в корзину -->
                        <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                              method="post" class="form-inline add-to-basket">
                            @csrf
                            <label for="input-quantity">Количество</label>
                            <input type="text" name="quantity" id="input-quantity" value="1"
                                   class="form-control mx-2 w-25">
                            <button type="submit" class="btn btn-success">
                                Добавить в корзину
                            </button>
                        </form>
                        <!-- Отображение списка размеров -->
                        @if($product->sizes->isNotEmpty())
                            <div class="mt-3">
                                <h5>Доступные размеры:</h5>
                                <ul>
                                    @foreach($product->sizes as $size)
                                        <li>{{ $size->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="mt-4 mb-0">{{ $product->content }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-4">
                        <h3>Отзывы</h3>
                        @foreach($reviews as $review)
                            <div class="mb-3">
                                <strong>{{ $review->user->name }}</strong>
                                <span class="badge badge-secondary">{{ $review->rating }}/5</span>
                                <p>{{ $review->content }}</p>
                                @can('update', $review)
                                    <a href="{{ route('review.edit', ['review' => $review->id]) }}" class="btn btn-sm btn-primary">Изменить</a>
                                @endcan
                                @can('delete', $review)
                                    <form action="{{ route('review.delete', ['review' => $review->id]) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                @endcan
                            </div>
                        @endforeach

                        <!-- Пагинация -->
                        <div class="d-flex justify-content-center">
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>
                @auth
                    @if (Auth::user()->orders()->whereHas('items', function($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })->exists())
                        <div class="row mt-4">
                            <div class="col-12">
                                <h3>Оставить отзыв</h3>
                                <form action="{{ route('catalog.addReview', ['product' => $product->id]) }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="content">Отзыв</label>
                                        <textarea name="content" id="content" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="rating">Рейтинг</label>
                                        <select name="rating" id="rating" class="form-control">
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <p>Только авторизованные пользователи, которые купили этот товар, могут оставлять отзывы.</p>
                @endauth
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        @isset($product->category)
                        Категория:
                        <a href="{{ route('catalog.category', ['category' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                        @endisset
                    </div>
                    <div class="col-md-6 text-right">
                        @isset($product->brand)
                        Бренд:
                        <a href="{{ route('catalog.brand', ['brand' => $product->brand->slug]) }}">
                            {{ $product->brand->name }}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
