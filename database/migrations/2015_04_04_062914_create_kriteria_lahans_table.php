<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKriteriaLahansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kriteria_lahans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lahans_id');
			$table->integer('kriterias_id');
			$table->double('total_pembanding');
			$table->double('total_acuan');
			$table->double('row_average');
			$table->double('total_weighted_sum_vector');
			$table->double('consistency_vector');
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
		Schema::drop('kriteria_lahans');
	}

}
