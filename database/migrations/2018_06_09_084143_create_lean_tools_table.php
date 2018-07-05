<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeanToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lean_tools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('featured_image')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('steps')->nullable();
            $table->longText('case_studies')->nullable();
            $table->longText('quiz')->nullable();
            $table->longText('assessment')->nullable();
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lean_tools');
    }
}
