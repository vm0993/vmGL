<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReportingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_reporting_details', function (Blueprint $table) {
            $table->id();
            $table->integer('request_reporting_id');
            $table->integer('service_id');
            $table->decimal('amount',18,2)->default(0);
            $table->string('memo',70)->nullable();
            $table->string('file_location',120)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('request_reporting_details');
    }
}
