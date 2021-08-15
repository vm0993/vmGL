<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0);
            $table->string('code',12);
            $table->string('name',120);
            $table->string('alias_name',120)->nullable();
            $table->integer('stock_id')->default(0);
            $table->integer('unit_id')->default(0);
            $table->integer('tax_id')->default(0);
            $table->decimal('sell_price',18,2)->default(0);
            $table->decimal('buy_price',18,2)->default(0);/* 
            $table->integer('inventory_id')->default(0);
            $table->integer('sales_id')->default(0);
            $table->integer('return_id')->default(0);
            $table->integer('discount_id')->default(0);
            $table->integer('delivery_id')->default(0);
            $table->integer('cogs_id')->default(0);
            $table->integer('purchase_id')->default(0);
            $table->integer('return_buy_id')->default(0);
            $table->integer('expense_id')->default(0); */
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
        Schema::dropIfExists('items');
    }
}
