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
            $table->integer('account_id')->references('id')->on('accounts')->onDelete('set null');
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180);
            $table->decimal('total',18,2)->default(0);
            $table->enum('status',['post','suspend'])->default('post');
            $table->bigInteger('created_by')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->bigInteger('updated_by')->nullable()->unsigned();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('cash_banks');
    }
}
