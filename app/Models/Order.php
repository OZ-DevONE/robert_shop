<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model {
    protected $fillable = [
        'user_id',
        'supplier_id',
        'name',
        'email',
        'phone',
        'address',
        'comment',
        'amount',
        'status',
        'tracker_number',
    ];

    public const STATUSES = [
        0 => 'Ожидает подтверждения заказа',
        1 => 'Оплачен',
        2 => 'Принят в сборку',
        3 => 'Собран',
        4 => 'Отправлен выбранным поставщиком услуг',
    ];

    /**
     * Преобразует дату и время создания заказа из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Преобразует дату и время обновления заказа из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Связь «один ко многим» таблицы `orders` с таблицей `order_items`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Связь «заказ принадлежит» таблицы `orders` с таблицей `users`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь «заказ принадлежит» таблицы `orders` с таблицей `suppliers`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}
