<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquityPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equity_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_paid');
            $table->float('total_amount_payable', 12, 2)->default('0.00');
            $table->float('less_advance_payment', 12, 2)->default('0.00');
            $table->float('remaining_payable', 12, 2)->default('0.00');
            $table->float('amount_paid', 12, 2)->default('0.00');
            $table->float('amount_change', 12, 2)->default('0.00');
            $table->tinyInteger('is_added_to_advance')->nullable();
            $table->string('receipt_no_equity')->nullable();
            $table->string('receipt_no_penalty')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('equity_payments');
    }
}
