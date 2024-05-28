@extends('layout.admin', ['title' => 'Все заказы'])

@section('content')
    <h1>Все заказы</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.order.index') }}" class="form-inline mb-3">
        <div class="form-group mr-3">
            <label for="status">Фильтр по статусу:</label>
            <select class="form-control ml-2" id="status" name="status">
                <option value="">Все</option>
                @foreach ($statuses as $key => $value)
                    <option value="{{ $key }}" {{ isset($currentStatus) && $currentStatus == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mr-3">
            <label for="sort">Сортировать по дате:</label>
            <select class="form-control ml-2" id="sort" name="sort">
                <option value="newest" {{ isset($currentSort) && $currentSort == 'newest' ? 'selected' : '' }}>От новых к старым</option>
                <option value="oldest" {{ isset($currentSort) && $currentSort == 'oldest' ? 'selected' : '' }}>От старых к новым</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Применить</button>
    </form>

    <table class="table table-bordered">
        <tr>
            <th>№</th>
            <th width="12%">Дата и время</th>
            <th width="5%">Статус</th>
            <th width="12%">Покупатель</th>
            <th width="12%">Адрес почты</th>
            <th width="12%">Номер телефона</th>
            <th width="12%">Пользователь</th>
            <th width="12%">Поставщик услуг</th>
            <th><i class="fas fa-eye"></i></th>
            <th><i class="fas fa-edit"></i></th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if ($order->status == 0)
                        <span class="text-danger">{{ $statuses[$order->status] }}</span>
                    @elseif (in_array($order->status, [1, 2, 3]))
                        <span class="text-success">{{ $statuses[$order->status] }}</span>
                    @else
                        {{ $statuses[$order->status] }}
                    @endif
                </td>
                <td>{{ $order->name }}</td>
                <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                <td>{{ $order->phone }}</td>
                <td>
                    @isset($order->user)
                        {{ $order->user->name }}
                    @endisset
                </td>
                <td>{{ $order->supplier->name ?? 'Не указан' }}</td>
                <td>
                    <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    @if ($order->status != 4)
                        <a href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                            <i class="far fa-edit"></i>
                        </a>
                    @else
                        <i class="far fa-edit text-muted"></i>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    {{ $orders->links() }}
@endsection
