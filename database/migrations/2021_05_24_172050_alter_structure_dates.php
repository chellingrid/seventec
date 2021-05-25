<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStructureDates extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP TRIGGER tr_dates_online");
        Schema::dropIfExists('dates_online');
        Schema::dropIfExists('dates_rooms');
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign('activities_activity_mode_id_foreign');
            $table->dropColumn('activity_mode_id');
        });
        Schema::dropIfExists('activity_modes');
        Schema::table('dates', function (Blueprint $table) {
            //
            $table->boolean('online');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('link', '100')->nullable();
            $table->string('attendance_code', '6')->nullable();
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms');
        });
        DB::unprepared("CREATE TRIGGER tr_dates BEFORE INSERT ON dates FOR EACH ROW
                        BEGIN
                        IF NEW.online = 1 THEN
                       SET NEW.attendance_code = LEFT(CONCAT(NEW.id,MD5(RAND())), 6);
                        END IF;
                        END;
                    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dates', function (Blueprint $table) {
            //
        });
    }
}
