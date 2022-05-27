<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kriteria extends Dashboard_Controller {
	
	var $module = 'refrensi';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_kriteria');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Kriteria';
		$tpl['roleAdd']    = restrict('refrensi/Kriteria/add', TRUE);
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Data Kriteria');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Kriteria' , '' );
		$this->template->build($this->module.'/v_kriteria_index', $tpl);
	}


	function ajax_datatables()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Kriteria';
		$columns = array(
			1 => 'kriteriaId',
			2 => 'kriteriaNama'
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['kriteriaNama'] = $this->input->post('filter_key');
		}
		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}
		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$qry = $this->M_kriteria->list_kriteria($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_kriteria->list_kriteria($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'refrensi/Kriteria/update', TRUE);
			$roleDelete = restrict( 'refrensi/Kriteria/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				if($roleEdit == TRUE){
					$editLink = '<a id="edit-btn" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" data-id="'.encode($row['id']).'" title="Edit Kriteria"> <i class="fa fa-pencil"></i> </a>';
				}else{
					$editLink = "";
				}

				if($roleDelete == TRUE){
					$deleteLink = '<a id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" data-id="'.encode($row['id']).'" title="Hapus Kriteria"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}
				// Status
				$stts = ($row['Status'] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>';

				$records["data"][] = array(
				$no++,
				$row['nama'],
				$row['sifat'],
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
		restrict('refrensi/Kriteria/add', TRUE);

	$tpl['module']  = $this->module.'/Kriteria';
	
	$this->form_validation->set_rules('kriteriaNama', 'Kriteria', 'required');
	$this->form_validation->set_rules('kriteriaSifat', 'Sifat', 'required');

		if ($this->form_validation->run()) {
			$params = array(
				'kriteriaNama' => $this->input->post('kriteriaNama'),
				'kriteriaSifat' => $this->input->post('kriteriaSifat'),
			);

				$proses = $this->M_kriteria->insertKriteria($params);
			if ($proses) {
            	$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Kriteria berhasil ditambahkan.');
			} else {
				$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Kriteria gagal ditambahkan.');
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
		$this->form_validation->set_rules('kriteriaNama', 'Kriteria', 'required');
		$this->form_validation->set_rules('kriteriaSifat', 'Sifat', 'required');

			if ($this->form_validation->run()) {
				$params = array(
					'kriteriaNama' => $this->input->post('kriteriaNama'),
					'kriteriaSifat' => $this->input->post('kriteriaSifat'),
					'id' => $this->input->post('id'),
				);
				$proses = $this->M_kriteria->UpdateKriteria($params);

				// var_dump($proses);die;
				if ($proses) {
					$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data kriteria berhasil perbarui.');
				} else {
					$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data kriteria gagal diubah.');
				}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else {
				$result = array('error' => array('nama' => form_error('nama')));
				echo json_encode($result);
        	}
		}else{
			$tpl['module']  = $this->module.'/Kriteria';
			$tpl['data']   = $this->M_kriteria->getKriteria($id);
			$this->load->view($this->module.'/v_kriteria_edit', $tpl);
		}
	}

	function delete($idx)
	{
		restrict('refrensi/Kriteria/delete', TRUE);
		$id = decode($idx);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($rs = $this->M_kriteria->DeleteKriteria($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus Kriteria berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus Kriteria gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Alkes.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\alkes\controllers\Alkes.php */