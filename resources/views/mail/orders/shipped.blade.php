@component('mail::message')
# Ваш заказ отправлен

Уважаемый(ая) {{ $order->name }},

Ваш заказ №{{ $order->id }} был отправлен.

@component('mail::panel')
## Информация о заказе:
**Номер трекера:** {{ $order->tracker_number }}  
**Поставщик услуг:** {{ $order->supplier->name }}  
**Адрес доставки:** {{ $order->address }}  
@endcomponent

@component('mail::table')
| Наименование       | Цена       | Кол-во     | Стоимость  |
| :----------------- |:----------:|:----------:| ----------:|
@foreach ($order->items as $item)
| {{ $item->name }}  | {{ number_format($item->price, 2, '.', '') }} | {{ $item->quantity }} | {{ number_format($item->cost, 2, '.', '') }} |
@endforeach
| **Итого**          |            |            | **{{ number_format($order->amount, 2, '.', '') }}** |
@endcomponent

@component('mail::button', ['url' => url('/user/order/' . $order->id)])
Просмотреть заказ
@endcomponent

@component('mail::subcopy')
![Logo](https://static.wixstatic.com/media/84b06e_9826a82bdb6b42ab97175787a9bc7887~mv2.jpg/v1/fill/w_924,h_270,al_c,q_80,enc_auto/84b06e_9826a82bdb6b42ab97175787a9bc7887~mv2.jpg)
@endcomponent

С уважением,  
команда нашего магазина
@endcomponent
