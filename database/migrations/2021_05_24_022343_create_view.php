<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateView extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*DB::statement("CREATE VIEW buildings_places AS SELECT buildings.id, CONCAT(places.name,' - ',buildings.name) as name
         FROM buildings
         JOIN places on places.id = buildings.place_id
         WHERE places.show = 1 AND buildings.show = 1
         ORDER BY places.id ASC, buildings.name ASC;");
        
         * Schema::table('rooms', function (Blueprint $table) {
         * $table->dropForeign('rooms_building_id_foreign');
         * $table->foreign('building_id')
         * ->references('id')
         * ->on('buildings_places');
         * });
         */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
         * DB::statement("DROP VIEW buildings_places");
         * Schema::table('rooms', function (Blueprint $table) {
         * $table->dropForeign('rooms_building_id_foreign');
         * $table->foreign('building_id')
         * ->references('id')
         * ->on('buildings');
         * });
         */
    }
}
