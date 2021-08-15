<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldBalancereportToRequestReportings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_reportings', function (Blueprint $table) {
            $table->integer('account_id')->after('total')->default(0);
            $table->decimal('balance',18,2)->after('account_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_reportings', function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->dropColumn('balance');
        });
    }
}
