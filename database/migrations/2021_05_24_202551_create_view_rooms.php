<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW view_rooms AS SELECT rooms.id, places.name as place, buildings.name as building, rooms.name as room, rooms.show
         FROM rooms
         JOIN buildings ON buildings.id = rooms.building_id
         JOIN places on places.id = buildings.place_id
         ORDER BY places.id ASC, buildings.name ASC;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW view_rooms");
    }
}
