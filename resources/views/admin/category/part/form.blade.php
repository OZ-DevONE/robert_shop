@csrf
<div class="form-group">
    <label for="name">Наименование</label>
    <input type="text" class="form-control" name="name" id="name" placeholder="Введите наименование"
           required maxlength="100" value="{{ old('name') ?? $category->name ?? '' }}">
</div>
<div class="form-group">
    <label for="slug">ЧПУ (на англ.)</label>
    <input type="text" class="form-control" name="slug" id="slug" placeholder="Введите ЧПУ (на англ.)"
           required maxlength="100" value="{{ old('slug') ?? $category->slug ?? '' }}">
</div>
<div class="form-group">
    <label for="parent_id">Родитель</label>
    @php
        $parent_id = old('parent_id') ?? $category->parent_id ?? 0;
    @endphp
    <select name="parent_id" id="parent_id" class="form-control">
        <option value="0">Без родителя</option>
        @if (count($items))
            @include('admin.category.part.branch', ['level' => -1, 'parent' => 0])
        @endif
    </select>
</div>
<div class="form-group">
    <label for="content">Краткое описание</label>
    <textarea class="form-control" name="content" id="content" placeholder="Введите краткое описание" maxlength="200"
              rows="3">{{ old('content') ?? $category->content ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="image">Изображение</label>
    <input type="file" class="form-control-file" name="image" id="image" accept="image/png, image/jpeg">
</div>
@isset($category->image)
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
