<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Alkes extends Dashboard_Controller {
	
	var $module = 'alkes';
	
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_alkes');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Alkes';
		$tpl['roleAdd']    = restrict('alkes/Alkes/add', TRUE);
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Master Barang');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Barang' , '' );
		$this->template->build($this->module.'/v_alkes_index', $tpl);
	}


	function read()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Pelanggan';
		// $rs = restrict('home');
			// $restrict = restrict( 'site/Posting/delete', TRUE);
		$columns = array(
			1 => 'alkesId',
			2 => 'alkesKodeBarang',
			3 => 'alkesNamaBarang',
			4 => 'alkesHargaDasar'
		);
		$object = array();
		if($this->input->post('filter_key') != ''){
			$object['alkesNamaBarang'] = $this->input->post('filter_key');
		}
		$order = array();
		if($this->input->post('order')){
			foreach( $this->input->post('order') as $row => $val){
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}
		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$qry = $this->M_alkes->list_alkes($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_alkes->list_alkes($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'alkes/Alkes/update', TRUE);
			$roleDelete = restrict( 'alkes/Alkes/delete', TRUE);
			foreach($qry->result_array() as $row){
				// Button
				if($roleEdit == TRUE){
					$editLink = '<a id="edit-btn" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Edit Barang"> <i class="fa fa-pencil"></i> </a>';
				}else{
					$editLink = "";
				}

				if($roleDelete == TRUE){
					$deleteLink = '<a id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" data-id="'.$row['id'].'" title="Hapus Barang"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}
				// Status
				$stts = ($row['Status'] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Tidak</span>';

				$records["data"][] = array(
				$no++,
				$row['KodeBarang'],
				$row['nama'],
				'Rp. '. number_format($row['HargaDasar'],0,',','.'),
				$row['keterangan'],
				$stts,
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
		restrict('alkes/Alkes/add', TRUE);

	$tpl['module']  = $this->module.'/Alkes';
	
	$this->form_validation->set_rules('alkesKodeBarang', 'Kode Barang', 'required');
	$this->form_validation->set_rules('alkesNamaBarang', 'Nama Barang', 'required');
	$this->form_validation->set_rules('alkesHargaDasar', 'Harga Dasar', 'required');

		if ($this->form_validation->run()) {
			$harga = str_replace('.','',$this->input->post('alkesHargaDasar')) ;
			$params = array(
				'alkesKodeBarang' => $this->input->post('alkesKodeBarang'),
				'alkesNamaBarang' => $this->input->post('alkesNamaBarang'),
				'alkesHargaDasar' => $harga,
				'alkesKeterangan' => $this->input->post('alkesKeterangan'),
				'alkesIsAktif' => $this->input->post('alkesIsAktif'),
				'alkesTglInsert' => date('Y-m-d H:i:s'),
				'alkesInsertUser' => get_user_name(),
			);

				$proses = $this->M_alkes->insertAlkes($params);
			if ($proses) {
            	$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data Alkes berhasil ditambahkan.');
			} else {
				$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data Alkes gagal ditambahkan.');
			}
		}else {
        	$result = array('error' => array('nambar' => form_error('nambar')));
    	}
		echo json_encode($result);
	}

	public function update($id)
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		if ($this->input->post('action') == 'submit') {
		$this->form_validation->set_rules('alkesKodeBarang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('alkesNamaBarang', 'Nama Barang', 'required');
		$this->form_validation->set_rules('alkesHargaDasar', 'Harga Dasar', 'required');

			if ($this->form_validation->run()) {
				$harga = str_replace('.','',$this->input->post('alkesHargaDasar')) ;
				$params = array(
					'alkesKodeBarang' => $this->input->post('alkesKodeBarang'),
					'alkesNamaBarang' => $this->input->post('alkesNamaBarang'),
					'alkesHargaDasar' => $harga,
					'alkesKeterangan' => $this->input->post('alkesKeterangan'),
					'alkesIsAktif' => $this->input->post('alkesIsAktif'),
					'alkesTglUpdate' => date('Y-m-d H:i:s'),
					'alkesUpdateUser' => get_user_name(),
				);
				$proses = $this->M_alkes->UpdateAlkes($id,$params);
				if ($proses) {
					$result = array('error' => 'null', 'status' => true, 'type' => 'success', 'text' => 'Data barang berhasil perbarui.');
				} else {
					$result = array('error' => 'null', 'status' => false, 'type' => 'danger', 'text' => 'Data barang gagal diubah.');
				}
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
			} else {
				$result = array('error' => array('nama' => form_error('nama')));
				echo json_encode($result);
        	}
		}else{
			$tpl['module']  = $this->module.'/Alkes';
			$tpl['data']   = $this->M_alkes->GetDetailAlkes($id);
			$this->load->view($this->module.'/v_alkes_edit', $tpl);
		}
	}

	function delete($id)
	{
		restrict('alkes/Alkes/delete', TRUE);
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');

		if ($rs = $this->M_alkes->DeleteAlkes($id)) {
			$result = array('status' => true, 'type' => 'success', 'text' => 'Proses hapus Barang berhasil.');
		} else {
			$result = array('status' => false, 'type' => 'danger', 'text' => 'Maaf, Proses hapus Barang gagal.');
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}


/* End of file Alkes.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\alkes\controllers\Alkes.php */