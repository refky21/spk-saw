<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends Dashboard_Controller {

	var $module = 'transaksi';

	function __construct() 
	{
		parent::__construct();
		// restrict();
		$this->load->model($this->module.'/M_invoice');
		$this->load->model($this->module.'/M_berita');
		$this->load->model('permintaan/M_permintaan');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Invoice';


		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$this->template->title('Invoice');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Invoice' , '' );
		$this->template->build($this->module.'/invoice/v_invoice_index', $tpl);

	}

	public function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Invoice';
		$columns = array(
			1 => 'invId',
			2 => 'invPermintaan',
			3 => 'invNoInvoice',
			4 => 'pmtNoOrder',
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$fil = $this->input->post('filter_key');
			$fils = explode(".",$fil);
			$filter = $fils[0];
			if($filter == is_numeric($fils[0]) ){
				$object['pmtNoOrder'] = $fil;
			}else{
				$object['invNoInvoice'] = $fil;
			}
			
		}

		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

		$qry = $this->M_invoice->list_invoice($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_invoice->list_invoice($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'transaksi/Invoice/edit', TRUE);
			$roleCetak = restrict( 'transaksi/Invoice/cetak', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				
				if($roleEdit == TRUE){
					$editLink = '<a href="'.site_url($this->module).'/Invoice/edit/'.encode($row['id']).'"  class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Split Invoice"> <i class="ti-stats-down"></i> </a>';
				}else{
					$editLink = "";
				}
				if($roleCetak == TRUE){
					$cetakLink = '<a target="_blank" href="'.site_url($this->module).'/Invoice/cetak/'.encode($row['id']).'"  class="btn btn-square btn-success text-white table-action"  data-provide="tooltip" title="Cetak Invoice"> <i class="ti-printer"></i> </a>';
				}else{
					$cetakLink = "";
				}

				$tgl = ($row['TanggalTerbit'] != NULL) ? IndonesianDate($row['TanggalTerbit']) : '';

				$btn = $cetakLink." ".$editLink;

				$records["data"][] = array(
					$no++,
					"<b>".$row['Invoice']."</b>",
					"<b>".$row['NoOrder']."</b>",
					$row['NamaPelanggan'],
					$row['NamaPj'],
					"Rp. ".format_rupiah($row['JumlahTagihan']),
					$tgl,
					($row['JumlahBayar'] == NULL) ? $btn : 'Lunas'
				);
			}
		}
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}


	public function ajax_hitung()
	{
		$data = $this->M_invoice->hitung_invoice($this->input->post('PmtId'));
		$dt = array();
		$sum = 0;
		$alat = 0;
		foreach($data as $i => $da){
			$sum += $da['TotalHarga'];
			$dt = new \stdClass();
			$dt->HarBarang = $sum;

		}
		
		echo json_encode($dt);
	}

	public function add()
	{
		$module = $this->module.'/Invoice';
		restrict('transaksi/Invoice/add', TRUE);
		$tpl['roleAdd'] = restrict('transaksi/Invoice/add', TRUE);
		$tpl['module'] = $module;
		// $tpl['permintaan'] = $this->M_invoice->getListPermintaan()->result_array();
		// $tpl['permintaan'] = $this->M_invoice->getPmt()->result_array();

		$data = $this->M_invoice->getPmt()->result_array();
		


		$dta = array();
		$in = array();
		foreach($data as $i => $dt){
			$dta[$i]['NoOrder'] = $dt['NoOrder'];
			$dta[$i]['PermintaanId'] = $dt['PermintaanId'];
			$dta[$i]['TglPermintaan'] = $dt['TglPermintaan'];
			$dta[$i]['TglKunjungan'] = $dt['TglKunjungan'];
			$dta[$i]['TglRealisasi'] = $dt['TglRealisasi'];
			$dta[$i]['PPN'] = $dt['PPN'];
			$dta[$i]['BiayaKunjungan'] = $dt['BiayaKunjungan'];
			$dta[$i]['NamaPelanggan'] = $dt['NamaPelanggan'];
			// $dta[$i]['NamaPelanggan'] = $dt['NamaBarang'];
			// $dta[$i]['HargaTotalAlat'] = $dt['HargaTotalAlat'];
			$tes = $this->M_invoice->permintaan_detail($dt['PermintaanId']);
	
			foreach($tes as $ii => $t){
				$in[$ii]=$t['pmtdtId'];
			}

			$dta[$i]['Detail'] = $this->M_invoice->permintaan_detail($dt['PermintaanId']);

			$total_alat = $this->M_invoice->permintaan_detail_alat_total($in);
			$total_harga = $this->M_invoice->permintaan_detail_harga_total($in);
			$dta[$i]['TotalAlat'] = $total_alat;
			$dta[$i]['HargaTotalAlat'] = $total_harga['pmtdtHarga'];
			$dta[$i]['dd'] = $in;
		}


		// print_r($dta);die;

		$tpl['permintaan'] = $dta;

		$this->form_validation->set_rules('permintaan', 'Pelanggan', 'required');
		$this->form_validation->set_rules('total_tagihan', 'Total Tagihan', 'required');

		if ($this->form_validation->run()) {
			$dp = str_replace('.','',$this->input->post('total_dp'));
			$params = array(
				'invPermintaan'   => $this->input->post('permintaan'),
				'invNoInvoice' => nomor_invoice(),
				'invTanggal' => date("Y-m-d H:i:s"),
				'invJumlahDP' => $dp,
				'invJumlahTagihan' => str_replace(".","",$this->input->post('total_tagihan'))
        	);
			$rs = $this->M_invoice->insert_invoice($params);
			
			if ($rs) {
				//cek kalau sisa 0;
				$sisa = $this->input->post('sisa');
				// $dp = str_replace('.','',$this->input->post('total_dp'));
				// var_dump($dp);die;

				if($sisa != 0){
					$params = array(
						'invPermintaan'   => $this->input->post('permintaan'),
						'invNoInvoice' => nomor_invoice(),
						'invTanggal' => date("Y-m-d H:i:s"),
						'invJumlahTagihan' => $sisa,
						// 'invJumlahDP' => $dp,
					);
					// var_dump($params);die;
					$this->M_invoice->insert_invoice($params);
				}

				$pr = array(
					'pmtStatusId'   => 4,
					'pmtId'   => $this->input->post('permintaan'),
				);
				$this->M_invoice->update_status_permintaan($pr);

				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Berhasil Menerbitkan Invoice.'));
			}else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Gagal Menerbitkan Invoice.'));
			}
			redirect(site_url($module));

		}


		$this->template->inject_partial('modules_css', multi_asset( array(
                                                                        //'css/components-md.css' => '_theme_',
                                                                        'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
                                                                        'vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css' => '_theme_'
                                                                    ), 'css' ) );

        $this->template->inject_partial('modules_js', multi_asset( array(
                                                                'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
                                                                'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
                                                                'vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js' => '_theme_'
                                                            ), 'js' ) );


		$this->template->title('Invoice');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Invoice' , '' );
		$this->template->build($this->module.'/invoice/v_invoice_form', $tpl);
	}

	public function edit($idx)	
	{
		$id = decode($idx);
		$module = $this->module.'/Invoice';
		restrict('transaksi/Invoice/edit', TRUE);
		$tpl['module'] = $module;


		$this->form_validation->set_rules('pmtId', 'Pelanggan', 'required');
		$this->form_validation->set_rules('total_tagihan', 'Pelanggan', 'required');
			if ($this->form_validation->run()) {
				$harus = str_replace(".","",$this->input->post('total_harus_bayar'));
				$split = str_replace(".","",$this->input->post('total_tagihan'));
				$sekarang = str_replace(".","",$this->input->post('nominal_saat_ini'));
				$idPmt = $this->input->post('pmtId');

				$cek = $this->cek_total($idPmt, $split,$sekarang);
				$sisa = $this->hitung_sisa($idPmt,$harus,$split,$sekarang);
				if($cek){
					$params = array(
						'invId'   => $id,
						'invJumlahTagihan' => $split
					);
					$update = $this->M_invoice->update_nominal($params);
					if($update){
					$params = array(
						'invPermintaan'   => $this->input->post('pmtId'),
						'invNoInvoice' => nomor_invoice(),
						'invTanggal' => date("Y-m-d H:i:s"),
						'invJumlahTagihan' => $sisa
					);

						$rs = $this->M_invoice->insert_invoice($params);

						$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Berhasil Edit Tagihan.'));
					}else{
						$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Gagal Mengubah Tagihan.'));
					}
				}
				redirect(site_url($module));

			}
	
		$this->template->inject_partial('modules_css', multi_asset( array(
                                                                        //'css/components-md.css' => '_theme_',
                                                                        'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
                                                                        'vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css' => '_theme_'
                                                                    ), 'css' ) );

        $this->template->inject_partial('modules_js', multi_asset( array(
                                                                'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
                                                                'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
                                                                'vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js' => '_theme_'
                                                            ), 'js' ) );

		$InvPmtId = $this->M_invoice->ambil_invoice($id)->row_array();
		$tpl['dt'] = $this->M_invoice->detail_invoice($InvPmtId['PermintaanId'])->row_array();
		$tpl['dt2'] = $InvPmtId;

		// var_dump($tpl['dt']);die;
		$this->template->title('Invoice');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Invoice' , '' );
		$this->template->build($this->module.'/invoice/v_invoice_edit', $tpl);
	}


	public function hitung_sisa($id,$harus,$split,$sekarang)
	{
		$jml = $this->M_invoice->cek_total_nominal($id)->row_array();
		$cek = $jml['JmlTagihan'];

		$total = $sekarang - $split;
		$totals = $total + $split;
		// $noms = $total+$nominal_saat_ini;

		return $total;

	}

	public function cek_total($id,$split,$nominal_saat_ini)
	{
		$jml = $this->M_invoice->cek_total_nominal($id)->row_array();
		$cek = $jml['JmlTagihan'];

		$total = $cek - $split;
		$noms = $total+$nominal_saat_ini;

		if($noms >= $cek){
			return true;
		}else{
			return false;
		}

	}

	public function cetak($idx) {

		$id = decode($idx);

		$tpl['title'] 		= 'Cetak Invoice';
		$tpl['invoice']		= $this->M_invoice->cetakInvoice($id)->row_array();
		$tpl['data']			= $this->M_invoice->dataInvoice($id)->result_array();
		$tpl['jumlah']		= $this->M_invoice->jumlah($id);
		
		$this->template->set_layout('layout_blank')
									 ->set_partial('modules_js','modules_js')
									 ->set_partial('modules_css','modules_css');
		$this->template->build($this->module.'/invoice/v_invoice_cetak.php', $tpl);
	}

	public function ajax_select()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$PmtId = $this->input->post("PmtId");

		$teknisi = $this->M_invoice->getTeknisi($PmtId);
		$data = array();
		foreach($teknisi as $i => $tkn){
			$data[$i]['NamaTeknisi'] = $tkn['NamaTeknisi'];
			$data[$i]['Jabatan'] = $tkn['Jabatan'];
		}
		

		echo json_encode($data);
	}
}


/* End of file Invoice.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\transaksi\controllers\Invoice.php */