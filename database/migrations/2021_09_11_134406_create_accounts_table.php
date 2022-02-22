<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_no',20);
            $table->string('account_name',120);
            $table->integer('account_type')->default(0);
            $table->enum('can_jurnal',['YES','NO'])->default('YES');
            $table->integer('parent_account_id')->default(0);
            $table->decimal('account_balance',18,2)->default(0);
            $table->date('balance_date')->nullable();
            $table->enum('status',['ACTIVE','SUSPEND'])->default('ACTIVE');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('accounts');
    }
}
