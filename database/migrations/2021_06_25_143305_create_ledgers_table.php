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
            $table->integer('type_id')->default(0);
            $table->string('code',10);
            $table->string('name',90);
            $table->string('address',180)->nullable();
            $table->string('address_other',190)->nullable();
            $table->string('phone_no',20)->nullable();
            $table->string('fax_no',20)->nullable();
            $table->string('personel_name',40)->nullable();
            $table->string('tax_reg_no',20)->nullable();
            $table->integer('bank_id')->default(0);
            $table->string('bank_account',20)->nullable();
            $table->string('beneficiary_name',40)->nullable();
            $table->decimal('balance',18,2)->default(0);
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
        Schema::dropIfExists('ledgers');
    }
}
