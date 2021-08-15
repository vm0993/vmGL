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
            $table->integer('cash_bank_id');
            $table->integer('account_id');
            $table->integer('cost_id')->default(0);
            $table->decimal('amount',18,2)->default(0);
            $table->string('memo',120)->nullable();
            $table->integer('status_id')->default(0)->comment('1 : Sync with GL, 0 : Not Actice Sync');
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
