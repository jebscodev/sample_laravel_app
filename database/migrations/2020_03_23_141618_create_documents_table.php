<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('cust_prof')->default('0');
            $table->tinyInteger('cust_reg')->default('0');
            $table->tinyInteger('tin_dec')->default('0');
            $table->tinyInteger('ids')->default('0');
            $table->tinyInteger('prof_acq')->default('0');
            $table->tinyInteger('res_agnt')->default('0');
            $table->tinyInteger('prov_rcpt')->default('0');
            $table->tinyInteger('term_sht')->default('0');
            $table->tinyInteger('birth_cert')->default('0');
            $table->tinyInteger('marriage_cert')->default('0');
            $table->tinyInteger('cenomar')->default('0');
            $table->tinyInteger('proof_of_income')->default('0');
            $table->tinyInteger('proof_of_billing')->default('0');
            $table->tinyInteger('pdc')->default('0');
            $table->tinyInteger('requirements_status')->default('0');
            $table->tinyInteger('status')->default('1');
            $table->date('date_completed')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('documents');
    }
}
