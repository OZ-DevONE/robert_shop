<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_item_size', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_item_id')->unsigned();
            $table->bigInteger('size_id')->unsigned();
            $table->timestamps();

            $table->foreign('order_item_id')
                  ->references('id')
                  ->on('order_items')
                  ->cascadeOnDelete();

            $table->foreign('size_id')
                  ->references('id')
                  ->on('sizes')
                  ->cascadeOnDelete();

            $table->unique(['order_item_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_item_size');
    }
}
