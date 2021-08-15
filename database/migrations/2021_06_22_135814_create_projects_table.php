<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code',10);
            $table->string('name',60);
            $table->integer('ledger_id');
            $table->string('contract_no',30)->nullable();
            $table->string('contract_title',120)->nullable();
            $table->decimal('contract_amount',18,2)->default(0);
            $table->decimal('contract_balance',18,2)->default(0);
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
        Schema::dropIfExists('projects');
    }
}
