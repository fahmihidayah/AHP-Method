<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKriteriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kriterias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nama_kriteria');
			$table->double('hasil_lambda');
			$table->double('consistency_index');
			$table->double('consistency_ratio');
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
		Schema::drop('kriterias');
	}

}
