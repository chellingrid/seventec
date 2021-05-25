<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('audience_id');
            $table->unsignedBigInteger('ticket_genre_id');
            $table->integer('quantity');
            $table->integer('available')->default(0);
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('audience_id')->references('id')->on('audience');
            $table->foreign('ticket_genre_id')->references('id')->on('ticket_genres');
            $table->unique(['activity_id', 'audience_id', 'ticket_genre_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
