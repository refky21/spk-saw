<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends Dashboard_Controller {
	
	var $module = 'transaksi';

	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_bobot');
		$this->load->model($this->module.'/M_penilaian');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Penilaian';
		$tpl['roleAdd']    = restrict('transaksi/Penilaian/add', TRUE);

		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		
		$this->template->title('Penilaian');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Penilaian' , '' );
		$this->template->build($this->module.'/penilaian/v_index', $tpl);
	}


	public function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Penilaian';
		$columns = array(
			1 => 'pemNama',
			2 => 'fwNama'
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

		$qry = $this->M_penilaian->list_nilai($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_penilaian->list_nilai($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleDelete = restrict('transaksi/Bobot/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				// $detail = '<a target="_blank" href="'.site_url($this->module).'/Bobot/detail/'.encode($row['id_pem']).'" id="btnDetail" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" title="Detail bobot"> <i class="ti-eye"></i> </a>';
				

				if($roleDelete == TRUE){
					$deleteLink = '<a href="'.site_url($this->module).'/Penilaian/delete/'.encode($row['id_fw']).'" id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" title="Hapus Bobot"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}

				$btn = $deleteLink;
			
				$records["data"][] = array(
				$no++,
				$row['pemrograman'],
				$row['Framework'],
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
		$module = $this->module.'/Penilaian';
		restrict('transaksi/Bobot/add', TRUE);
		$tpl['module'] = $module;

		$this->form_validation->set_rules('bahasa', 'Bahasa Pemrograman', 'required');
		if ($this->form_validation->run()) {

				// $cekBhs = $this->M_bobot->cekDataBobot($this->input->post('bahasa'));
				$str = $this->M_bobot->getBhs($this->input->post('bahasa'));
				
				// if($cekBhs > 0){
				// 	$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'warning', 'text' => 'Pembobotan Untuk Bahasa Pemrograman <b>'.$str->nama.'</b> Sudah Dihitung'));
				// 	// $this->session->set_flashdata('error', 'Data sudah ada');
				// 	redirect(site_url($module));
				// }
			$cekFw = $this->M_penilaian->cekDataFw($this->input->post('bahasa'),$this->input->post('fw'));
			if($cekFw == 0){
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'warning', 'text' => 'Pilih Framework Bahasa Pemrograman <b>'.$str->nama.'</b> Yang Sesuai'));
				redirect(site_url($module));
			}
			$kriteria = $this->input->post('kriteriaId');

			// var_dump($kriteria);die;
			foreach($kriteria as $i => $krt){
				// $data[$i]['krtId'] = $krt;
				// $data[$i]['bobotKrtId'] = $this->input->post($krt);
				
				$params = array(
					'nilaiFwId' => $this->input->post('fw'),
					'nilaiBhsId' => $this->input->post('bahasa'),
					'nilaiKrtId' => $krt,
					'nilaiAltrId' => $this->input->post($krt)
				);

				$rs = $this->M_penilaian->insertNilai($params);
			}
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Input Nilai berhasil.'));
			}else{
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Input Nilai gagal.'));
			}
			redirect(site_url($module));
		}
		$this->template->title( 'Penilaian' );
		$this->template->set_breadcrumb( 'Beranda' , 'dashboard');
		$this->template->set_breadcrumb( 'Bobot' , 'transaksi/Bobot');
		$this->template->set_breadcrumb( 'Hitung Bobot' , '');

		$tpl['bahasa'] = $this->M_bobot->getBahasa();
		$tpl['fw'] = $this->M_penilaian->getFramework();
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

		
		$this->template->build($this->module .'/penilaian/v_add', $tpl);
	}


	public function delete($idx)
	{
		$id = decode($idx);
		$detil = $this->M_penilaian->cekNilai($id);
		restrict('transaksi/Penilaian/delete', TRUE);
		if ($detil > 0) {
			$rs = $this->M_penilaian->DeleteNilai($id);
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Hapus Penilaian berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Hapus Penilaian gagal.'));
			}
		}
		redirect(site_url($this->module.'/Penilaian'));  
	}
}


/* End of file Penilaian.php */
/* Location: D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\transaksi\controllers\Penilaian.php */