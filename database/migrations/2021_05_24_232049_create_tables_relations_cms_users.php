<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesRelationsCmsUsers extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_managers', function (Blueprint $table) {
            $table->integer('cms_users_id')->unsigned();
            $table->unsignedBigInteger('events_id');
            $table->foreign('cms_users_id')
                ->references('id')
                ->on('cms_users');
            $table->foreign('events_id')
                ->references('id')
                ->on('events');
            $table->primary([
                'cms_users_id',
                'events_id'
            ]);
        });
        Schema::create('activity_managers', function (Blueprint $table) {
            $table->integer('cms_users_id')->unsigned();
            $table->unsignedBigInteger('activities_id');
            $table->foreign('cms_users_id')
                ->references('id')
                ->on('cms_users');
            $table->foreign('activities_id')
                ->references('id')
                ->on('activities');
            $table->primary([
                'cms_users_id',
                'activities_id'
            ]);
        });
        Schema::create('activity_monitors', function (Blueprint $table) {
            $table->integer('cms_users_id')->unsigned();
            $table->unsignedBigInteger('activities_id');
            $table->foreign('cms_users_id')
                ->references('id')
                ->on('cms_users');
            $table->foreign('activities_id')
                ->references('id')
                ->on('activities');
            $table->primary([
                'cms_users_id',
                'activities_id'
            ]);
        });
        Schema::create('people_departments', function (Blueprint $table) {
            $table->integer('cms_users_id')->unsigned();
            $table->unsignedBigInteger('departments_id');
            $table->foreign('cms_users_id')
                ->references('id')
                ->on('cms_users');
            $table->foreign('departments_id')
                ->references('id')
                ->on('departments');
            $table->primary([
                'cms_users_id',
                'departments_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_managers');
        Schema::dropIfExists('activity_managers');
        Schema::dropIfExists('activity_monitors');
        Schema::dropIfExists('people_departments');
    }
}
