<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Lahan;
use App\Kriteria;
use App\Matrik;
use App\IndexRandomKonsistensi;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');
		Lahan::create(array('nama_lahan'=>'lahan 1'));
		Lahan::create(array('nama_lahan'=>'lahan 2'));
		Lahan::create(array('nama_lahan'=>'lahan 3'));

		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 1.2, 'nilai_index_random'=>0.00));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 3.0, 'nilai_index_random'=>0.58));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 4.0, 'nilai_index_random'=>0.90));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 5.0, 'nilai_index_random'=>1.12));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 6.0, 'nilai_index_random'=>1.24));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 7.0, 'nilai_index_random'=>1.32));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 8.0, 'nilai_index_random'=>1.42));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 9.0, 'nilai_index_random'=>1.45));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 10.0, 'nilai_index_random'=>1.49));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 11.0, 'nilai_index_random'=>1.51));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 12.0, 'nilai_index_random'=>1.48));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 13.0, 'nilai_index_random'=>1.56));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 14.0, 'nilai_index_random'=>1.57));
		IndexRandomKonsistensi::create(array('ukuran_matriks'=> 15.0, 'nilai_index_random'=>1.59));

	}

}
