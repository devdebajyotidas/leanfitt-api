<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportChartAxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_chart_axes', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('report_id')->unsigned();
            $table->string('x_axis')->nullable();
            $table->string('y_axis')->nullable();
            $table->timestamps();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_chart_axes');
    }
}
