<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPaymentReceivablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_payment_receivables', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_payment_id');
            $table->unsignedInteger('sales_invoice_id');
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
        Schema::dropIfExists('sales_payment_receivables');
    }
}
