<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kwitansi extends Dashboard_Controller {
	var $module = 'transaksi';

	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_kwitansi');
		$this->load->model($this->module.'/M_invoice');
		$this->load->model($this->module.'/M_berita');
		$this->load->model('permintaan/M_permintaan');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Kwitansi';
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );
		$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$this->template->title('Kwitansi');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Kwitansi' , '' );
		$this->template->build($this->module.'/kwitansi/v_kwitansi_index', $tpl);
	}

	public function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Kwitansi';
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

		$qry = $this->M_kwitansi->list_invoice($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_kwitansi->list_invoice($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleCetak = restrict( 'transaksi/Kwitansi/cetak', TRUE);
			foreach($qry->result_array() as $row){
				// Buttons
				

				if($roleCetak == TRUE){
					$cetakLink = '<a target="_blank" href="'.site_url($this->module).'/Kwitansi/cetak/'.encode($row['id']).'"  class="btn btn-square btn-success text-white table-action"  data-provide="tooltip" title="Cetak Kwitansi"> <i class="ti-printer"></i> </a>';
				}else{
					$cetakLink = "";
				}

				$tgl = ($row['TanggalTerbit'] != NULL) ? IndonesianDate($row['TanggalTerbit']) : '';


				$records["data"][] = array(
					$no++,
					"<b>".$row['Invoice']."</b>",
					"<b>".$row['NoOrder']."</b>",
					$row['NamaPelanggan'],
					$row['NamaPj'],
					"Rp. ".format_rupiah($row['JumlahTagihan']),
					"Rp. ".format_rupiah($row['JumlahBayar']),
					$tgl,
					($row['TanggalBayar'] != NULL) ? IndonesianDate($row['TanggalBayar']) : '',
					$cetakLink
				);
			}
		}
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function add()
	{
		$module = $this->module.'/Kwitansi';
		restrict('transaksi/Kwitansi/add', TRUE);
		$tpl['roleAdd'] = restrict('transaksi/Kwitansi/add', TRUE);
		$tpl['module'] = $module;
		$tpl['listInvoice'] = $this->M_kwitansi->getListInvoice()->result_array();

		$this->form_validation->set_rules('invoice_id', 'Nomor Invoice', 'required');
		$this->form_validation->set_rules('total_pembayaran', 'Total Pembayaran', 'required');
		if ($this->form_validation->run()) {
			

			// cek total bayar dan total tagihan

			
			$ambilInvoice = $this->M_kwitansi->getInvoice($this->input->post('invoice_id'));
			
				$params = array(
					'invId' => $this->input->post('invoice_id'),
					'invTerbayar' => str_replace('.','',$this->input->post('total_pembayaran')),
					'invPermintaan' => $this->input->post('permintaan_id')
				);
				$update = $this->M_kwitansi->update_pembayaran($params);

			if ($update) {
				$cek = $this->cek_total($this->input->post('permintaan_id'));


				if($cek){
					$params = array(
						'invPermintaan' => $this->input->post('permintaan_id'),
					);
					$this->M_kwitansi->update_status_permintaan($params);
				}

				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Berhasil Membayarkan Invoice.'));
			}else{
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Gagal Membayar Invoice.'));
			}
			redirect(site_url($module));

		}


		$this->template->title('Kwitansi');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Kwitansi' , '' );
		$this->template->build($this->module.'/kwitansi/v_kwitansi_form', $tpl);
	}


	// public function cekstatus($idx)
	// {
	// 	$module = $this->module.'/Kwitansi';

	// 	$id = decode($idx);
	// 	$cek = $this->cek_total($id);

	// 	if($cek){
	// 			$params = array(
	// 				'invPermintaan' => $id,
	// 			);
	// 		$update = $this->M_kwitansi->update_status_permintaan($params);
	// 		var_dump($update);die;
	// 		if ($update) {
	// 			$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Berhasil Membayarkan Invoice.'));
	// 		}else{
	// 			$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Gagal Membayar Invoice.'));
	// 		}
	// 	}else{
	// 		$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Berhasil Membayarkan Invoice.'));
	// 	}

	// 	// redirect(site_url($module));
	// }


	function cek_total($id)
	{
		$totalBayar = $this->M_kwitansi->total_bayar($id);
		$totalTagihan = $this->M_kwitansi->total_tagihan($id);

		if($totalBayar['TotalBayar'] == $totalTagihan['TotalTagihan']){
			$status = true;
		}else{
			$status = false;
		}

		return $status;
	}

	function cetak($idx) {
		$id = decode($idx);

		$tpl['title'] 		= 'Cetak Kwitansi';
		$tpl['cetak']			= $this->M_kwitansi->cetak($id);
		$tpl['detail']    = $this->M_kwitansi->cetakAlat($id);

		$this->template->set_layout('layout_blank')
									 ->set_partial('modules_js','modules_js')
									 ->set_partial('modules_css','modules_css');
		$this->template->build($this->module.'/kwitansi/v_kwitansi_cetak.php', $tpl);

	}

}


/* End of file Kwitansi.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\transaksi\controllers\Kwitansi.php */