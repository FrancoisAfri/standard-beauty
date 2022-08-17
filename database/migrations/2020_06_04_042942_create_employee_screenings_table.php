<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_screenings', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('question_1')->nullable();
			$table->integer('question_2')->nullable();
			$table->integer('question_3')->nullable();
			$table->integer('question_4')->nullable();
			$table->integer('question_5')->nullable();
			$table->integer('question_6')->nullable();
			$table->integer('question_7')->nullable();
			$table->integer('question_8')->nullable();
			$table->integer('employee_id')->nullable();
			$table->integer('company_id')->nullable();
			$table->integer('site_id')->nullable();
			$table->integer('covid_admin')->nullable();
			$table->string('comment')->nullable();
			$table->string('employee_number')->nullable();
			$table->double('temperature')->nullable();
			$table->bigInteger('date_captured')->nullable();
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
        Schema::dropIfExists('employee_screenings');
    }
}
