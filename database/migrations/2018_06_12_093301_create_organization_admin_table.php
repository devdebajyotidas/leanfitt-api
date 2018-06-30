<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_admin', function (Blueprint $table) {
            $table->increments('id')->unsigned()->index();
            $table->integer('organization_id')->unsigned();
            $table->integer('admin_id')->unsigned();

            $table->foreign('organization_id')
                ->references('id')->on('organizations')
                ->onDelete('cascade');

            $table->foreign('admin_id')
                ->references('id')->on('admins')
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
        Schema::dropIfExists('organization_admin');
    }
}
