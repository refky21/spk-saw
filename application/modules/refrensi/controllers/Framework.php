<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Framework extends Dashboard_Controller {

	var $module = 'refrensi';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_pemrograman');
		$this->load->model($this->module.'/M_framework');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Framework';
		$tpl['roleAdd']    = restrict('refrensi/Framework/add', TRUE);
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$tpl['bahasa'] = $this->M_framework->ListPemrograman()->result_array();
			// var_dump($tpl);die;
		$this->template->title('Data Framework');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Framework' , '' );
		$this->template->build($this->module.'/v_fw_index', $tpl);
	}

	public function ajax_datatables()
	{
		restrict('refrensi/Framework/ajax_datatables', TRUE);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Framework';
		$columns = array(
			1 => 'pemNama',
			2 => 'fwNama',
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['fwNama'] = $this->input->post('filter_key');
		}
		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$qry = $this->M_framework->list_framework($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_framework->list_framework($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'refrensi/Framework/update', TRUE);
			$roleDelete = restrict( 'refrensi/Framework/delete', TRUE);
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
				
				$records["data"][] = array(
				$no++,
				$row['nama'],
				$row['pemrograman'],
				$editLink.' '. $deleteLink
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
		restrict('refrensi/Framework/add', TRUE);
		$tpl['module']  = $this->module.'/Framework';

		$this->form_validation->set_rules('pemrograman', 'Bahasa Pemrograman', 'required');
		$this->form_validation->set_rules('framework', 'Framework', 'required');
		if ($this->form_validation->run()) {
			$params = array(
				'fwNama' => $this->input->post('framework'),
				'fwPmId' => $this->input->post('pemrograman'),
			);

			$proses = $this->M_framework->insertdata($params,'ref_framework');
			// var_dump($)
			if ($proses) {
            	$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Framework berhasil ditambahkan.');
			} else {
				$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Framework gagal ditambahkan.');
			}
		}else {
        	$result = array('error' => array('nambar' => form_error('nambar')));
    	}
		echo json_encode($result);
	}

	public function update($idx)
	{
		$id = decode($idx);
		// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post('action') == 'submit') {
			$this->form_validation->set_rules('framework', 'Framework', 'required');
			$this->form_validation->set_rules('pemrograman', 'Bahasa Pemrograman', 'required');
	
				if ($this->form_validation->run()) {
					$params = array(
						'fwNama' => $this->input->post('framework'),
						'fwPmId' => $this->input->post('pemrograman'),
						'id' => decode($this->input->post('id')),
					);
					$proses = $this->M_framework->updatedata($params);
	
					// var_dump($proses);die;
					if ($proses) {
						$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Framework berhasil perbarui.');
					} else {
						$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Framework gagal diubah.');
					}
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
				} else {
					$result = array('error' => array('nama' => form_error('nama')));
					echo json_encode($result);
				}
			}else{
				$tpl['module']  = $this->module.'/Framework';
				$tpl['data']   = $this->M_framework->getData($id)->row_array();
				$tpl['bahasa'] = $this->M_framework->ListPemrograman()->result();
				$this->load->view($this->module.'/v_fw_edit', $tpl);
			}
		// var_dump($id);die;
	}


	public function delete($idx)
	{
		restrict('refrensi/Framework/delete', TRUE);
		$id = decode($idx);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($rs = $this->M_framework->deletedata($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus Kriteria berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus Kriteria gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Framework.php */
/* Location: D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\refrensi\controllers\Framework.php */