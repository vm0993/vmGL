<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_report_id');
            $table->unsignedBigInteger('cost_charge_id');
            $table->decimal('amount',18,2)->default(0);
            $table->string('memo',70)->nullable();
            $table->string('file_location',120)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('request_report_id')->references('id')->on('request_reports')->onDelete('cascade');
            $table->foreign('cost_charge_id')->references('id')->on('cost_charges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_report_details');
    }
}
