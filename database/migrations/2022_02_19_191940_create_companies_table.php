<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name',40);
            $table->string('address',140)->nullable();
            $table->string('city',40)->nullable();
            $table->string('profience',40)->nullable();
            $table->string('postal_code',6)->nullable();
            $table->string('phone_no',24)->nullable();
            $table->string('fax_no',24)->nullable();
            $table->string('npwp',22)->nullable();
            $table->string('email',40)->nullable();
            $table->string('website',40)->nullable();
            $table->string('bank_branch',140)->nullable();
            $table->text('bank_address')->nullable();
            $table->string('picture_logo',60)->nullable();
            $table->integer('retained_earning_account')->default(0);
            $table->integer('yearly_profit_account')->default(0);
            $table->integer('monthly_profit_account')->default(0);
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
        Schema::dropIfExists('companies');
    }
}
