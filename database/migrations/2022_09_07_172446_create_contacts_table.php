<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->string('firstname');
			$table->string('surname');
			$table->string('email');
			$table->integer('status')->nullable();
			$table->string('cell_number')->nullable();
			$table->string('picture')->nullable();
			$table->string('address', 500)->nullable();
            $table->integer('on_medication')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
