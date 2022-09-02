<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcs', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->string('title')->nullable();
            $table->decimal('gross_amount', 10, 2)->nullable();
            $table->decimal('loss_amount', 10, 2)->nullable();
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->decimal('total_bc_amount', 10, 2)->nullable();
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
        Schema::dropIfExists('bcs');
    }
}
