<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemrograman extends Dashboard_Controller {
	
	var $module = 'refrensi';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_pemrograman');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Pemrograman';
		$tpl['roleAdd']    = restrict('refrensi/Pemrograman/add', TRUE);
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Data Bahasa Pemrograman');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Bahasa Pemrograman' , '' );
		$this->template->build($this->module.'/v_pemrograman_index', $tpl);
	}


	function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Pemrograman';
		$columns = array(
			1 => 'pemId',
			2 => 'pemNama'
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
		$qry = $this->M_pemrograman->list_bahasa($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_pemrograman->list_bahasa($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'refrensi/Pemrograman/update', TRUE);
			$roleDelete = restrict( 'refrensi/Pemrograman/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				if($roleEdit == TRUE){
					$editLink = '<a id="edit-btn" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" data-id="'.encode($row['id']).'" title="Edit Pemrograman"> <i class="fa fa-pencil"></i> </a>';
				}else{
					$editLink = "";
				}

				if($roleDelete == TRUE){
					$deleteLink = '<a id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" data-id="'.encode($row['id']).'" title="Hapus Pemrograman"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}
				// Status
				$stts = ($row['Status'] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>';

				$records["data"][] = array(
				$no++,
				$row['nama'],
				$editLink.' '. $deleteLink
				);
			}
		}
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);

	}

	function add()
	{
		// Role Aktif Add
		restrict('refrensi/Pemrograman/add', TRUE);

	$tpl['module']  = $this->module.'/Pemrograman';
	
	$this->form_validation->set_rules('bahasaPemrograman', 'Pemrograman', 'required');

		if ($this->form_validation->run()) {
			$params = array(
				'pemNama' => $this->input->post('bahasaPemrograman'),
			);

				$proses = $this->M_pemrograman->insertPemrograman($params);
			if ($proses) {
            	$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Pemrograman berhasil ditambahkan.');
			} else {
				$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Pemrograman gagal ditambahkan.');
			}
		}else {
        	$result = array('error' => array('nambar' => form_error('nambar')));
    	}
		echo json_encode($result);
	}

	public function update($idx)
	{
		$id = decode($idx);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post('action') == 'submit') {
		$this->form_validation->set_rules('pemNama', 'Pemrograman', 'required');

			if ($this->form_validation->run()) {
				$params = array(
					'pemNama' => $this->input->post('pemNama'),
					'id' => $this->input->post('id'),
				);
				$proses = $this->M_pemrograman->UpdatePemrograman($params);

				// var_dump($proses);die;
				if ($proses) {
					$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Pemrograman berhasil perbarui.');
				} else {
					$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Pemrograman gagal diubah.');
				}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else {
				$result = array('error' => array('nama' => form_error('nama')));
				echo json_encode($result);
        	}
		}else{
			$tpl['module']  = $this->module.'/Pemrograman';
			$tpl['data']   = $this->M_pemrograman->getPemrograman($id);
			$tpl['kriteria'] = $this->M_pemrograman->getKriteria();

			// var_dump($tpl['data']); die;
			$this->load->view($this->module.'/v_pemrograman_edit', $tpl);
		}
	}

	function delete($idx)
	{
		restrict('refrensi/Pemrograman/delete', TRUE);
		$id = decode($idx);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($rs = $this->M_pemrograman->DeletePemrograman($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus Pemrograman berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus Pemrograman gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Alkes.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\alkes\controllers\Alkes.php */