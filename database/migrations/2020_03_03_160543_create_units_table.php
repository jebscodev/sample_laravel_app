<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id');
            $table->integer('unit_type_id');
            $table->string('unit_no');
            $table->string('level_no');
            $table->string('lot_no');
            $table->float('area', 12, 2)->default('0.00');
            $table->tinyInteger('is_premium')->default('0');
            $table->float('price_per_sqm', 12, 2)->default('0.00');
            $table->float('excess_amount', 12, 2)->default('0.00');
            $table->float('excess_of_sqm_amount', 12, 2)->default('0.00');
            $table->float('premium_amount', 12, 2)->default('0.00');
            $table->float('base_price_amount', 12, 2)->default('0.00');
            $table->float('commission_incentive_amount', 12, 2)->default('0.00');
            $table->float('nsp_amount', 12, 2)->default('0.00');
            $table->float('vat_amount', 12, 2)->default('0.00');
            $table->float('reg_fee_amount', 12, 2)->default('0.00');
            $table->float('home_automation_amount', 12, 2)->default('0.00');
            $table->float('transfer_tax_amount', 12, 2)->default('0.00');
            $table->float('doc_stamp', 12, 2)->default('0.00');
            $table->float('misc_amount', 12, 2)->default('0.00');
            $table->float('total_other_charges', 12, 2)->default('0.00');
            $table->float('reservation_fee', 12, 2)->default('0.00');
            $table->float('tcp', 12, 2)->default('0.00');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('sale_status')->default('0');
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
        Schema::dropIfExists('units');
    }
}
