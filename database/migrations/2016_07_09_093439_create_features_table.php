<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('features', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('project_id')->unsigned();
			$table->string('name', 60);
			$table->string('description')->nullable();
			$table->integer('worker_id')->unsigned()->nullable();
			$table->integer('price')->unsigned()->default(0);
			$table->boolean('type_id')->default(1)->comment('1: main, 2: additional');
			$table->boolean('position')->default(0);
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
		Schema::drop('features');
	}

}
