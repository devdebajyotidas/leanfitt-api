<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('tool_id');
            $table->date('due_date');
            $table->tinyInteger('is_completed')->default('0');
            $table->tinyInteger('in_review')->default('0');
            $table->tinyInteger('is_archived')->default('0');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('action_items');
    }
}
