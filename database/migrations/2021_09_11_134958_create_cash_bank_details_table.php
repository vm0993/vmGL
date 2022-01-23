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
            $table->unsignedBigInteger('cash_bank_id');
            $table->unsignedBigInteger('account_id');
            $table->integer('ledger_id')->default(0);
            $table->decimal('amount',18,2)->default(0);
            $table->string('memo',110)->nullable();
            $table->timestamps();

            $table->foreign('cash_bank_id')->references('id')->on('cash_banks')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
