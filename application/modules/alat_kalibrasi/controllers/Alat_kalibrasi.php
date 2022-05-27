<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Alat_kalibrasi extends Dashboard_Controller {

	var $module = 'alat_kalibrasi';

	function __construct() 
	{
		parent::__construct();
		//Do your magic here

		restrict();
		$this->load->model($this->module.'/M_alatKalibrasi');
	}

	function index() {

		$tpl['module']    = $this->module.'/Alat_kalibrasi';
		$tpl['roleAdd']    = restrict('alat_kalibrasi/Alat_kalibrasi/add', TRUE);
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Alat Kalibrasi');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Alat Kalibrasi' , '' );
		$this->template->build($this->module.'/v_alat_kalibrasi_index', $tpl);
	}

	function datatables_alatKalibrasi() {

		// if ($this->input->is_ajax_request()) exit('No direct access allowed');

		$module = $this->module.'/Alat_kalibrasi';

		$columns = [
			1 => 'alatId',
			2 => 'alatKode',
			3 => 'alatNama',
			4 => 'alatKeterangan',
			5 => 'alatIsAktif'
		];

		$object = [];
		if ($this->input->post('filter_key') != '') {
			$object['alatNama'] = $this->input->post('filter_key');
		}

		$order = [];
		if ($this->input->post('order')) {
			foreach($this->input->post('order') as $row => $val) {
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$query = $this->M_alatKalibrasi->list_alatKalibrasi($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($query)) ? intval($this->M_alatKalibrasi->list_alatKalibrasi($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));

		$records = [];
		$records ['data'] = [];
		if (!is_null($query)) {
			$no = $iDisplayStart + 1;
			$roleEdit = restrict('alat_kalibrasi/Alat_kalibrasi/update', TRUE);
			$roleDelete = restrict('alat_kalibrasi/Alat_kalibrasi/delete', TRUE);
			foreach($query->result_array() as $row) {

				if ($roleEdit == TRUE) {

					$editlink = '<a id="edit-btn" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Edit alat kalibrasi"> <i class="fa fa-pencil"></i> </a>';
				} else {

					$editlink = "";
				}

				if ($roleDelete == TRUE) {
					$deletelink = '<a id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Hapus alat kalibrasi"> <i class="ti-trash"></i> </a>';
				} else {
					$deletelink = "";
				}

				$status = ($row['status'] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>';

				$records['data'] [] = [
					$no++,
					$row['kode'],
					$row['nama'],
					$row['merk'],
					$row['noSeri'],
					$row['keterangan'],
					$status,
					$editlink.'|'. $deletelink
				];
			}
		}

		$records['draw'] = $sEcho;
		$records['recordsTotal'] = $iTotalRecords;
		$records['recordsFiltered'] = $iTotalRecords;

		echo json_encode($records);
	}

	function add() {

		restrict('alat_kalibrasi/Alat_kalibrasi/add', TRUE);

		$tpl['module']  = $this->module.'/Alat_kalibrasi';
	
		$this->form_validation->set_rules('kode', 'Kode Alat', 'required|numeric');
		$this->form_validation->set_rules('nama', 'Nama', 'required');
	
			if ($this->form_validation->run()) {

				$params = [
					'alatKode' => $this->input->post('kode'),
					'alatNama' => $this->input->post('nama'),
					'alatMerk' => $this->input->post('merk'),
					'alatNoSeri' => $this->input->post('no_seri'),
					'alatKeterangan' => $this->input->post('keterangan'),
					'alatIsAktif' => $this->input->post('alatKalibrasiIsAktif'),
					'alatTglInsert' => date('Y-m-d H:i:s'),
					'alatInsertUser' => get_user_name(),
				];

				$proses = $this->M_alatKalibrasi->addAlatKalibrasi($params);

				if ($proses) {
					$result = [
						'error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Alat Kalibrasi berhasil ditambahkan.'
					];
				} else {
					$result = [
						'error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Alat Kalibrasi gagal ditambahkan.'
					];
				}

			} else {
				$result = ['error' => ['nambar' => form_error('nambar')]];
			}

			echo json_encode($result);
	}

	function update($id) {

		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($this->input->post('action') == 'submit') {

			$this->form_validation->set_rules('kode', 'Kode Alat', 'required|numeric');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
	
			if ($this->form_validation->run()) {
				$params = array(
					'alatKode' => $this->input->post('kode'),
					'alatNama' => $this->input->post('nama'),
					'alatMerk' => $this->input->post('merk'),
					'alatNoSeri' => $this->input->post('no_seri'),
					'alatKeterangan' => $this->input->post('keterangan'),
					'alatIsAktif' => $this->input->post('alatKalibrasiIsAktif'),
					'alatTglEdit' => date('Y-m-d H:i:s'),
					'alatEditUser' => get_user_name(),
				);
				$proses = $this->M_alatKalibrasi->updateAlatKalibrasi($id,$params);
				if ($proses) {
					$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Alat Kalibrasi berhasil perbarui.');
				} else {
					$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Alat Kalibrasi gagal diubah.');
				}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else {
				$result = array('error' => array('nama' => form_error('nama')));
				echo json_encode($result);
					}
		}else{
			$tpl['module']  = $this->module.'/Alat_kalibrasi';
			$tpl['data']   = $this->M_alatKalibrasi->detailAlatKalibrasi($id);
			$this->load->view($this->module.'/v_alat_kalibrasi_update', $tpl);
		}
	}

	function delete($id)
	{
		restrict('alat_kalibrasi/Alat_kalibrasi/delete', TRUE);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($this->M_alatKalibrasi->DeleteAlatKalibrasi($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus Alat Kalibrasi berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus Alat Kalibrasi gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Alat_kalibrasi.php */
/* Location: D:\xampp\htdocs\uad\si-amk\application\modules\alat_kalibrasi\controllers\Alat_kalibrasi.php */