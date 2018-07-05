<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionItemAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_item_assignments', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('action_item_id')->unsigned();
            $table->date('target_date');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->foreign('action_item_id')->references('id')->on('action_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_item_assignments');
    }
}
