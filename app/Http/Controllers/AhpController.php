<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Kriteria;
use App\Lahan;
use App\Matrik;
use App\KriteriaLahan;
use App\IndexRandomKonsistensi;

class AhpController extends Controller {

	public function insert_matriks(Request $request){
		$lahan_id_pembanding = $request->get('lahan_id_pembanding');
		$lahan_id_acuan = $request->get('lahan_id_acuan');
		$nilai = $request->get('nilai');
		$kriterias_id = $request->get('kriterias_id');

		$matrik = Matrik::where('lahan_id_acuan',$lahan_id_acuan )
		->where('lahan_id_pembanding', $lahan_id_pembanding)
		->where('kriterias_id', $kriterias_id)->first();
		$matrik->nilai = $nilai;
		$matrik->save();

		$reverse_nilai = 1 / $nilai;
		$reverse_matrik = Matrik::where('lahan_id_acuan',$lahan_id_pembanding)
		->where('lahan_id_pembanding', $lahan_id_acuan )
		->where('kriterias_id', $kriterias_id)->first();
		$reverse_matrik->nilai = $reverse_nilai;
		$reverse_matrik->save();

		echo 'success';
	}

	public function insert_kriteria(Request $request){

		$nama_kriteria = $request->get('nama_kriteria');
		$kriteria = new Kriteria();
		$kriteria->nama_kriteria = $nama_kriteria;
		$kriteria->save();

		$list_lahan = Lahan::all();
		$size = sizeof($list_lahan) ;

		for ($i=0; $i < $size; $i++) { 
			$lahan_acuan = $list_lahan[$i];
			$kl = new KriteriaLahan();
			$kl->kriterias_id = $kriteria->id;
			$kl->lahans_id = $lahan_acuan->id;
			$kl->total_pembanding = 0.0;
			$kl->total_acuan = 0.0;
			$kl->row_average = 0.0;
			$kl->total_weighted_sum_vector = 0.0;
			$kl->consistency_vector = 0.0;
			$kl->save();
			for($j = 0 ; $j < $size ; $j++ ){
				$lahan_pembanding = $list_lahan[$j];
				$matrik = new Matrik();
				$matrik->lahan_id_acuan = $lahan_acuan->id;
				$matrik->lahan_id_pembanding = $lahan_pembanding->id;
				$matrik->kriterias_id = $kriteria->id;
				$matrik->nilai = 0;	
				if($lahan_acuan->id === $lahan_pembanding->id){
					$matrik->nilai = 1;	
				}
				
				$matrik->save();
			}
		}
		return "success";

	}

	public function doAhp(Request $request){
		$ukuran_matriks = $request->get('ukuran_matriks');
		$list_kriteria = Kriteria::all();
		$list_lahan = Lahan::all();
		$index_random_consistency = IndexRandomKonsistensi::where('ukuran_matriks', $ukuran_matriks)->first();
		foreach ($list_kriteria as $kriteria) {
			foreach ($list_lahan as $lahan) {
				// step 1 
				$total_pembanding = Matrik::where('kriterias_id', $kriteria->id)
										->where('lahan_id_pembanding', $lahan->id)
										->sum('nilai');
				
				$kriteria_lahan = KriteriaLahan::where('kriterias_id', $kriteria->id)
												->where('lahans_id', $lahan->id)
												->first();
				$kriteria_lahan->total_pembanding = $total_pembanding;
				$kriteria_lahan->save();
			}
			foreach ($list_lahan as $lahan) {
				// step 2
				$list_matrik = Matrik::where('kriterias_id', $kriteria->id)
										->where('lahan_id_pembanding', $lahan->id)
										->get();
				$kriteria_lahan = KriteriaLahan::where('kriterias_id', $kriteria->id)
												->where('lahans_id', $lahan->id)
												->first();						
				foreach ($list_matrik as $matrik) {
					$matrik->nilai_dibagi_total_pembanding = $matrik->nilai / $kriteria_lahan->total_pembanding;
					$matrik->save();
				}
			}

			foreach ($list_lahan as $lahan) {
				$kriteria_lahan = KriteriaLahan::where('kriterias_id', $kriteria->id)
												->where('lahans_id', $lahan->id)
												->first();
				$kriteria_lahan->total_acuan = Matrik::where('kriterias_id', $kriteria->id)
														->where('lahan_id_acuan', $lahan->id)
														->sum('nilai_dibagi_total_pembanding');
				
				$kriteria_lahan->row_average = $kriteria_lahan->total_acuan / sizeof($list_lahan);
				
				$kriteria_lahan->save();
			}

			foreach ($list_lahan as $lahan) {
				$list_matrik = Matrik::where('kriterias_id', $kriteria->id)
										->where('lahan_id_pembanding', $lahan->id)
										->get();
				$kriteria_lahan = KriteriaLahan::where('kriterias_id', $kriteria->id)
												->where('lahans_id', $lahan->id)
												->first();
				foreach ($list_matrik as $matrik) {
					$matrik->weighted_sum_vector = $matrik->nilai * $kriteria_lahan->row_average;
					$matrik->save();
				}
			}

			foreach ($list_lahan as $lahan) {
				$kriteria_lahan = KriteriaLahan::where('kriterias_id', $kriteria->id)
												->where('lahans_id', $lahan->id)
												->first();
				$kriteria_lahan->total_weighted_sum_vector = Matrik::where('kriterias_id', $kriteria->id)
																	->where('lahan_id_acuan', $lahan->id)
																	->sum('weighted_sum_vector');
				$kriteria_lahan->consistency_vector = $kriteria_lahan->total_weighted_sum_vector / $kriteria_lahan->row_average;
				
				$kriteria_lahan->save();
			}

			$kriteria->hasil_lambda = KriteriaLahan::where('kriterias_id', $kriteria->id)->sum('consistency_vector') / sizeof($list_lahan);
			$kriteria->consistency_index = ($kriteria->hasil_lambda - sizeof($list_lahan)) / ( sizeof($list_lahan) - 1) ;
			$kriteria->consistency_ratio = $kriteria->consistency_index / $index_random_consistency->nilai_index_random;
			$kriteria->save();
		}
		return "success";
	}

	public function reset_matriks(Request $request){
		$list_matriks = Matrik::all();
		foreach ($list_matriks as $matrik) {
			$matrik->nilai = 0;
			$matrik->save();
		}
		return "ok";
	}

}
