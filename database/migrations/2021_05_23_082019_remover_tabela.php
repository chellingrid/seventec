<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoverTabela extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropForeign('places_postal_code_foreign');
        });
        Schema::dropIfExists('postal_codes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('postal_codes', function (Blueprint $table) {
            $table->string('postal_code', 8)->primary();
            $table->timestamps();
            $table->string('adress', 255);
            $table->string('district', 255);
            $table->string('city', 255);
            $table->string('state', 2);
        });
        Schema::table('places', function (Blueprint $table) {
            $table->unsignedBigInteger('instituition_id');
            $table->foreign('postal_code')
                ->references('postal_code')
                ->on('postal_codes');
        });
    }
}
