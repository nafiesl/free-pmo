<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('vendor_id');
            $table->unsignedTinyInteger('type_id');
            $table->string('name', 60);
            $table->unsignedInteger('price');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('status_id')->unsigned()->default(1);
            $table->string('notes')->nullable();
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
        Schema::drop('subscriptions');
    }
}
