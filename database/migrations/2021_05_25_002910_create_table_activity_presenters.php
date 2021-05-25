<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableActivityPresenters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presenters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title',20)->nullable();
            $table->string('name',100);
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('link')->nullable();
            $table->string('photo')->nullable();
            $table->string('bio', 300)->nullable();
            $table->boolean('show');
        });
        
            Schema::create('activity_presenters', function (Blueprint $table) {
                $table->unsignedBigInteger('activities_id');
                $table->unsignedBigInteger('presenters_id');
                $table->foreign('activities_id')->references('id')->on('activities');
                $table->foreign('presenters_id')->references('id')->on('presenters');
                $table->primary([
                    'presenters_id',
                    'activities_id'
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
        Schema::dropIfExists('presenters');
        Schema::dropIfExists('activity_presenters');
    }
}
