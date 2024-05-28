<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'cost',
    ];

    public function sizes() {
        return $this->belongsToMany(Size::class, 'order_item_size');
    }

    /**
     * Связь «элемент принадлежит» таблицы `order_item` с таблицей `products`
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
