<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('request_id');
            $table->integer('account_id');
            $table->string('code',25);
            $table->date('transaction_date');
            $table->string('description',90)->nullable();
            $table->decimal('release_amount',18,2)->default(0);
            $table->integer('status')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('release_requests');
    }
}
