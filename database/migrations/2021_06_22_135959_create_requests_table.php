<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->default(0);
            $table->string('code',20);
            $table->date('transaction_date');
            $table->string('description',180)->nullable();
            $table->decimal('request_amount',18,2)->default(0);
            $table->integer('status')->default(0)->comment('0 : Draft, 1: Submit, 2: Approve, 3: Order, 4: Receive, 5: Reporting, 6: Reject/Cancel');
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
        Schema::dropIfExists('requests');
    }
}
