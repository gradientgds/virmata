<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasePaymentPayablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_payment_payables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_payment_id');
            $table->unsignedInteger('payable_id');
            $table->string('payable_type');
            $table->unsignedDecimal('amount', 20, 4);
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
        Schema::dropIfExists('purchase_payment_payables');
    }
}
