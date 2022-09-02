<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->decimal('total_debit', 10, 2)->nullable();
            $table->decimal('total_credit', 10, 2)->nullable();
            $table->decimal('total_balance', 10, 2)->nullable();
            $table->string('transaction_type')->nullable();
            $table->timestamps();
            $table->index(['customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_balances');
    }
}
