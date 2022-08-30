<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToHrPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_people', function ($table) {
            //
            $table->integer('transportation_method')->unsigned()->index()->nullable();
            $table->string('chronic_diseases')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_people', function ($table) {
            //
            $table->dropColumn('transportation_method');
            $table->dropColumn('chronic_diseases');
        });
    }
}
