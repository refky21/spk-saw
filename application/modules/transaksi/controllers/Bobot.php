<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Bobot extends Dashboard_Controller {

	var $module = 'transaksi';

	function __construct() 
	{
		parent::__construct();
		// restrict();
		$this->load->model($this->module.'/M_bobot');
	}

	public function index()
	{
		protect_acct();
		$tpl['module']    = $this->module.'/Bobot';
		$tpl['roleAdd']    = restrict('transaksi/Bobot/add', TRUE);

		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Bobot');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Bobot' , '' );
		$this->template->build($this->module.'/bobot/v_index', $tpl);

	}

	public function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Bobot';
		$columns = array(
			1 => 'pemNama'
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['pemNama'] = $this->input->post('filter_key');
		}

		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

		$qry = $this->M_bobot->list_bobot($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_bobot->list_bobot($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleDelete = restrict('transaksi/Bobot/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				$detail = '<a target="_blank" href="'.site_url($this->module).'/Bobot/detail/'.encode($row['id_pem']).'" id="btnDetail" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" title="Detail bobot"> <i class="ti-eye"></i> </a>';
				

				if($roleDelete == TRUE){
					$deleteLink = '<a href="'.site_url($this->module).'/Bobot/delete/'.encode($row['id_pem']).'" id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" title="Hapus Bobot"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}

				$btn = $detail.' '. $deleteLink;
			
				$records["data"][] = array(
				$no++,
				$row['pemrograman'],
				$btn
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
		$module = $this->module.'/Bobot';
		restrict('transaksi/Bobot/add', TRUE);
		$tpl['module'] = $module;

		$this->form_validation->set_rules('bahasa', 'Bahasa Pemrograman', 'required');
		if ($this->form_validation->run()) {

				$cekBhs = $this->M_bobot->cekDataBobot($this->input->post('bahasa'));
				$str = $this->M_bobot->getBhs($this->input->post('bahasa'));
				
				if($cekBhs > 0){
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'warning', 'text' => 'Pembobotan Untuk Bahasa Pemrograman <b>'.$str->nama.'</b> Sudah Dihitung'));
					// $this->session->set_flashdata('error', 'Data sudah ada');
					redirect(site_url($module));
				}
			$kriteria = $this->input->post('kriteriaId');
			foreach($kriteria as $i => $krt){
				$data[$i]['krtId'] =$krt;
				$data[$i]['bobotKrtId'] = $this->input->post($krt);
				
				

				$params = array(
					'bbtBhasId' => $this->input->post('bahasa'),
					'bbtKrtId' => $krt,
					'bbtValue' => $this->input->post($krt)
				);

				$rs = $this->M_bobot->insertBobot($params);
			}
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Input Bobot berhasil.'));
			}else{
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Input Bobot gagal.'));
			}
			redirect(site_url($module));
		}
		$this->template->title( 'Hitung Bobot' );
		$this->template->set_breadcrumb( 'Beranda' , 'dashboard');
		$this->template->set_breadcrumb( 'Bobot' , 'transaksi/Bobot');
		$this->template->set_breadcrumb( 'Hitung Bobot' , '');

		$tpl['bahasa'] = $this->M_bobot->getBahasa();
		$data = $this->M_bobot->getKriteria();
		$datas = array();

		foreach($data as $i=>$d){
			$datas[$i]['id_kriteria'] = $d['id'];
			$datas[$i]['nama_kriteria'] = $d['nama'];
			$alter = $this->M_bobot->getAlternatif($d['id']);
			if(!empty($alter)){
				foreach($alter as $ii => $a){
					$datas[$i]['alternatif'][$ii] = $a['id'].'-'. $a['nama'].'-'.$a['nilai'];
				}
			}else{
				$datas[$i]['alternatif'] = array();
			}
		}


		 $tpl['kriteria'] = $datas;

		
		$this->template->build($this->module .'/bobot/v_add', $tpl);
	}

	public function detail($idx = null)
	{
		protect_acct();
		$id = decode($idx);
		// $dt = $this->M_bobot->getDetailBobot($id);

		// var_dump($dt); die;
		$tpl['data'] = $this->M_bobot->getDetailBobot($id);
		$this->load->view($this->module.'/bobot/v_detail', $tpl);
		// var_dump($idx);
	}

	public function delete($idx)
	{
		$id = decode($idx);
		$detil = $this->M_bobot->cekDataBobot($id);
		restrict('transaksi/Bobot/delete', TRUE);
		if ($detil > 0) {
			$rs = $this->M_bobot->DeleteBobot($id);
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Hapus Bobot berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Hapus Bobot gagal.'));
			}
		}
		redirect(site_url($this->module.'/Bobot'));  
	}
}


/* End of file Bobot.php */
/* Location: D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Bobot.php */