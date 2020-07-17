<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->string('number', 8)->unique();
            $table->date('date');
            $table->date('due_date')->nullable();
            $table->text('items');
            $table->unsignedInteger('amount');
            $table->unsignedInteger('discount')->nullable();
            $table->string('discount_notes')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedTinyInteger('status_id');
            $table->unsignedInteger('creator_id');
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
        Schema::dropIfExists('invoices');
    }
}
