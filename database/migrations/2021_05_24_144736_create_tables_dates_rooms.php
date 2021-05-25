<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesDatesRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates_rooms', function (Blueprint $table) {
            $table->unsignedBigInteger('dates_id');
            $table->unsignedBigInteger('rooms_id');
            $table->foreign('dates_id')->references('id')->on('dates');
            $table->foreign('rooms_id')->references('id')->on('rooms');
            $table->primary(['dates_id', 'rooms_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dates_rooms');
    }
}
