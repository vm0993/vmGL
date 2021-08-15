<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyDefaultAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_default_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('setting_id');
            $table->integer('currency_id');
            $table->integer('payable_id')->default(0);
            $table->integer('receivable_id')->default(0);
            $table->integer('dp_purchase_id')->default(0);
            $table->integer('dp_sales_id')->default(0);
            $table->integer('realize_id')->default(0);
            $table->integer('unrealize_d')->default(0);
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('currency_default_accounts');
    }
}
