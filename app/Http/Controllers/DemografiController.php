<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Demografi;
use App\DemografiHistory;
use App\MonitoringLaporan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Crypt;
use DB;


class DemografiController extends Controller
{

	public function __construct()
	{
		$this->history = new DemografiHistory(); 
		$this->demografi = new Demografi(); 
		$this->monitoring = new MonitoringLaporan(); 
	}

	public function index(){
		return view('index');
	}
    
    public function download(Request $request, $bumn=null, $tahun=null, $periode=null)
    {
    	ini_set('memory_limit', '-1');
    	ini_set('max_execution_time', 6000);
    	$param = array(
    			'bumn' => $bumn,
    			'tahun' => $tahun,
    			'periode' => $periode
    		);
    	$data = $this->history->data($param)->get();

		$spreadsheet = new Spreadsheet();
		$style = new Style();
		$datatype = new DataType();
		$sheet = $spreadsheet->getActiveSheet();
		
		$garis = array(
			'borders' => array(
			  'allborders' => array(
				'style' => 'BORDER_THIN'
			  )
			)
		);

	 	$sheet->getColumnDimension('A')->setVisible(false);
	 	$sheet->setCellValue('A1', Crypt::encryptString($bumn.';'.$tahun.';'.$periode));

		$sheet->setCellValue('B2', 'PT Telkom Tbk');
		$sheet->setCellValue('B3', 'DATA DEMOGRAFI MITRA BINAAN');
		$sheet->setCellValue('B4', 'Data Demografi Mitra Binaan s/d Triwulan I Tahun 2019');
		
		$sheet->setCellValue('B6', 'Kode Provinsi');
		$sheet->setCellValue('C6', 'Kode Kab/Kota');
		$sheet->setCellValue('D6', 'Nama');
		$sheet->setCellValue('E6', 'No KTP');
		$sheet->setCellValue('F6', 'Alamat');
		$sheet->setCellValue('G6', 'Jenis Kelamin');
		$sheet->setCellValue('G7', '(Laki-laki = 1, Perempuan = 2)');
		$sheet->setCellValue('H6', 'Tanggal Lahir');
		$sheet->setCellValue('H7', 'YYYY-MM-DD');
		$sheet->setCellValue('I6', 'Jumlah Pinjaman');
		$sheet->setCellValue('I7', '(Pokok)(Rp.)');
		$sheet->setCellValue('J6', 'Posisi Pinjaman (Rp.)');
		$sheet->setCellValue('K6', 'Tanggal Perjanjian Pinjaman');
		$sheet->setCellValue('K7', 'YYYY-MM-DD');
		$sheet->setCellValue('L6', 'Jumlah Tenaga Kerja');
		$sheet->setCellValue('M6', 'Kode Status');
		$sheet->setCellValue('N6', 'Posisi Asset (Rp.)');
		$sheet->setCellValue('O6', 'Omset (Rp.)');
		$sheet->setCellValue('P6', 'Pinjaman Ke-');
		$sheet->setCellValue('Q6', 'Pinjaman Khusus');
		$sheet->setCellValue('Q7', '(1 = Bukan Topup, 2 = Topup)');
		$sheet->setCellValue('R6', 'Kode Jenis Usaha');
		$sheet->setCellValue('S6', 'Jenis Produk');
		$sheet->setCellValue('T6', 'Kode Sektor Usaha');
		$sheet->setCellValue('U6', 'Kode Kategori Usaha');
		$sheet->setCellValue('V6', 'Unggulan');
		$sheet->setCellValue('V7', '(1 = Unggulan, 2 = Bukan Unggulan)');

		$sheet->mergeCells('B2:S2');
 		$sheet->mergeCells('B3:S3');
 		$sheet->mergeCells('B4:S4');
 		$sheet->mergeCells('B6:B7');
 		$sheet->mergeCells('C6:C7');
 		$sheet->mergeCells('D6:D7');
 		$sheet->mergeCells('E6:E7');
 		$sheet->mergeCells('F6:F7');
 		$sheet->mergeCells('J6:J7');
 		$sheet->mergeCells('L6:L7');
 		$sheet->mergeCells('M6:M7');
 		$sheet->mergeCells('N6:N7');
 		$sheet->mergeCells('O6:O7');
 		$sheet->mergeCells('P6:P7');
 		$sheet->mergeCells('R6:R7');
 		$sheet->mergeCells('S6:S7');
 		$sheet->mergeCells('T6:T7');
 		$sheet->mergeCells('U6:U7');

		$i = 8;
		foreach ($data as $key => $value) {
			$sheet->setCellValue('A'.$i, $value['id_kinerja_transaksi_demografimb']);
			$sheet->setCellValue('B'.$i, $value['kode_provinsi']);
			$sheet->setCellValue('C'.$i, $value['kode_kabkota']);
			$sheet->setCellValue('D'.$i, $value['nama']);
			$sheet->setCellValueExplicit('E'.$i, $value['nik'], $datatype::TYPE_STRING);
			$sheet->setCellValue('F'.$i, $value['alamat']);
			$sheet->setCellValue('G'.$i, $value['jenis_kelamin']);
			$sheet->setCellValue('H'.$i, $value['tgl_lahir']);
			$sheet->setCellValue('I'.$i, $value['jumlah_pinjaman_rp']);
			$sheet->setCellValue('J'.$i, $value['posisi_pinjaman_rp']);
			$sheet->setCellValue('K'.$i, $value['tanggal_perjanjian']);
			$sheet->setCellValue('L'.$i, $value['jumlah_tk']);
			$sheet->setCellValue('M'.$i, $value['kode_status']);
			$sheet->setCellValue('N'.$i, $value['posisi_aset_rp']);
			$sheet->setCellValue('O'.$i, $value['omset_rp']);
			$sheet->setCellValue('P'.$i, $value['pinjaman_ke']);
			$sheet->setCellValue('Q'.$i, $value['pinjaman_khusus']);
			$sheet->setCellValue('R'.$i, $value['kode_jenisusaha']);
			$sheet->setCellValue('S'.$i, $value['jenis_produk']);
			$sheet->setCellValue('T'.$i, $value['kode_sektorusaha']);
			$sheet->setCellValue('U'.$i, $value['kode_kategoriusaha']);
			$sheet->setCellValue('V'.$i, $value['unggulan']);
			$i++;
		}
		$sheet->getColumnDimension('B')->setWidth(8);
	 	$sheet->getColumnDimension('C')->setWidth(10);
	 	$sheet->getColumnDimension('D')->setWidth(30);
	 	$sheet->getColumnDimension('E')->setWidth(18);
	 	$sheet->getColumnDimension('F')->setWidth(30);
	 	$sheet->getColumnDimension('G')->setWidth(15);
	 	$sheet->getColumnDimension('H')->setWidth(15);
	 	$sheet->getColumnDimension('I')->setWidth(20);
	 	$sheet->getColumnDimension('J')->setWidth(20);
	 	$sheet->getColumnDimension('K')->setWidth(17);
	 	$sheet->getColumnDimension('L')->setWidth(15);
	 	$sheet->getColumnDimension('M')->setWidth(15);
	 	$sheet->getColumnDimension('N')->setWidth(20);
	 	$sheet->getColumnDimension('O')->setWidth(20);
	 	$sheet->getColumnDimension('P')->setWidth(15);
	 	$sheet->getColumnDimension('Q')->setWidth(15);
	 	$sheet->getColumnDimension('R')->setWidth(15);
	 	$sheet->getColumnDimension('S')->setWidth(30);
	 	$sheet->getColumnDimension('T')->setWidth(12);
	 	$sheet->getColumnDimension('U')->setWidth(12);
	 	$sheet->getColumnDimension('V')->setWidth(20);

	 	$sheet->getStyle('B2:V7')->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('B2:V'.$i)->getAlignment()->setWrapText(true);
	 	$sheet->getStyle('B6:F7')->getAlignment()->setVertical('center');
	 	$sheet->getStyle('J6:J7')->getAlignment()->setVertical('center');
	 	$sheet->getStyle('L6:P7')->getAlignment()->setVertical('center');
	 	$sheet->getStyle('R6:U7')->getAlignment()->setVertical('center');
	 	$sheet->getStyle('G7:I7')->getAlignment()->setVertical('top');
	 	$sheet->getStyle('K7')->getAlignment()->setVertical('top');
	 	$sheet->getStyle('Q7')->getAlignment()->setVertical('top');
	 	$sheet->getStyle('V7')->getAlignment()->setVertical('top');
	 	$sheet->getStyle('B8:C'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('E8:E'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('G8:G'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('L8:M'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('P8:R'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('T8:V'.($i-1))->getAlignment()->setHorizontal('center');
	 	$sheet->getStyle('B6:J7')->getFill()->setFillType('solid')->getStartColor()->setRGB('00B3FF');
	 	$sheet->getStyle('L6:M7')->getFill()->setFillType('solid')->getStartColor()->setRGB('00B3FF');
	 	$sheet->getStyle('Q6:S7')->getFill()->setFillType('solid')->getStartColor()->setRGB('00B3FF');
	 	$sheet->getStyle('K6:K7')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFEF00');
	 	$sheet->getStyle('N6:P7')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFEF00');
	 	$sheet->getStyle('T6:V7')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFEF00');
	 	$sheet->getStyle('B6:F7')->getBorders()->getAllBorders()->setBorderStyle('thin');
	 	$sheet->getStyle('J6:J7')->getBorders()->getAllBorders()->setBorderStyle('thin');
	 	$sheet->getStyle('L6:P7')->getBorders()->getAllBorders()->setBorderStyle('thin');
	 	$sheet->getStyle('R6:U7')->getBorders()->getAllBorders()->setBorderStyle('thin');
	 	$sheet->getStyle('G6:G7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('H6:H7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('I6:I7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('K6:K7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('Q6:Q7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('V6:V7')->getBorders()->getOutline()->setBorderStyle('thin');
	 	$sheet->getStyle('B8:V'.($i-1))->getBorders()->getAllBorders()->setBorderStyle('thin');
	 	$sheet->getStyle('I8:J'.($i-1))->getNumberFormat()->setFormatCode("#,###");
	 	$sheet->getStyle('N8:O'.($i-1))->getNumberFormat()->setFormatCode("#,###");
	 	$sheet->getStyle('E')->getNumberFormat()->setFormatCode('@');
	 	$sheet->getStyle('E'.$i)->getNumberFormat()->setFormatCode('@');
	 	$sheet->getStyle('H')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
	 	$sheet->getStyle('H'.$i)->getNumberFormat()->setFormatCode('@');
	 	$sheet->getStyle('K')->getNumberFormat()->setFormatCode('yyyy-mm-dd');
	 	$sheet->getStyle('K'.$i)->getNumberFormat()->setFormatCode('@');

	 	$sheet->getStyle('B')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('C')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('D')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('E')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('F')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('G')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('H')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('I')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('J')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('K')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('L')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('M')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('N')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('O')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('P')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('Q')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('R')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('S')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('T')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('U')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('V')->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('B8:D'.($i-1))->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('F8:O'.($i-1))->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('Q8:V'.($i-1))->getProtection()->setLocked('unprotected');
	 	$sheet->getStyle('B'.$i.':V'.$i)->getProtection()->setLocked('unprotected');
	 	
	 	$sheet->freezePane('B8');

	 	$sheet->getProtection()->setSheet(true);
		$sheet->getProtection()->setSort(true);
		$sheet->getProtection()->setInsertRows(true);
		$sheet->getProtection()->setPassword('bumn234');

		$writer = new Xlsx($spreadsheet);
		ob_start();
		 
		$writer->save('php://output');

		$xlsData = ob_get_contents();
		ob_end_clean();

		return json_encode("data:application/vnd.ms-excel;base64,".base64_encode($xlsData));
    }

    public function import(Request $request){
    	ini_set('memory_limit', -1);
    	if ($request->hasFile('importexcel')) {
    		if($request->file('importexcel')->getClientOriginalExtension() == 'xls'){
	    		$sheet = IOFactory::load($request->file('importexcel')->path());
	            $data = $sheet->setActiveSheetIndex(0);
	            $highest_columm = $data->getHighestColumn();
	            $highest_row = $data->getHighestRow();

	            $decryptString = explode(';', Crypt::decryptString($data->getCell('A1')->getValue()));
	            $param = array(
	    			'bumn' => $decryptString[0],
	    			'tahun' => $decryptString[1],
	    			'periode' => $decryptString[2]
	    		);
	    		if (($param['bumn'] == $request->id_bumn_pembina_enc) && ($param['tahun'] == $request->tahun_laporan_enc) && ($param['periode'] == $request->id_periode_enc)){
			    	$olddata = $this->history->data($param)->count();

		            $ref_provinsi = Helper::get_referensi_provinsi()->pluck('kode')->all();
		            $ref_kabkota = Helper::get_referensi_kabkota()->pluck('kode')->all();
		            $ref_status = Helper::get_referensi_status()->pluck('id_status')->all();
		            $ref_jenisusaha = Helper::get_referensi_jenisusaha()->pluck('id_jenisusaha')->all();
		            $ref_sektorusaha = Helper::get_referensi_sektorusaha()->pluck('id_ref_sektorusaha')->all();
		            $ref_kategoriusaha = Helper::get_referensi_kategoriusaha()->pluck('kode_kategoriusaha')->all();
		            $nik_bumn = Helper::get_nik_from_bumn('AABR')->pluck('nik')->all();
		            $nik_other = Helper::get_nik_other_bumn('AABR')->pluck('nik')->all();

		            $datas = [];
		            $errors = [];
		            $x = 0; $y = 0;
		        	for ($j=8; $j <= $highest_row ; $j++) {  
		        		//cek referensi 
		            	if(in_array($data->getCell('B'.$j)->getValue(), $ref_provinsi) && 
		            		in_array($data->getCell('C'.$j)->getValue(), $ref_kabkota) && 
		            		in_array($data->getCell('M'.$j)->getValue(), $ref_status) && 
		            		in_array($data->getCell('R'.$j)->getValue(), $ref_jenisusaha) && 
		            		in_array($data->getCell('T'.$j)->getValue(), $ref_sektorusaha) && 
		            		in_array($data->getCell('U'.$j)->getValue(), $ref_kategoriusaha) && 
		            		$data->getCell('A'.$j)->getValue() <> '')
		            	{
				            for ($i='A'; $i <= $highest_columm; $i++) { 
			            		$datas[$x][] = $data->getCell($i.$j)->getValue();
			            	}
		            		$datas[$x][] = '';
			            	$x++;
			            }else if (
			            	$data->getCell('A'.$j)->getValue() == '' && 
			            	((in_array($data->getCell('E'.$j)->getValue(), $nik_bumn) && $data->getCell('Q'.$j)->getValue() == '2') || (!in_array($data->getCell('E'.$j)->getValue(), $nik_bumn) && $data->getCell('Q'.$j)->getValue() <> '2')) &&
			            	!in_array($data->getCell('E'.$j)->getValue(), $nik_other) && 
			            	in_array($data->getCell('B'.$j)->getValue(), $ref_provinsi) && 
			            	in_array($data->getCell('C'.$j)->getValue(), $ref_kabkota) && 
			            	in_array($data->getCell('M'.$j)->getValue(), $ref_status) && 
			            	in_array($data->getCell('R'.$j)->getValue(), $ref_jenisusaha) && 
			            	in_array($data->getCell('T'.$j)->getValue(), $ref_sektorusaha) && 
			            	in_array($data->getCell('U'.$j)->getValue(), $ref_kategoriusaha))
			            {
			            	for ($i='A'; $i <= $highest_columm; $i++) { 
			            		$datas[$x][] = '<td>'.$data->getCell($i.$j)->getValue().'<td>';
			            	}
		            		$datas[$x][] = '';
			            	$x++;
		            	}else{
		            		if($data->getCell('B'.$j)->getValue() <> ''){
			            		for ($i='A'; $i <= $highest_columm; $i++) { 
				            		$errors[$y][] = '<td>'.$data->getCell($i.$j)->getValue().'</td>';
				            	}
				            	$ket = [];
			            		if(!in_array($data->getCell('B'.$j)->getValue(), $ref_provinsi)){
			            			$errors[$y][1] = '<td><span class="label label-warning">'.$data->getCell('B'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Provinsi tidak terdaftar.</span>';
			            		}
			            		if(!in_array($data->getCell('C'.$j)->getValue(), $ref_kabkota)){
			            			$errors[$y][2] = '<td><span class="label label-warning">'.$data->getCell('C'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Kabupaten/Kota tidak terdaftar.</span>';
			            		}
			            		if(!in_array($data->getCell('G'.$j)->getValue(), [1, 2])){
			            			$errors[$y][6] = '<td><span class="label label-warning">'.$data->getCell('G'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Jenis Kelamin hanya bisa diisi (1 = Laki Laki) atau (2 = Perempuan).</span>';
			            		}
			            		if(!in_array($data->getCell('M'.$j)->getValue(), $ref_status)){
			            			$errors[$y][12] = '<td><span class="label label-warning">'.$data->getCell('M'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Status tidak terdaftar.</span>';
			            		}
			            		if(!in_array($data->getCell('R'.$j)->getValue(), $ref_jenisusaha)){
					            	$errors[$y][17] = '<td><span class="label label-warning">'.$data->getCell('R'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Jenis Usaha tidak terdaftar.</span>';
			            		}
			            		if(!in_array($data->getCell('T'.$j)->getValue(), $ref_sektorusaha)){
					            	$errors[$y][19] = '<td><span class="label label-warning">'.$data->getCell('T'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Sektor Usaha tidak terdaftar.</span>';
			            		}
			            		if(!in_array($data->getCell('U'.$j)->getValue(), $ref_kategoriusaha)){
					            	$errors[$y][20] = '<td><span class="label label-warning">'.$data->getCell('U'.$j)->getValue().'</span></td>';
					            	$ket[] = '<span class="label label-warning">Kode Kategori Usaha tidak terdaftar.</span>';
			            		}

			            		if($data->getCell('A'.$j)->getValue() == ""){
			            			if(in_array($data->getCell('E'.$j)->getValue(), $nik_bumn)){
						            	$ket[] = '<span class="label" style="background-color: #FF9800; color: #030f27;">Mitra dengan <b>No KTP</b> tersebut masih memiliki pinjaman aktif.</span>';
			            			}
			            			if(in_array($data->getCell('E'.$j)->getValue(), $nik_other)){
						            	$ket[] = '<span class="label" style="background-color: #FF5722; color: #030f27;">Mitra dengan <b>No KTP</b> tersebut masih aktif menjadi <b>mitra di BUMN lain</b></span>';
			            			}
			            			if($data->getCell('Q'.$j)->getValue() == '2' && !in_array($data->getCell('E'.$j)->getValue(), $nik_bumn)){
						            	$ket[] = '<span class="label" style="background-color: #ffc107; color: #030f27;"><b>Pinjaman Khusus</b> sebagai <b>Top Up</b> namun tidak terdapat mitra dengan <b>No KTP</b> yang masih memiliki pinjaman aktif (outstanding).</span>';
			            			}
			            		}
			            		$errors[$y][] = $ket;
				            	$y++;
		            		}
		            	}
		            }
		            $result = array('data' => $datas, 'error' => $errors);
		            if(sizeof($errors) <= 0){
		            	$param_demografi = [];
		            	$param_history = [];
		            	foreach ($datas as $key => $value) {
		            		if($value[0] == ''){
			            		$ins_demografi = self::store_demografi(array(
			            			'id_bumn_pembina' => $param['bumn'],
			            			'id_periode' => $param['periode'],
			            			'tahun_laporan' => $param['tahun'],
			            			'kode_provinsi' => $value[1],
			            			'kode_kabkota' => $value[2],
			            			'nama' => $value[3],
									'nik' => $value[4],
									'alamat' => $value[5],
									'jenis_kelamin' => $value[6],
									'jenis_produk' => $value[18],
									'tgl_lahir' => $value[7],
									'jumlah_pinjaman_rp' => $value[8],
									'tanggal_perjanjian' => $value[10],
									'jumlah_tk' => $value[11],
									'pinjaman_ke' => $value[15],
									'pinjaman_khusus' => $value[16],
									'kode_jenisusaha' => $value[17],
									'add_by' => 'yuno',
		        					'add_date' => date('Y-m-d H:m:s'),
									'kode_sektorusaha' => $value[19],
									'kode_kategoriusaha' => $value[20]
		            			));

		            			self::store_history(array(
			        					'id_kinerja_transaksi_demografimb' => DB::getPdo()->lastInsertId(),
			        					'nik' => $value[4],
			        					'id_bumn_pembina' => $param['bumn'],
			        					'id_periode' => $param['periode'],
			        					'tahun_laporan' => $param['tahun'],
			        					'kode_provinsi' => $value[1],
			        					'kode_kabkota' => $value[2],
			        					'posisi_pinjaman_rp' => $value[9],
			        					'kode_status' => $value[12],
			        					'posisi_aset_rp' => $value[13],
			        					'omset_rp' => $value[14],
			        					'unggulan' => $value[21],
			        					'add_by' => 'Yuno',
			        					'add_date' => date('Y-m-d H:m:s')
			        				));
		            		}else{
		            			if($this->history->where('id_kinerja_transaksi_demografimb', $value[0])->where('tahun_laporan', $param['tahun'])->where('id_periode', $param['periode'])->first()){
		            				self::update_history(array(
			        					'id_kinerja_transaksi_demografimb' => $value[0],
			        					'nik' => $value[4],
			        					'id_bumn_pembina' => $param['bumn'],
			        					'id_periode' => $param['periode'],
			        					'tahun_laporan' => $param['tahun'],
			        					'kode_provinsi' => $value[1],
			        					'kode_kabkota' => $value[2],
			        					'posisi_pinjaman_rp' => $value[9],
			        					'kode_status' => $value[12],
			        					'posisi_aset_rp' => $value[13],
			        					'omset_rp' => $value[14],
			        					'unggulan' => $value[21],
			        					'update_by' => 'Yuno',
			        					'update_date' => date('Y-m-d H:m:s')
			        				));
		            			}else{
			            			self::store_history(array(
			        					'id_kinerja_transaksi_demografimb' => $value[0],
			        					'nik' => $value[4],
			        					'id_bumn_pembina' => $param['bumn'],
			        					'id_periode' => $param['periode'],
			        					'tahun_laporan' => $param['tahun'],
			        					'kode_provinsi' => $value[1],
			        					'kode_kabkota' => $value[2],
			        					'posisi_pinjaman_rp' => $value[9],
			        					'kode_status' => $value[12],
			        					'posisi_aset_rp' => $value[13],
			        					'omset_rp' => $value[14],
			        					'unggulan' => $value[21],
			        					'add_by' => 'Yuno',
			        					'add_date' => date('Y-m-d H:m:s')
			        				));
		            			}
		            		}
		            	}

		            	$ins_monitoring = self::store_monitoring_laporan(array(
		            			'id_bumn_pembina' => $param['bumn'],
		            			'id_periode' => $param['periode'],
		            			'tahun_laporan' => $param['tahun'],
		            			'modelaporan' => 'demografimb',
		            			'nilai' => '2',
								'created_date' => date('Y-m-d H:i:s'),
								'created_by' => 'Yuno'
		        			));

		            	return json_encode(array(
		    				'flag' => 'success',
		    				'msg' => 'Berhasil import data',
		    				'title' => 'Sukses',
		    				'feedbackdata' => array()
		    			));
		            }else{
		            	$html = '<div class="row">
									<div class="col-md-12">
										<div class="portlet light">
											<div class="portlet-title">
												<div class="caption font-green-haze">
													<i class="icon-setting font-green-haze"></i>
													<span class="caption-subject bold uppercase">Hasil Validasi</span>
												</div>
												<div class="actions">
													<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""></a>
												</div>
											</div>
											<div class="portlet-body table-responsive">
												<table class="table table-hover table-striped table-bordered" style="white-space: nowrap;">
													<thead>
														<tr>
															<th width="80px">Kode Provinsi</th>
															<th width="80px">Kode Kab/Kota</th>
															<th width="150px">Nama</th>
															<th width="130px">No KTP</th>
															<th width="250px">Alamat</th>
															<th width="80px">Jenis Kelamin</th>
															<th width="80px">Tanggal Lahir</th>
															<th width="100px"><div align="center">Jumlah Pinjaman (Rp.)</div></th>
															<th width="100px"><div align="center">Posisi Pinjaman (Rp.)</div></th>
															<th width="80px">Tanggal Perjanjian</th>
															<th width="80px">Jumlah Tenaga Kerja</th>
															<th width="80px">Kode Status</th>
															<th width="100px"><div align="center">Posisi Aset (Rp.)</div></th>
															<th width="100px"><div align="center">Omset (Rp.)</div></th>
															<th width="80px">Pinjaman Ke-</th>
															<th width="80px">Pinjaman Khusus</th>
															<th width="100px">Kode Jenis Usaha</th>
															<th width="100px">Jenis Produk</th>
															<th width="100px">Kode Sektor Usaha</th>
															<th width="100px">Kode Kategori Usaha</th>
															<th width="80px">Unggulan</th>
															<th width="250px">Keterangan</th>
														</tr>';
						foreach ($errors as $key => $value) {
							$html .= '<tr>'.$value[1].
										$value[2].
										$value[3].
										$value[4].
										$value[5].
										$value[6].
										$value[7].
										$value[8].
										$value[9].
										$value[10].
										$value[11].
										$value[12].
										$value[13].
										$value[14].
										$value[15].
										$value[16].
										$value[17].
										$value[18].
										$value[19].
										$value[20].
										$value[21].'<td>';
							foreach ($value[22] as $k => $v) {
								$html .= $v.'</br>';
								if(sizeof($value[22]) > 1){
									$html .= '</br>';
								}
							}
							$html .= '</td></tr>';
						}
						$html .= '</thead></table></div></div></div></div>';
		            	return json_encode(array(
		            		'flag' => 'warning',
		    				'msg' => 'Data gagal disimpan karena ada beberapa data tidak sesuai atau salah dalam penulisan',
		    				'title' => 'Notifikasi',
		    				'feedbackdata' => $html	
		            	));
		            }

	    		}else{
	    			return json_encode(array(
	    				'flag' => 'error',
	    				'msg' => 'Template import salah!!!, download kembali template import sesuai peruntukan tahun dan periode',
	    				'title' => 'Gagal Upload',
	    				'feedbackdata' => array()
	    			));
	    		}
    		}else{
    			return json_encode(array(
    				'flag' => 'error',
    				'msg' => 'File import harus .xls (download terlebih dahulu templatenya)',
    				'title' => 'Gagal Upload',
    				'feedbackdata' => array()
    			));
    		}
		}
    }

    public function store_demografi($params){
    	$this->demografi->insert($params);
    }

    public function store_history($params){
    	$this->history->insert($params);
    }

    public function update_history($params){
    	$this->history->where('id_kinerja_transaksi_demografimb', $params['id_kinerja_transaksi_demografimb'])
    				->where('tahun_laporan', $params['tahun_laporan'])
    				->where('id_periode', $params['id_periode'])
    				->update($params);
    }

    public function store_monitoring_laporan($params){
    	$this->monitoring->insert($params);
    }
}
