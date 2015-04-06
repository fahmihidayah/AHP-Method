<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexRandomKonsistensisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('index_random_konsistensis', function(Blueprint $table)
		{
			$table->increments('id');
			$table->double('ukuran_matriks');
			$table->double('nilai_index_random');
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
		Schema::drop('index_random_konsistensis');
	}

}
