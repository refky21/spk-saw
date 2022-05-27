<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftaralat extends Dashboard_Controller {
	
	var $module = 'list_alat';

	function __construct() 
	{
		parent::__construct();
		//Do your magic here

		restrict();
		$this->load->model($this->module.'/M_list_alat');
		$this->load->model('transaksi/M_berita');
	}


	public function index()
	{
		restrict('list_alat/Daftaralat/index', TRUE);
		$tpl['module']    = $this->module.'/Daftaralat';
		$tpl['roleAdd']    = restrict('list_alat/Daftaralat/print', TRUE);
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

		$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Daftar Alat');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Daftar Alat' , '' );
		$this->template->build($this->module.'/v_daftar_alat_index', $tpl);

		// echo 'Hallo';
	}

	public function read()
	{
		// if ($this->input->is_ajax_request()) exit('No direct access allowed');

		$module = $this->module.'/Alat_kalibrasi';

		$columns = [
			1 => 'pmtId',
			2 => 'alkesKodeBarang',
			3 => 'alkesNamaBarang'
		];

		$object = [];
		if ($this->input->post('filter_key') != '') {
			$object['pmtId'] = $this->input->post('filter_key');
		}

		if(get_user_id() != 1){
			$object['ptTeknisiId'] = get_user_id();
        }

		$order = [];
		if ($this->input->post('order')) {
			foreach($this->input->post('order') as $row => $val) {
				$order[$columns[$val['column']]] = $val['dir'];
			}
		}

		$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
		$query = $this->M_list_alat->list_permintaan($object, $length, $this->input->post('start'), $order);
		$iTotalRecords = (!is_null($query)) ? intval($this->M_list_alat->list_permintaan($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));

		$records = [];
		$records ['data'] = [];
		if (!is_null($query)) {
			$no = $iDisplayStart + 1;
			$roleCetak = restrict('list_alat/Daftaralat/cetak', TRUE);

			foreach($query->result_array() as $row) {

				if($roleCetak == TRUE){
					$SuratLink = '<a href="'.site_url($this->module).'/Daftaralat/cetak/'.encode($row['id']).'" class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Cetak List Alat"> <i class="ti-printer"></i> </a>';
				}else{
					$SuratLink = "";
				}


				$btn = $SuratLink;

				$records['data'] [] = [
					$no++,
					$row['NamaPelanggan'],
					$row['NomorOrder'],
					$btn
				];
			}
		}

		$records['draw'] = $sEcho;
		$records['recordsTotal'] = $iTotalRecords;
		$records['recordsFiltered'] = $iTotalRecords;

		echo json_encode($records);
	}


	public function cetak($idx)
	{
		$id = decode($idx);
		$tpl['title']		= 'Cetak Dokumen';
		$tpl['status']	= $this->M_berita->status_kalibrasi();
		$tpl['berita']	= $this->M_berita->getPermintaan($id);
		$tpl['alkes']		= $this->M_berita->getPmtCetak($id)->result_array();
		// $tpl['alkes']		= $this->M_berita->getPmtAlkes($id)->result_array();
		$tpl['jumlah']	= $this->M_berita->Jumlah($id);

		$dt = $this->M_berita->getPmtCetak($id)->result_array();

		$this->template->set_layout('layout_blank')
						->set_partial('modules_js','modules_js')
						->set_partial('modules_css','modules_css');

		$this->template->build($this->module. '/v_alat_cetak', $tpl);
	}


	public function search()
	{
		// if ($this->input->is_ajax_request()) exit('No direct access allowed');
		restrict('list_alat/Daftaralat/search', TRUE);
		$key = $this->input->post();
		$client = $this->M_list_alat->getPelanggan($key);
		echo json_encode($client);
	}
	
	
}


/* End of file Daftaralat.php */
/* Location: D:\xampp\htdocs\apps\uad\amk\application\modules\list_alat\controllers\Daftaralat.php */