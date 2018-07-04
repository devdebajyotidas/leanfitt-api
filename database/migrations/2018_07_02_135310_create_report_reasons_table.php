<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_reasons', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('report_problem_id')->unsigned();
            $table->text('why');
            $table->timestamps();
            $table->foreign('report_problem_id')->references('id')->on('report_problems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_reasons');
    }
}
