<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_bank_details', function (Blueprint $table) {
            $table->id();
            $table->integer('cash_bank_id')->references('id')->on('cash_banks')->onDelete('set null');;
            $table->integer('account_id')->references('id')->on('accounts')->onDelete('set null');;
            $table->integer('ledger_id')->default(0);
            $table->decimal('amount',18,2)->default(0);
            $table->string('memo',110)->nullable();
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
        Schema::dropIfExists('cash_bank_details');
    }
}
