<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address_raw');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('shipping_service_id')->nullable();
            $table->unsignedInteger('marketplace_id')->nullable();
            $table->string('reference_number')->nullable();
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
        Schema::dropIfExists('sales_orders');
    }
}
