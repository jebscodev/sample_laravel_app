<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ewts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('ewt_amount', 12, 2)->default('0.00');
            $table->date('rcp_date')->nullable();
            $table->date('est_release_date')->nullable();
            $table->date('actual_release_date')->nullable();
            $table->date('date_paid')->nullable();
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
        Schema::dropIfExists('ewts');
    }
}
