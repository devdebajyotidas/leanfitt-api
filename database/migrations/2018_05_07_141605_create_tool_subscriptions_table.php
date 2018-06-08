<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tool_id');
            $table->integer('organization_id');
            $table->string('subscription_id');
            $table->dateTime('expiry_date'); //check
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
        Schema::dropIfExists('tool_subscriptions');
    }
}
