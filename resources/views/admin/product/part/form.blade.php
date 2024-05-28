@csrf
<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Введите наименование"
           required maxlength="100" value="{{ old('name') ?? $product->name ?? '' }}">
</div>
<div class="form-group">
    <label for="slug">ЧПУ (на англ.)</label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="Введите ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $product->slug ?? '' }}">
</div>
<div class="form-group">
    <label for="price">Цена (руб.)</label>
    <input type="text" class="form-control w-25 d-inline mr-4" name="price" id="price" placeholder="Введите цену (руб.)"
           required value="{{ old('price') ?? $product->price ?? '' }}">
    <!-- новинка -->
    <div class="form-check form-check-inline">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->new; // редактирование товара
            if (old('new')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="new" class="form-check-input" id="new-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="new-product">Новинка</label>
    </div>
    <!-- лидер продаж -->
    <div class="form-check form-check-inline">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->hit; // редактирование товара
            if (old('hit')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="hit-product">Лидер продаж</label>
    </div>
    <!-- распродажа -->
    <div class="form-check form-check-inline">
        @php
            $checked = false; // создание нового товара
            if (isset($product)) $checked = $product->sale; // редактирование товара
            if (old('sale')) $checked = true; // были ошибки при заполнении формы
        @endphp
        <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
               @if($checked) checked @endif value="1">
        <label class="form-check-label" for="sale-product">Распродажа</label>
    </div>
</div>
<div class="form-group">
    <label for="category_id">Категория</label>
    @php
        $category_id = old('category_id') ?? $product->category_id ?? 0;
    @endphp
    <select name="category_id" id="category_id" class="form-control">
        <option value="0">Выберите</option>
        @if (count($items))
            @include('admin.product.part.branch', ['level' => -1, 'parent' => 0])
        @endif
    </select>
</div>
<div class="form-group">
    <label for="brand_id">Бренд</label>
    @php
        $brand_id = old('brand_id') ?? $product->brand_id ?? 0;
    @endphp
    <select name="brand_id" id="brand_id" class="form-control" required>
        <option value="0">Выберите</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}" @if ($brand->id == $brand_id) selected @endif>
                {{ $brand->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="sizes">Размеры</label>
    <select multiple class="form-control" name="sizes[]" id="sizes">
        @foreach($sizes as $size)
            <option value="{{ $size->id }}" 
                @if(isset($product) && $product->sizes->contains($size->id)) selected @endif>
                {{ $size->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="content">Описание</label>
    <textarea class="form-control" name="content" id="content" placeholder="Введите описание"
              rows="4">{{ old('content') ?? $product->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="image">Изображение</label>
    <input type="file" class="form-control-file" name="image" id="image" accept="image/png, image/jpeg">
</div>
@isset($product->image)
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="remove" id="remove">
        <label class="form-check-label" for="remove">
            Удалить загруженное изображение
        </label>
    </div>
@endisset
<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>
