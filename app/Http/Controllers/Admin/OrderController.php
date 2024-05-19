<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderShipped;
use Illuminate\Http\Request;

class OrderController extends Controller {
    /**
     * Просмотр списка заказов
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $orders = Order::with('supplier')->orderBy('created_at', 'desc')->paginate(5);
        $statuses = Order::STATUSES;
        return view('admin.order.index', compact('orders', 'statuses'));
    }

    /**
     * Просмотр отдельного заказа
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order) {
        $order->load('supplier'); // Загрузка связанного поставщика
        $statuses = Order::STATUSES;
        return view('admin.order.show', compact('order', 'statuses'));
    }

    /**
     * Форма редактирования заказа
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order) {
        if ($order->status == 4) {
            return redirect()
                ->route('admin.order.index')
                ->with('error', 'Невозможно редактировать заказ, который уже отправлен.');
        }
    
        $statuses = Order::STATUSES;
        $order->load('supplier'); // Загрузка связанного поставщика
        return view('admin.order.edit', compact('order', 'statuses'));
    }
    

    /**
     * Обновляет заказ покупателя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order) {
        if ($order->status == 4) {
            return redirect()
                ->route('admin.order.index')
                ->with('error', 'Невозможно обновить заказ, который уже отправлен.');
        }
    
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'address' => 'required|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
        ];
    
        if ($request->input('status') == 4) {
            $rules['tracker_number'] = 'required|max:255';
        }
    
        $this->validate($request, $rules);
    
        $order->update($request->all());
    
        if ($request->input('status') == 4) {
            // Отправка уведомления пользователю
            $order->user->notify(new OrderShipped($order));
        }
    
        return redirect()
            ->route('admin.order.show', ['order' => $order->id])
            ->with('success', 'Заказ был успешно обновлен');
    }
      
}
