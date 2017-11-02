<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_workers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('agency_id');
            $table->unsignedInteger('worker_id');
            $table->timestamps();

            $table->unique(['agency_id', 'worker_id'], 'agency_worker_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agency_workers', function (Blueprint $table) {
            //
        });
    }
}
