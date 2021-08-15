<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('alias',20)->nullable();
            $table->string('name',60);
            $table->string('address',120)->nullable();
            $table->string('city',30)->nullable();
            $table->string('postal_code',6)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('fax_no',15)->nullable();
            $table->string('email',30)->nullable();
            $table->integer('pagination')->default(0);
            $table->string('company_logo',30)->nullable();
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
        Schema::dropIfExists('settings');
    }
}
