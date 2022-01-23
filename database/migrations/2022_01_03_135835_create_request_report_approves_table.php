<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReportApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_report_approves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_report_id');
            $table->unsignedBigInteger('account_id')->default(0);
            $table->string('description',120)->nullable();
            $table->decimal('balance',18,2)->default(0);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_report_id')->references('id')->on('request_reports')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_report_approves');
    }
}
