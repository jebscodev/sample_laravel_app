<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCtsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cts_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_printed')->nullable();
            $table->date('date_signed')->nullable();
            $table->date('date_notarized')->nullable();
            $table->tinyInteger('cts_status')->default('0');
            $table->integer('total_days');
            $table->tinyInteger('kra');
            $table->integer('client_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamp('created_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cts_files');
    }
}
