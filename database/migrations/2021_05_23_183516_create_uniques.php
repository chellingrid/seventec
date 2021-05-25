<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniques extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->unique('name', 'events_name_unique');
        });
        Schema::table('places', function ($table) {
            $table->unique('name', 'places_name_unique');
        });
        Schema::table('activity_types', function ($table) {
            $table->unique('name', 'activity_types_name_unique');
        });
        Schema::table('activity_modes', function ($table) {
            $table->unique('name', 'activity_modes_name_unique');
        });
        Schema::table('certificate_templates', function ($table) {
            $table->unique('name', 'certificate_templates_name_unique');
        });
        Schema::table('departments', function ($table) {
            $table->unique('name', 'departments_name_unique');
        });
        Schema::table('genders', function ($table) {
            $table->unique('name', 'genders_name_unique');
        });
        Schema::table('extra_info', function ($table) {
            $table->unique('name', 'extra_info_name_unique');
        });
        Schema::table('ticket_genres', function ($table) {
            $table->unique('name', 'ticket_genres_name_unique');
        });
        Schema::table('audience', function ($table) {
            $table->unique('name', 'audience_name_unique');
        });
        Schema::table('instituitions', function ($table) {
            $table->unique('name', 'instituitions_name_unique');
        });
        Schema::table('courses', function ($table) {
            $table->unique('name', 'courses_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function ($table) {
            $table->dropUnique('events_name_unique');
        });
        Schema::table('places', function ($table) {
            $table->dropUnique('places_name_unique');
        });
        Schema::table('activity_types', function ($table) {
            $table->dropUnique('activity_types_name_unique');
        });
        Schema::table('activity_modes', function ($table) {
            $table->dropUnique('activity_modes_name_unique');
        });
        Schema::table('certificate_templates', function ($table) {
            $table->dropUnique('certificate_templates_name_unique');
        });
        Schema::table('departments', function ($table) {
            $table->dropUnique('departments_name_unique');
        });
        Schema::table('genders', function ($table) {
            $table->dropUnique('genders_name_unique');
        });
        Schema::table('extra_info', function ($table) {
            $table->dropUnique('extra_info_name_unique');
        });
        Schema::table('ticket_genres', function ($table) {
            $table->dropUnique('ticket_genres_name_unique');
        });
        Schema::table('audience', function ($table) {
            $table->dropUnique('audience_name_unique');
        });
        Schema::table('instituitions', function ($table) {
            $table->dropUnique('instituitions_name_unique');
        });
        Schema::table('courses', function ($table) {
            $table->dropUnique('courses_name_unique');
        });
    }
}
