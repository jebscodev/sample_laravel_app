<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTakeoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_takeouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('financing_scheme');
            $table->tinyInteger('loan_status')->default('0');
            $table->float('loan_amount', 12, 2)->default('0.00');
            $table->float('tcp', 12, 2)->default('0.00');
            $table->float('variance', 12, 2)->default('0.00');
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('loan_takeouts');
    }
}
