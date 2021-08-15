<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingItemAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_item_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('setting_id');
            $table->integer('inventory_id')->default(0);
            $table->integer('sale_id')->default(0);
            $table->integer('sale_return_id')->default(0);
            $table->integer('sale_discount_id')->default(0);
            $table->integer('delivery_id')->default(0);
            $table->integer('cogs_id')->default(0);
            $table->integer('purchase_return_id')->default(0);
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
        Schema::dropIfExists('setting_item_accounts');
    }
}
