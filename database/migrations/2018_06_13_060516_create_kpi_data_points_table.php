<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpiDataPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_data_points', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('kpi_chart_id')->unsigned();
            $table->float('value');
            $table->date('target_date');
            $table->integer('created_by');
            $table->timestamps();
            $table->foreign('kpi_chart_id')
                ->references('id')->on('kpi_charts')
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
        Schema::dropIfExists('kpi_data_points');
    }
}
