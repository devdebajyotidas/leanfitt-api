<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('user_id')->unsigned();
            $table->string('uuid');
            $table->string('fcm_token')->nullable();
            $table->string('api_token', 60)->unique()->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamp('last_login');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('devices');
    }
}
