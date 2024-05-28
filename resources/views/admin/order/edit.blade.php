@extends('layout.admin', ['title' => 'Редактирование заказа'])

@section('content')
    <h1 class="mb-4">Редактирование заказа</h1>
    <form method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            @php($status = old('status') ?? $order->status ?? 0)
            <select name="status" class="form-control" title="Статус заказа" id="status-select">
            @foreach ($statuses as $key => $value)
                <option value="{{ $key }}" @if ($key == $status) selected @endif>
                    {{ $value }}
                </option>
            @endforeach
            </select>
        </div>
        <div class="form-group" id="tracker-number-group" style="display: none;">
            <input type="text" class="form-control" name="tracker_number" placeholder="Номер трекера"
                   maxlength="255" value="{{ old('tracker_number') ?? $order->tracker_number ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Имя, Фамилия"
                   required maxlength="255" value="{{ old('name') ?? $order->name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $order->email ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Номер телефона"
                   required maxlength="255" value="{{ old('phone') ?? $order->phone ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? $order->address ?? '' }}">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="comment" placeholder="Комментарий"
                      maxlength="255" rows="2">{{ old('comment') ?? $order->comment ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="supplier_id">Выберите поставщика:</label>
            <select class="form-control" id="supplier_id" name="supplier_id" required>
                @foreach (\App\Models\Supplier::all() as $supplier)
                    <option value="{{ $supplier->id }}" 
                        {{ (old('supplier_id') ?? $order->supplier_id) == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3 class="mb-3">Состав заказа</h3>
        <table class="table table-bordered">
            <tr>
                <th>№</th>
                <th>Наименование</th>
                <th>Размер</th>
                <th>Цена</th>
                <th>Кол-во</th>
                <th>Стоимость</th>
            </tr>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <select name="sizes[{{ $item->id }}]" class="form-control">
                            <option value="">Не указан</option>
                            @foreach($item->product->sizes as $size)
                                <option value="{{ $size->id }}" {{ $item->sizes->contains($size->id) ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>{{ number_format($item->price, 2, '.', '') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->cost, 2, '.', '') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="form-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status-select');
            const trackerNumberGroup = document.getElementById('tracker-number-group');

            function toggleTrackerNumber() {
                if (statusSelect.value == 4) {
                    trackerNumberGroup.style.display = 'block';
                } else {
                    trackerNumberGroup.style.display = 'none';
                }
            }

            statusSelect.addEventListener('change', toggleTrackerNumber);
            toggleTrackerNumber();
        });
    </script>
@endsection
