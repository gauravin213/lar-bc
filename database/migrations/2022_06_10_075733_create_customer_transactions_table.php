<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('customer_id');
            $table->integer('order_id')->nullable();
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->decimal('debit', 10, 2)->nullable();
            $table->decimal('credit', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_transactions');
    }
}
