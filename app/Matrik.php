<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrik extends Model {

	//
	protected $table = "matriks";

	public function lahan_pembanding(){
		return $this->hasOne('Lahan', 'lahan_id_pembanding');
	}

	public function lahan_acuan(){
		return $this->hasOne('Lahan', 'lahan_id_acuan');
	}

}
