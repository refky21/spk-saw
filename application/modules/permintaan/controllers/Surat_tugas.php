<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_tugas extends Dashboard_Controller {
	
	var $module = 'permintaan';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_suratugas');
		$this->load->helper($this->module.'/pmt');
	}

	public function index($idx)
	{
		restrict('permintaan/Surat_tugas/index', TRUE);
		
		$id = decode($idx);
		$tpl['hashId']    = $idx;
		$tpl['module']    = $this->module.'/Surat_tugas';
		$tpl['modules']    = $this->module.'/Permintaan';
		$tpl['roleAdd']    = restrict('permintaan/Surat_tugas/add', TRUE);

		$length = null;
		$order = array();
		$order['ptTeknisiId'] = 'ASC';

		if($idx != ''){
			$object['ptPermintaanId'] = '='.$id;
		}

		$count = $this->M_suratugas->list_teknisi($object, $length, 1, $order,'counter',$id);

		$tpl['jmlTeknisi'] = $count;
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Permintaan');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Permintaan' , '' );
		$this->template->build($this->module.'/surat_tugas/v_surat_index', $tpl);
	}

	public function read($hashId)
	{
		$id = decode($hashId);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Permintaan';
		$columns = array(
			1 => 'ptTeknisiId',
			2 => 'UserRealName'
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['UserRealName'] = $this->input->post('filter_key');
		}

		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

		$qry = $this->M_suratugas->list_teknisi($object, $length, $this->input->post('start'), $order,NULL,$id);
		// var_dump($qry->result_array());die;
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_suratugas->list_teknisi($object, NULL, NULL, NULL, 'counter',$id)) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'permintaan/Surat_tugas/edit', TRUE);
			$roleDelete = restrict('permintaan/Surat_tugas/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				
				if($roleDelete == TRUE){
					$deleteLink = '<a id="del-btn" href="'. site_url($this->module.'/Surat_tugas/delete/'.encode($row['id']).'/'.$row['teknisiId'] ) .'" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip"  title="Hapus Alat"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}
			
				$btn =$deleteLink;

				$records["data"][] = array(
				$no++,
				$row['NamaTeknisi'],
				$row['HpTeknisi'],
				$btn
				);
			}
		}
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);
	}

	public function add($idx)
	{
		$id = decode($idx);
		restrict('permintaan/Surat_tugas/add', TRUE);
		$tpl['hashId'] = $idx;
		$module = $this->module.'/Surat_tugas';
		$tpl['module'] = $module;

		$teknisi_ada = $this->M_suratugas->get_tugas_teknisi($id);

		$used = [];
		$i = 0;
		foreach($teknisi_ada as $use){
			$used[$i] = $use['ptTeknisiId'];
			$i++;
		}

		$teknisi = $this->M_suratugas->get_list_teknisi($used);


		$this->form_validation->set_rules('ptTeknisiId', 'Teknisi', 'required');
		if ($this->form_validation->run()) {
			$params = array(
				'ptPermintaanId'     => $id,
				'ptTeknisiId'   => $this->input->post('ptTeknisiId')
        	);
			$rs = $this->M_suratugas->insert_teknisi($params);
			if ($rs) {
            	$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Penambahan Teknisi berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Penambahan Teknisi gagal.'));
			}
			redirect(site_url($module.'/index/'.$idx));
		}
		$error = $this->form_validation->error_array();
		if (!empty($this->form_validation->error_array())) {
			foreach($error as $err) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Penambahan Teknisi gagal. '.$err));  
			}
			redirect(site_url($module.'/index/'.$idx)); 
		}

		$tpl['listTeknisi'] = $teknisi;
		$this->load->view($this->module . '/surat_tugas/v_suratugas_add', $tpl);

	}

	public function delete($idx,$tekid)
	{
			$id = decode($idx);
			$idTek = $tekid;

			$rs = $this->M_suratugas->delete($id,$idTek);
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Hapus Petugas berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Hapus Petugas gagal.'));
			}
		redirect(site_url($this->module.'/Surat_tugas/index/'.$idx)); 
	}

	public function cetak($idx = '')
	{
		$id = decode($idx);

		if($idx != ''){
			$object['ptPermintaanId'] = '='.$id;
		}

		$length = null;
		$order = array();
		$order['ptTeknisiId'] = 'ASC';

		$qry = $this->M_suratugas->list_teknisi($object, $length, 1, $order,NULL,$id);
		$tpl['cetak'] = $this->M_suratugas->cetak($id);
		$tpl['teknisi'] = $qry->result_array();
		// $qry = $this->M_suratugas->list_teknisi($object, $length, $this->input->post('start'), $order,NULL,$id);

			$this->template->set_layout('layout_blank')
						->set_partial('modules_js','modules_js')
						->set_partial('modules_css','modules_css');

		$this->template->build($this->module. '/surat_tugas/v_cetak_sk', $tpl);
	}
}


/* End of file Surat_tugas.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\transaksi\controllers\Surat_tugas.php */