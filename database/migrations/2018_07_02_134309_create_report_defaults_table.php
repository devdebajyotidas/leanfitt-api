<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportDefaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_defaults', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('report_category_id')->unsigned();
            $table->string('type')->nullable();
            $table->string('label');
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->foreign('report_category_id')->references('id')->on('report_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_defaults');
    }
}
