<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class DemografiHistory extends Model
{
    protected $table = 'pkbl_lapkinerja_transaksi_demografimb_history';
    const UPDATED_AT = 'update_date';

    public function scopeData($query, $param){
    	return $query->select(
    							'pkbl_lapkinerja_transaksi_demografimb.id_kinerja_transaksi_demografimb',
    							'pkbl_lapkinerja_transaksi_demografimb.kode_provinsi',
    							'pkbl_lapkinerja_transaksi_demografimb.kode_kabkota',
    							'pkbl_lapkinerja_transaksi_demografimb.nama',
    							'pkbl_lapkinerja_transaksi_demografimb.nik',
    							'pkbl_lapkinerja_transaksi_demografimb.alamat',
    							'pkbl_lapkinerja_transaksi_demografimb.jenis_kelamin',
    							'pkbl_lapkinerja_transaksi_demografimb.tgl_lahir',
    							'pkbl_lapkinerja_transaksi_demografimb.jenis_produk',
    							'pkbl_lapkinerja_transaksi_demografimb.jumlah_pinjaman_rp',
    							'pkbl_lapkinerja_transaksi_demografimb_history.posisi_pinjaman_rp',
    							'pkbl_lapkinerja_transaksi_demografimb.tanggal_perjanjian',
    							'pkbl_lapkinerja_transaksi_demografimb.jumlah_tk',
    							'pkbl_lapkinerja_transaksi_demografimb_history.kode_status',
    							'pkbl_lapkinerja_transaksi_demografimb_history.posisi_aset_rp',
    							'pkbl_lapkinerja_transaksi_demografimb_history.omset_rp',
    							'pkbl_lapkinerja_transaksi_demografimb.pinjaman_ke',
    							'pkbl_lapkinerja_transaksi_demografimb.pinjaman_khusus',
    							'pkbl_lapkinerja_transaksi_demografimb.kode_jenisusaha',
    							'pkbl_lapkinerja_transaksi_demografimb.kode_sektorusaha',
    							'pkbl_lapkinerja_transaksi_demografimb_history.unggulan',
    							'pkbl_lapkinerja_transaksi_demografimb.kode_kategoriusaha'
    						)
    				->join('pkbl_lapkinerja_transaksi_demografimb', 'pkbl_lapkinerja_transaksi_demografimb.id_kinerja_transaksi_demografimb', 'pkbl_lapkinerja_transaksi_demografimb_history.id_kinerja_transaksi_demografimb')
    				->join(DB::raw("(SELECT id_kinerja_transaksi_demografimb, MAX ( concat ( tahun_laporan, id_periode )) AS tahunperiode  FROM pkbl_lapkinerja_transaksi_demografimb_history WHERE UPPER(id_bumn_pembina) = UPPER('".$param['bumn']."') AND concat ( tahun_laporan, id_periode ) <= '".$param['tahun'].$param['periode']."'  GROUP BY id_kinerja_transaksi_demografimb ) as tdh"), function ($join) {
    					$join->on('pkbl_lapkinerja_transaksi_demografimb_history.id_kinerja_transaksi_demografimb', 'tdh.id_kinerja_transaksi_demografimb')
    						->on(DB::raw('concat(pkbl_lapkinerja_transaksi_demografimb_history.tahun_laporan, pkbl_lapkinerja_transaksi_demografimb_history.id_periode)'), 'tdh.tahunperiode');
    				})
    				->whereRaw("(pkbl_lapkinerja_transaksi_demografimb_history.kode_status <> 6 OR (CAST(Concat(pkbl_lapkinerja_transaksi_demografimb_history.tahun_laporan,pkbl_lapkinerja_transaksi_demografimb.id_periode) as INT) = CAST('".$param['tahun'].$param['periode']."' as INT) AND pkbl_lapkinerja_transaksi_demografimb_history.kode_status = 6))")
    				->orderByRaw("id_kinerja_transaksi_demografimb ASC, kode_provinsi ASC, kode_kabkota ASC, pkbl_lapkinerja_transaksi_demografimb.id_kinerja_transaksi_demografimb, pkbl_lapkinerja_transaksi_demografimb_history.tahun_laporan, pkbl_lapkinerja_transaksi_demografimb_history.id_periode");
    }

    public function scopeGetDetail($query, $param){
    	return $query->where('id_kinerja_transaksi_demografimb', $param['id'])
    				->where('tahun_laporan', $param['tahun'])
    				->where('id_periode', $param['periode']);
    }
}
