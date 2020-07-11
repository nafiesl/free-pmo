<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name', 60);
            $table->string('description')->nullable();
            $table->integer('worker_id')->unsigned()->nullable();
            $table->integer('price')->unsigned()->default(0);
            $table->boolean('type_id')->default(1)->comment('1: main, 2: additional');
            $table->unsignedTinyInteger('position')->default(0);
            $table->date('target_start_date')->nullable();
            $table->date('target_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
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
        Schema::drop('jobs');
    }
}
