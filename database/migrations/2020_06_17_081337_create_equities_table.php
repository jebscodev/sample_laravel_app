<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('unit_id');
            $table->float('total_equity', 12, 2)->default('0.00');
            $table->float('total_equity_paid', 12, 2)->default('0.00');
            $table->float('total_penalties', 12, 2)->default('0.00');
            $table->float('total_penalty_paid', 12, 2)->default('0.00');
            $table->float('remaining_balance', 12, 2)->default('0.00');
            $table->string('equity_paid_pctg');
            $table->integer('letter_of_notice_status')->default('0');
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
        Schema::dropIfExists('equities');
    }
}
