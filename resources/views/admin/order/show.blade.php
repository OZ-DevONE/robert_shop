@extends('layout.admin', ['title' => 'Просмотр заказа'])

@section('content')
    <h1>Данные по заказу № {{ $order->id }}</h1>

    <p>
        Статус заказа:
        @if ($order->status == 0)
            <span class="text-danger">{{ $statuses[$order->status] }}</span>
        @elseif (in_array($order->status, [1, 2, 3]))
            <span class="text-success">{{ $statuses[$order->status] }}</span>
        @else
            {{ $statuses[$order->status] }}
        @endif
    </p>

    <h3 class="mb-3">Состав заказа</h3>
    <table class="table table-bordered">
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Размер</th> <!-- Новый столбец для размеров -->
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Стоимость</th>
        </tr>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>
                    @if($item->sizes->isNotEmpty())
                        @foreach($item->sizes as $size)
                            {{ $size->name }}@if(!$loop->last), @endif
                        @endforeach
                    @else
                        Не указан
                    @endif
                </td>
                <td>{{ number_format($item->price, 2, '.', '') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->cost, 2, '.', '') }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5" class="text-right">Итого</th>
            <th>{{ number_format($order->amount, 2, '.', '') }}</th>
        </tr>
    </table>

    <h3 class="mb-3">Данные покупателя</h3>
    <p>Имя, фамилия: {{ $order->name }}</p>
    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p>Номер телефона: {{ $order->phone }}</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    @isset ($order->comment)
        <p>Комментарий: {{ $order->comment }}</p>
    @endisset
    <p>Поставщик услуг: {{ $order->supplier->name ?? 'Не указан' }}</p>
    @if ($order->status == 4)
        <p>Номер трекера: {{ $order->tracker_number ?? 'Не указан' }}</p>
    @endif
@endsection
