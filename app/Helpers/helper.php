<?php 

namespace App\Helpers;

use DB;

class Helper
{
	public static function get_referensi_provinsi(){
		return DB::table('pkbl_provinsi');
	}

	public static function get_detail_provinsi($kode){
		return DB::table('pkbl_provinsi')->where('kode', $kode);
	}

	public static function get_referensi_kabkota(){
		return DB::table('pkbl_kabkota');
	}

	public static function get_referensi_status(){
		return DB::table('pkbl_lapkinerja_transaksi_demografimb_ref_status');
	}

	public static function get_referensi_jenisusaha(){
		return DB::table('pkbl_lapkinerja_transaksi_demografimb_ref_jenisusaha');
	}

	public static function get_referensi_sektorusaha (){
		return DB::table('pkbl_ref_sektorusaha');
	}

	public static function get_referensi_kategoriusaha(){
		return DB::table('pkbl_ref_kategoriusaha');
	}

	public static function get_nik_from_bumn($bumn){
		return DB::table('pkbl_lapkinerja_transaksi_demografimb_history')
				->where('kode_status', '<>', 6)
				->where('id_bumn_pembina', $bumn)
				->select('nik')
				->groupBy('nik');
	}

	public static function get_nik_other_bumn($bumn){
		return DB::table('pkbl_lapkinerja_transaksi_demografimb_history')
				->where('kode_status', '<>', 6)
				->where('id_bumn_pembina', '<>', $bumn)
				->select('nik')
				->groupBy('nik');
	}

	public static function get_detail_periode($id){
		return DB::table('pkbl_periode_ref')
				->where('id', $id);
	}
}