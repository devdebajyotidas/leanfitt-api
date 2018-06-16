<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('organization_id');
            $table->string('name');
            $table->text('goal');
            $table->integer('leader');
            $table->integer('lean_sensie');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note');
            $table->date('report_date');
            $table->tinyInteger('is_archived')->default(0);
            $table->tinyInteger('is_completed')->default(0);
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
        Schema::dropIfExists('projects');
    }
}
