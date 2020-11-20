<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquitiesBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equities_breakdown', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('equity_no');
            $table->date('due_date');
            $table->float('monthly_equity', 12, 2)->default('0.00');
            $table->float('penalty', 12, 2)->default('0.00');
            $table->tinyInteger('payment_status')->default('0');
            $table->integer('equity_id');
            $table->integer('equity_payment_id')->nullable();
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
        Schema::dropIfExists('equities_breakdown');
    }
}
