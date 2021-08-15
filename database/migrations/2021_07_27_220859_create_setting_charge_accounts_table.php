<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingChargeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_charge_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('setting_id');
            $table->integer('wip_id')->default(0);
            $table->integer('cogs_id')->default(0);
            $table->integer('expense_id')->default(0);
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
        Schema::dropIfExists('setting_charge_accounts');
    }
}
