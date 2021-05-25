<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggerDatesOnline extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_dates_online BEFORE INSERT ON dates_online FOR EACH ROW 
                       SET NEW.attendance_code = LEFT(CONCAT(NEW.id,MD5(RAND())), 6);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER tr_dates_online");
    }
}
