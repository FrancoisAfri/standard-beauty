<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutineLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routines_link', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('status')->nullable();
			$table->integer('routine_id');
			$table->string('picture');
			$table->string('hyper_link', 1200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('routines_link');
    }
}
