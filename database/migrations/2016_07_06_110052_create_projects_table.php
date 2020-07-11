<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('name', 60);
            $table->string('description')->nullable();
            $table->date('proposal_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('project_value')->unsigned();
            $table->integer('proposal_value')->unsigned()->nullable();
            $table->boolean('status_id')->default(1)->comment('1: planned, 2: on progress, 3: done, 4: closed, 5: canceled, 6: on hold ');
            $table->integer('customer_id')->unsigned();
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
        Schema::drop('projects');
    }
}
