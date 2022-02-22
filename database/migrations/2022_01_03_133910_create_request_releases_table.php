<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_releases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_advance_id');
            $table->unsignedBigInteger('account_id');
            $table->string('code',25);
            $table->date('transaction_date');
            $table->string('description',90)->nullable();
            $table->decimal('release_amount',18,2)->default(0);
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->integer('updated_by')->default(0);
            $table->timestamps();

            $table->foreign('request_advance_id')->references('id')->on('request_advances')->onDelete('cascade');
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
        Schema::dropIfExists('request_releases');
    }
}
