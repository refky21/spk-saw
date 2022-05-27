<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends Dashboard_Controller {
	
	var $module = 'pelanggan';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_plgn');
	}

	function index()
	{
		$tpl['module']    = $this->module.'/Pelanggan';
		$tpl['roleAdd']    = restrict('pelanggan/Pelanggan/add', TRUE);
		$tpl['listKat']    =$this->M_plgn->list_type();
		$tpl['listProp']    =$this->M_plgn->list_prop();

		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Pelanggan');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Pelanggan' , '' );
		$this->template->build($this->module.'/v_plgn_index', $tpl);
	}

	public function read()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Pelanggan';

		$columns = array(
			1 => 'plgnId',
			2 => 'plgnNama',
			3 => 'plgnContact',
			4 => 'plgnHp'
		);

		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['plgnNama'] = $this->input->post('filter_key');
		}

		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$qry = $this->M_plgn->list_plgn($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_plgn->list_plgn($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));

		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'pelanggan/Pelanggan/update', TRUE);
			$roleDelete = restrict( 'pelanggan/Pelanggan/delete', TRUE);
			foreach($qry->result_array() as $row){
				if($roleEdit == TRUE){
					$editLink = '<a id="edit-btn" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Edit Pelanggan"> <i class="fa fa-pencil"></i> </a>';
				}else{
					$editLink = "";
				}
				if($roleDelete == TRUE){
					$deleteLink = '<a id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Hapus Pelanggan"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}


				$records["data"][] = array(
				$no++,
				$row['Kategory'],
				$row['nama'],
				$row['PenanggungJawab'],
				$row['hp'],
				$row['Alamat'],
				$editLink.' '. $deleteLink
				);
			}
		}
		
		$records["draw"] = $sEcho;
		$records["recordsTotal"] = $iTotalRecords;
		$records["recordsFiltered"] = $iTotalRecords;

		echo json_encode($records);

	}

	public function ajax_kabupaten()
	{
		$propId = $this->input->post('id');
		$data = $this->M_plgn->get_kabupaten($propId);

		echo json_encode($data);

	}

	public function add()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$this->form_validation->set_rules('nama', 'Nama Pelanggan', 'trim|required');
		$this->form_validation->set_rules('penanggung_jawab', 'Nama Penanggung Jawab', 'trim|required');
    	$this->form_validation->set_error_delimiters('', '');
		if ($this->form_validation->run()) {
			$proses = $this->M_plgn->InsertPelanggan(array('pelanggan' => $this->input->post('nama'),
						'penanggung_jawab' => $this->input->post('penanggung_jawab'),
						'hp' => $this->input->post('hp'),
						'plgnKabId' => $this->input->post('kabupaten'),
						'plgnKategoriId' => $this->input->post('kat_plgn'),
						'alamatPlgn' => $this->input->post('alamatPlgn')
						));
						
			if ($proses) {
            	$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data bank berhasil ditambahkan.');
			} else {
				$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data bank gagal ditambahkan.');
			}

		} else {
        	$result = array('error' => array('nama' => form_error('nama')));
    	}

		echo json_encode($result);
	}
	
	public function update($id)
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post('action') == 'submit') {

			// $this->form_validation->set_rules('kat_plgn', 'Kategori Pelanggan', 'required');
			// $this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('hp', 'Nomor Handphone', 'required|numeric');
	
			// if ($this->form_validation->run()) {
				$params = array(
					'plgnNama' => $this->input->post('nama'),
					'plgnHp' => $this->input->post('hp'),
					'plgnAlamat' => $this->input->post('alamatPlgn'),
					'plgnContact' => $this->input->post('penanggung_jawab'),
					'plgnKategoriId' => $this->input->post('kat_plgn'),
					'plgnTglEdit' => date('Y-m-d H:i:s'),
					'plgnEditUser' => get_user_name(),
				);
				$proses = $this->M_plgn->updatePelanggan($id,$params);
				if ($proses) {
					$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data pelanggan berhasil perbarui.');
				} else {
					$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data pelanggan gagal diubah.');
				}
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			// } else {
			// 	$result = array('error' => array('nama' => form_error('nama')));
			// 	echo json_encode($result);
			// }

		}else{
			$tpl['module']  = $this->module.'/Pelanggan';
			$tpl['data']   = $this->M_plgn->GetDetailPelanggan($id);
			$tpl['listKat']    =$this->M_plgn->list_type();
			$tpl['listProp']    =$this->M_plgn->list_prop();
			$this->load->view($this->module.'/v_plgn_edit', $tpl);
		}
	}


	function delete($id)
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($rs = $this->M_plgn->DeletePelanggan($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus bank berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus bank gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Alkes.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\alkes\controllers\Alkes.php */