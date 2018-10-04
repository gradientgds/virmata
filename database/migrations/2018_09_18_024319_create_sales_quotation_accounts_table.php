<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesQuotationAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_quotation_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sales_quotation_id');
            $table->unsignedInteger('vendor_id');
            $table->unsignedInteger('account_id');
            $table->boolean('fob');
            $table->unsignedDecimal('amount', 20, 4);
            $table->string('memo')->nullable();
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
        Schema::dropIfExists('sales_quotation_accounts');
    }
}
