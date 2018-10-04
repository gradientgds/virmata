<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('shipping_service_id');
            $table->unsignedInteger('marketplace_id');
            $table->unsignedInteger('marketplace_invoice_number');
            $table->unsignedInteger('accurate_invoice_number');
            $table->date('date');
            $table->date('due_date');
            $table->text('description')->nullable();
            $table->boolean('ppn');
            $table->boolean('ppn_included');
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
        Schema::dropIfExists('sales_invoices');
    }
}
