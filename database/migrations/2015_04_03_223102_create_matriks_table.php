<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matriks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lahan_id_acuan'); // kolom sebelah kiri kebawah
			$table->integer('lahan_id_pembanding'); // kolom sebelah atas ke kanan
			$table->integer('kriterias_id');
			$table->double('nilai');
			$table->double('nilai_dibagi_total_pembanding');
			$table->double('weighted_sum_vector');
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
		Schema::drop('matriks');
	}

}
