<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('project_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->integer('vendor_id')->unsigned();
			$table->string('domain_name', 60);
			$table->string('epp_code', 60)->nullable();
			$table->integer('domain_price')->unsigned();
			$table->string('hosting_capacity', 60)->nullable();
			$table->boolean('status_id')->default(1);
			$table->integer('hosting_price')->unsigned()->nullable();
			$table->date('start_date')->nullable();
			$table->date('due_date')->nullable();
			$table->string('remark')->nullable();
			$table->timestamps();
			$table->unique(['domain_name','epp_code'], 'domain_name_epp_code');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscriptions');
	}

}
