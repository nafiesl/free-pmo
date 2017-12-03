<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->boolean('type_id')->default(1)->comment('1:project, 2: add_job, 3:maintenance');
            $table->boolean('in_out')->default(1)->comment('0: out, 1: in');
            $table->date('date');
            $table->string('description');
            $table->string('partner_type');
            $table->integer('partner_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
