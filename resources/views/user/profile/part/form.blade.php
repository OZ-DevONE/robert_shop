@csrf
<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
<div class="form-group">
    <input type="text" class="form-control" name="title" placeholder="Название профиля"
           required maxlength="255" value="{{ old('title') ?? $profile->title ?? '' }}">
</div>
<div class="form-group">
    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
</div>
<div class="form-group">
    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
</div>
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
<div class="form-group">
    <button type="submit" class="btn btn-success">Сохранить</button>
</div>
