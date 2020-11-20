<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('tranche_no');
            $table->string('client_name');
            $table->tinyInteger('civil_status');
            $table->string('address');
            $table->string('tin');
            $table->string('contact_no');
            $table->string('email_address')->nullable();
            $table->date('reservation_date');
            $table->float('reservation_amount', 12, 2)->default('0.00');
            $table->float('equity', 12, 2)->default('0.00');
            $table->integer('months_to_pay');
            $table->string('payment_scheme');
            $table->string('remarks')->nullable();
            $table->float('total_equity', 12, 2)->default('0.00');
            $table->float('total_eq_paid_less_reg_fee', 12, 2)->default('0.00');
            $table->float('monthly_equity', 12, 2)->default('0.00');
            $table->tinyInteger('is_vatted');
            $table->float('net_selling_price_wo_vat', 12, 2)->default('0.00');
            $table->float('net_selling_price_w_vat', 12, 2)->default('0.00');
            $table->float('remaining_balance', 12, 2)->default('0.00');
            $table->float('tcp', 12, 2)->default('0.00');
            $table->tinyInteger('status')->default('1');
            $table->integer('project_id'); // projects
            $table->integer('unit_id'); // units
            $table->integer('prospect_id'); // prospects
            $table->integer('broker_id'); // brokers
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
        Schema::dropIfExists('clients');
    }
}
