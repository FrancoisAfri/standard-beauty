<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddManagerIdToHrPeopleTable extends Migration
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
            $table->integer('manager_id')->unsigned()->index()->nullable();
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
            $table->dropColumn('manager_id');
        });
    }
}
