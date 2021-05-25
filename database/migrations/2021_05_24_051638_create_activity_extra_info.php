<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityExtraInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_extra_info', function (Blueprint $table) {
            $table->unsignedBigInteger('activities_id');
            $table->unsignedBigInteger('extra_info_id');
            $table->foreign('activities_id')->references('id')->on('activities');
            $table->foreign('extra_info_id')->references('id')->on('extra_info');
            $table->primary(['activities_id', 'extra_info_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_extra_info');
    }
}
