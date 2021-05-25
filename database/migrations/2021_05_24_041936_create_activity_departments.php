<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('activities_id');
            $table->unsignedBigInteger('departments_id');
            $table->foreign('activities_id')->references('id')->on('activities');
            $table->foreign('departments_id')->references('id')->on('departments');
            $table->primary(['activities_id', 'departments_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_departments');
    }
}
