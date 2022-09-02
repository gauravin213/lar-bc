<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment_status');
            $table->string('placed_by');
            $table->string('customer_id');
            $table->string('subtotal');
            $table->string('discount');
            $table->string('discount_price');
            $table->string('total');
            $table->bigInteger('balance_amount')->nullable();
            $table->string('shipping'); //rename shipping_rate
            $table->string('shipping_address')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('remark')->nullable();
            //$table->boolean('set_paid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
