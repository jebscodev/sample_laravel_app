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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('location');
            $table->float('area', 12, 2)->default('0.00');
            $table->integer('price_variation');
            $table->float('base_price', 12, 2)->default('0.00');
            $table->float('standard_floor_area', 12, 2)->default('0.00');
            $table->float('excess_of_sqm', 12, 2)->default('0.00');
            $table->float('price_per_sqm', 12, 2)->default('0.00');
            $table->float('premium', 12, 2)->default('0.00');
            $table->float('commission', 12, 2)->default('0.00');
            $table->float('nsp', 12, 2)->default('0.00');
            $table->float('vat', 12, 2)->default('0.00');
            $table->float('reg_fee', 12, 2)->default('0.00');
            $table->float('transfer_tax', 12, 2)->default('0.00');
            $table->float('doc_stamps', 12, 2)->default('0.00');
            $table->float('required_dp', 12, 2)->default('0.00');
            $table->float('misc_home_auto', 12, 2)->default('0.00');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('projects');
    }
}
