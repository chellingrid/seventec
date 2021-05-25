<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('event_id');
            $table->string('name', 255);
            $table->string('description', 500)->nullable();
            $table->string('image_path', 200)->nullable();
            $table->unsignedBigInteger('activity_type_id');
            $table->unsignedBigInteger('activity_mode_id');
            $table->unsignedBigInteger('certificate_template_id')->nullable();
            $table->boolean('datashow');
            $table->boolean('laboratory');
            $table->string('obs', 200)->nullable();
            $table->integer('cms_user_id')->unsigned();
            $table->boolean('show');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('activity_type_id')->references('id')->on('activity_types');
            $table->foreign('activity_mode_id')->references('id')->on('activity_modes');
            $table->foreign('certificate_template_id')->references('id')->on('certificate_template');
            $table->foreign('cms_user_id')->references('id')->on('cms_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
