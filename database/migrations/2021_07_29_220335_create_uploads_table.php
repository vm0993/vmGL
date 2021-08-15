<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name',40);
            $table->date('uploaded_at');
            $table->decimal('file_size',18,2)->default(0);
            $table->string('file_ext',10)->nullable();
            $table->string('file_type',110)->nullable();
            $table->string('status',30)->nullable();
            $table->string('current',30)->default(0)->nullable();
            $table->string('total',20)->default(0)->nullable();
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
        Schema::dropIfExists('uploads');
    }
}
