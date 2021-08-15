<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldApprovedbyToRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->integer('verified_by')->after('updated_by')->default(0);
            $table->integer('approved_by')->after('verified_by')->default(0);
            $table->dateTime('verified_at')->after('approved_by')->nullable();
            $table->dateTime('approved_at')->after('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('verified_by');
            $table->dropColumn('approved_by');
            $table->dropColumn('verified_at');
            $table->dropColumn('approved_at');
        });
    }
}
