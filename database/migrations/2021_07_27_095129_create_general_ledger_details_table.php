<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralLedgerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_ledger_details', function (Blueprint $table) {
            $table->id();
            $table->integer('general_ledger_id');
            $table->integer('account_id');
            $table->integer('cost_id')->default(0);
            $table->decimal('debet',18,2)->default(0);
            $table->decimal('credit',18,2)->default(0);
            $table->string('memo',190)->nullable();
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
        Schema::dropIfExists('general_ledger_details');
    }
}
