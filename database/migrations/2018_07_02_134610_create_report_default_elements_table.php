<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportDefaultElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_default_elements', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('report_default_id')->unsigned();
            $table->string('sort')->nullable();
            $table->text('label');
            $table->timestamps();
            $table->foreign('report_default_id')->references('id')->on('report_defaults')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_default_elements');
    }
}
