@extends('layout.site', ['title' => 'Оформить заказ'])

@section('content')
    <h1 class="mb-4">Оформить заказ</h1>
    @if ($profiles && $profiles->count())
        @include('basket.select', ['current' => $profile->id ?? 0])
    @endif
    <form method="post" action="{{ route('basket.saveorder') }}" id="checkout">
        @csrf
        @php
            $user = auth()->user();
        @endphp
        {{-- <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Имя, Фамилия"
                   required maxlength="255" value="{{ old('name') ?? $user->name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $user->email ?? '' }}">
        </div> --}}
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Номер телефона"
                   required maxlength="255" value="{{ old('phone') ?? $profile->phone ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="comment" placeholder="Комментарий"
                      maxlength="255" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="supplier_id">Выберите поставщика:</label>
            <select class="form-control" id="supplier_id" name="supplier_id" required>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" 
                        {{ (old('supplier_id') ?? $profile->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <h2 class="mb-4">Товары в корзине</h2>
        @foreach($products as $product)
            <div class="form-group">
                <label for="sizes_{{ $product->id }}">Выберите размер для {{ $product->name }}:</label>
                <select class="form-control" id="sizes_{{ $product->id }}" name="sizes[{{ $product->id }}]">
                    <option value="">Уточнить при заказе</option>
                    @foreach($product->sizes as $size)
                        <option value="{{ $size->id }}" {{ old('sizes.' . $product->id) == $size->id ? 'selected' : '' }}>
                            {{ $size->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endforeach
        <div class="form-group">
            <button type="submit" class="btn btn-success">Оформить</button>
        </div>
    </form>
@endsection
