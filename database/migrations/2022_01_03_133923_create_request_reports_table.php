<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_advance_id');
            $table->string('code',25);
            $table->date('transaction_date');
            $table->string('description',120)->nullable();
            $table->decimal('total',18,2)->default(0);
            $table->decimal('balance',18,2)->default(0);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('request_advance_id')->references('id')->on('request_advances')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_reports');
    }
}
