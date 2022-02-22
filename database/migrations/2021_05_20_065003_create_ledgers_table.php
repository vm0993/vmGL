<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->enum('type',['CUSTOMER','VENDOR','BOTH'])->default('CUSTOMER');
            $table->string('code',10);
            $table->string('name',60);
            $table->string('address',140)->nullable();
            $table->string('other_address',180)->nullable();
            $table->string('phone_no',20)->nullable();
            $table->string('fax_no',20)->nullable();
            $table->string('tax_reg_no',24);
            $table->string('bank_account',20)->nullable();
            $table->decimal('begining_balance',18,2)->default(0);
            $table->decimal('running_balance',18,2)->default(0);
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
        Schema::dropIfExists('ledgers');
    }
}
