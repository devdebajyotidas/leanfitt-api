<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpiChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_charts', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('project_id')->unsigned();
            $table->string('title');
            $table->string('x_label');
            $table->string('y_label');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('project_id')
                ->references('id')->on('projects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kpi_charts');
    }
}
