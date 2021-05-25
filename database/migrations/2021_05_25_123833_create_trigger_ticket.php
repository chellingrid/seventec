<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggerTicket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TRIGGER tr_tickets_update BEFORE UPDATE ON tickets FOR EACH ROW
                        BEGIN
                        IF NEW.quantity <> OLD.quantity THEN
                       SET NEW.available = (NEW.quantity - OLD.quantity)+OLD.available;
                        END IF;
                        END;
        ");
        DB::unprepared("CREATE TRIGGER tr_tickets_insert BEFORE INSERT ON tickets FOR EACH ROW
                        BEGIN
                       SET NEW.available = NEW.quantity;
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
        DB::unprepared("DROP TRIGGER tr_tickets_insert");
        DB::unprepared("DROP TRIGGER tr_tickets_update");
    }
}
