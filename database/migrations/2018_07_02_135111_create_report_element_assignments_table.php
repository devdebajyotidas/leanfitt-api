<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportElementAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_element_assignments', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('report_id')->unsigned();
            $table->integer('report_default_id')->unsigned();
            $table->integer('report_default_element_id')->unsigned();
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
            $table->foreign('report_default_id')->references('id')->on('report_defaults')->onDelete('cascade');
            $table->foreign('report_default_element_id')->references('id')->on('report_default_elements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_element_assignments');
    }
}
