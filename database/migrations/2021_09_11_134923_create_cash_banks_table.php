<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->bigInteger('transaction_id')->default(0);
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180);
            $table->decimal('total',18,2)->default(0);
            $table->integer('status')->default(0)->comment('0: Post, 1: Void/Suspend');
            $table->unsignedBigInteger('created_by');
            $table->bigInteger('updated_by')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('cash_banks');
    }
}
