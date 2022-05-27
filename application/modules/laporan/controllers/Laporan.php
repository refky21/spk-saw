<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Dashboard_Controller {
	
	var $module = 'laporan';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_laporan');
	}

	public function index() {

		$tpl['permintaan'] = $this->M_laporan->get_permintaan();
	
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Laporan Pelaksanaan Pengujian');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Laporan Pelaksanan' , '' );
		$this->template->build($this->module.'/v_laporan_index.php', $tpl);
	}

	public function datatables_laporan() {
		if (!$this->input->is_ajax_request()) exit ('No direct script access allowed');
		
		$columns = [
			1 => 'pmtNoOrder',
			2 => 'alkesNamaBarang',
			3 => 'pdaNoSeri',
			4 => 'pdaMerk',
			5 => 'pdaTipe',
			6 => 'pdaLokasiAlat',
			7 => 'pmtTglRealisasi',
			8 => 'pdaStatusKalibrasi',
			9 => 'pdaStatusKalibrasi',
			10 => 'pdaNoSertifikat'
		];

		$object = [];
		if ($this->input->post('filter_permintaan') != '') {
			$object['pmtId'] = '='.$this->input->post('filter_permintaan');
		}

		$order = [];
      if($this->input->post('order')){
         foreach( $this->input->post('order') as $row => $val){
            $order[$columns[$val['column']]] = $val['dir'];
         }
      }

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$qry = $this->M_laporan->get_list_permintaan($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_laporan->get_list_permintaan($object, NULL, NULL, NULL, 'counter')) : 0;

		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));

		$records = [];
		$records['data'] = [];
		if (!is_null($qry)) {
			$no = $iDisplayStart + 1;
			foreach($qry->result_array() as $row) {
				$records['data'][] = [
					$no++,
					$row['nomorOrder'],
					$row['namaAlkes'],
					$row['noseri'],
					$row['merk'],
					$row['tipe'],
					$row['lokasialat'],
					$row['tglpelaksanaan'],
					$row['statuskalibrasi'],
					$row['namaTeknisi'],
					$row['nosertifikat']
				];
			}
		}

		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function exports($permintaan = '') {
		$this->load->library('excel');

		$object = [];
		if ($permintaan != '') {
			$object['pmtId'] = '='.$permintaan;
		}

		$nomor_order = 'SEMUA';

		if (count($object) > 0) {
			$detail = $this->M_laporan->get_detail_permintaan($object)->row_array();
			if (!empty($detail)) {
				 $nomor_order = $detail['nomorOrder'];
			}
	 }

		// var_dump($nomor_order);

		$fileExcel = $nomor_order.'-'."Data laporan pengujian";
		$this->excel->setFilename($fileExcel);
		$this->excel->setWorksheetname('Laporan Pengujian');
		$this->excel->setTitle('A2', 'J3', 'LAPORAN PELAKSANAAN PENGUJIAN & KALIBRASI ALAT KESEHATAN');

		$this->excel->setMergerCell('A4','C4');
		$this->excel->setDataCell(0, 4, 'Nama Institusi Penguji');
		$this->excel->setMergerCell('D4','J4');
		$this->excel->setDataCell(3, 4, ': '.'PT. Adi Multi Kalibrasi', NULL, 20);

		$this->excel->setMergerCell('A5','C5');
		$this->excel->setDataCell(0, 5, 'Alamat Lengkap');
		$this->excel->setMergerCell('D5','J5');
		$this->excel->setDataCell(3, 5, ': '.'Jl. Cendana No. 9A Semaki Yogyakarta', NULL, 20);

		$this->excel->setMergerCell('A6','C6');
		$this->excel->setDataCell(0, 6, 'No. Telp & Fax');
		$this->excel->setMergerCell('D6','J6');
		$this->excel->setDataCell(3, 6, ': '.'(0274) 563515 ext 1615', NULL, 20);

		$this->excel->setMergerCell('A7','C7');
		$this->excel->setDataCell(0, 7, 'Sarana Pelayanan Kesehatan');
		$this->excel->setMergerCell('D7','J7');
		$this->excel->setDataCell(3, 7, ': '.'', NULL, 20);

		$this->excel->setMergerCell('A8','C8');
		$this->excel->setDataCell(0, 8, 'Nomor Order');
		$this->excel->setMergerCell('D8','J8');
		$this->excel->setDataCell(3, 8, ': '.$nomor_order, NULL, 20);

		$headerTable = [
										['cell' => 'A9', 'label' => 'No.', 'width' => '5'],
										['cell' => 'B9', 'label' => 'Nama Alat Kesehatan', 'width' => '25'],
										['cell' => 'C9', 'label' => 'Nomor Seri', 'width' => '25'],
										['cell' => 'D9', 'label' => 'Merk', 'width' => '15'],
										['cell' => 'E9', 'label' => 'Type/Model', 'width' => '15'],
										['cell' => 'F9', 'label' => 'Lokasi', 'width' => '15'],
										['cell' => 'G9', 'label' => 'Tanggal Pelaksanaan', 'width' => '20'],
										['cell' => 'H9', 'label' => 'Hasil', 'width' => '10'],
										['cell' => 'I9', 'label' => 'Petugas', 'width' => '40'],
										['cell' => 'J9', 'label' => 'No. Sertifikat', 'width' => '20']
									];

		$this->excel->SetHeaderRow($headerTable);

		$query	= $this->M_laporan->get_detail_permintaan($object);
		$data		= $query->result_array();

		/*
			$i			= 0;
			$dt			= [];
			foreach($data as $row) {
				$dt[$i]['namaAlkes']				= $row['namaAlkes'];
				$dt[$i]['noseri']						= $row['noseri'];
				$dt[$i]['merk']							= $row['merk'];
				$dt[$i]['tipe']							= $row['tipe'];
				$dt[$i]['lokasialat']				= $row['lokasialat'];
				$dt[$i]['tglpelaksanaan']		= $row['tglpelaksanaan'];
				$dt[$i]['statuskalibrasi']	= $row['statuskalibrasi'];
				$dt[$i]['namaTeknisi']			= $row['namaTeknisi'];
				$dt[$i]['nosertifikat']			= $row['nosertifikat'];
				$i++;
			}
		*/

		$start_data	= 10;
		foreach ($data as $d => $permintaan) {
			$baris = $start_data + $d;
			$this->excel->setTableCell(0, $baris, $d+1);
			$this->excel->setTableCell(1, $baris, ucwords(strtolower($permintaan['namaAlkes'])));
			$this->excel->setTableCell(2, $baris, ucwords(strtolower($permintaan['noseri'])));
			$this->excel->setTableCell(3, $baris, ucwords(strtolower($permintaan['merk'])));
			$this->excel->setTableCell(4, $baris, ucwords(strtolower($permintaan['tipe'])));
			$this->excel->setTableCell(5, $baris, ucwords(strtolower($permintaan['lokasialat'])));
			$this->excel->setTableCell(6, $baris, ucwords(strtolower($permintaan['tglpelaksanaan'])));
			$this->excel->setTableCell(7, $baris, ucwords(strtolower($permintaan['statuskalibrasi'])));
			$this->excel->setTableCell(8, $baris, ucwords(strtolower($permintaan['namaTeknisi'])));
			$this->excel->setTableCell(9, $baris, ucwords(strtolower($permintaan['nosertifikat'])));
		}

		$this->excel->writeExcel();
	}

	public function export($permintaan = '') {
		$this->load->library('excel');

		$object = [];
		if ($permintaan != '') {
			$object['pmtId'] = '='.$permintaan;
		}

		$nomor_order = 'SEMUA';

		if (count($object) > 0) {
			$detail = $this->M_laporan->get_detail_permintaan($object)->row_array();
			if (!empty($detail)) {
				 $nomor_order = $detail['nomorOrder'];
			}
	 }

		// var_dump($nomor_order);

		$fileExcel = $nomor_order.'-'."Data laporan pengujian";
		$this->excel->setFilename($fileExcel);
		$this->excel->setWorksheetname('Laporan Pengujian');
		$this->excel->setTitle('A5', 'J6', 'LAPORAN PELAKSANAAN PENGUJIAN & KALIBRASI ALAT KESEHATAN');

		$this->excel->setMergerCell('A7','C7');
		$this->excel->setDataCell(0, 7, 'Nama Institusi Penguji');
		$this->excel->setMergerCell('D7','J7');
		$this->excel->setDataCell(3, 7, ': '.'PT. Adi Multi Kalibrasi', NULL, 20);

		$this->excel->setMergerCell('A8','C8');
		$this->excel->setDataCell(0, 8, 'Alamat Lengkap');
		$this->excel->setMergerCell('D8','J8');
		$this->excel->setDataCell(3, 8, ': '.'Jl. Cendana No. 9A Semaki Yogyakarta', NULL, 20);

		$this->excel->setMergerCell('A9','C9');
		$this->excel->setDataCell(0, 9, 'No. Telp & Fax');
		$this->excel->setMergerCell('D9','J9');
		$this->excel->setDataCell(3, 9, ': '.'(0274) 563515 ext 1615', NULL, 20);

		$this->excel->setMergerCell('A10','C10');
		$this->excel->setDataCell(0, 10, 'Sarana Pelayanan Kesehatan');
		$this->excel->setMergerCell('D10','J10');
		$this->excel->setDataCell(3, 10, ': '.$detail['NamaPelanggan'], NULL, 20);

		$this->excel->setMergerCell('A11','C11');
		$this->excel->setDataCell(0, 11, 'Nomor Order');
		$this->excel->setMergerCell('D11','J11');
		$this->excel->setDataCell(3, 11, ': '.$nomor_order, NULL, 20);

		$headerTable = [
										['cell' => 'A12', 'label' => 'No.', 'width' => '5'],
										['cell' => 'B12', 'label' => 'Nama Alat Kesehatan', 'width' => '25'],
										['cell' => 'C12', 'label' => 'Nomor Seri', 'width' => '25'],
										['cell' => 'D12', 'label' => 'Merk', 'width' => '15'],
										['cell' => 'E12', 'label' => 'Type/Model', 'width' => '15'],
										['cell' => 'F12', 'label' => 'Lokasi', 'width' => '15'],
										['cell' => 'G12', 'label' => 'Tanggal Pelaksanaan', 'width' => '15'],
										['cell' => 'H12', 'label' => 'Hasil', 'width' => '10'],
										['cell' => 'I12', 'label' => 'Petugas', 'width' => '50'],
										['cell' => 'J12', 'label' => 'No. Sertifikat', 'width' => '20']
									];

		$this->excel->SetHeaderRow($headerTable);

		$query	= $this->M_laporan->get_detail_permintaan($object);
		$data		= $query->result_array();

		$start_data	= 13;
		foreach ($data as $d => $permintaan) {
			$baris = $start_data + $d;
			$this->excel->setTableCell(0, $baris, $d+1);
			$this->excel->setTableCell(1, $baris, ucwords(strtolower($permintaan['namaAlkes'])));
			$this->excel->setTableCell(2, $baris, ucwords(strtolower($permintaan['noseri'])));
			$this->excel->setTableCell(3, $baris, ucwords(strtolower($permintaan['merk'])));
			$this->excel->setTableCell(4, $baris, ucwords(strtolower($permintaan['tipe'])));
			$this->excel->setTableCell(5, $baris, ucwords(strtolower($permintaan['lokasialat'])));
			$this->excel->setTableCell(6, $baris, ucwords(strtolower($permintaan['tglpelaksanaan'])));
			$this->excel->setTableCell(7, $baris, ucwords(strtolower($permintaan['statuskalibrasi'])));
			$this->excel->setTableCell(8, $baris, ucwords(strtolower($permintaan['namaTeknisi'])));
			$this->excel->setTableCell(9, $baris, ucwords(strtolower($permintaan['nosertifikat'])));
		}

		$this->excel->writeExcel();
	}

}


/* End of file Laporan.php */
/* Location: D:\xampp\htdocs\uad\si-amk\application\modules\laporan\controllers\Laporan.php */