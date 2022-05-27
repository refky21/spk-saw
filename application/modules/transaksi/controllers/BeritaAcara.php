<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class BeritaAcara extends Dashboard_Controller {

	var $module = 'transaksi';

	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_berita');
		$this->load->helper($this->module.'/berita');
		$this->load->model('permintaan/M_permintaan');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/BeritaAcara';


		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$this->template->title('Berita Acara');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Berita Acara' , '' );
		$this->template->build($this->module.'/v_berita_index', $tpl);

	}

	public function ajax_datatables($type='berita',$idx='')
	{
		// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = decode($idx);
		$module = $this->module.'/BeritaAcara';

		if($type=='berita'){
					$columns = array(
						1 => 'pmtId',
						2 => 'pmtPelangganId',
						3 => 'pmtTglPengajuan'
					);
					$object = array();
					if($this->input->post('filter_key') != ''){
						$fil = $this->input->post('filter_key');
						$fils = explode(".",$fil);
						$filter = $fils[0];
						if($filter == is_numeric($fils[0]) ){
							$object['pmtNoOrder'] = $fil;
						}else{
							$object['plgnNama'] = $fil;
						}
						
					}

				
					$order = array();
					if($this->input->post('order')){
						foreach( $this->input->post('order') as $row => $val){
							$order[$columns[$val['column']]] = $val['dir'];
						}
					}


					$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

					$qry = $this->M_berita->list_prmnt($object, $length, $this->input->post('start'), $order,NULL,get_user_id());
					$iTotalRecords = (!is_null($qry)) ? intval($this->M_berita->list_prmnt($object, NULL, NULL, NULL, 'counter')) : 0;
					$iDisplayStart = intval($this->input->post('start'));
					$sEcho = intval($this->input->post('draw'));
					$records = array();
					$records["data"] = array();
					if(!is_null($qry)){
						$no = $iDisplayStart + 1;
						$roleProses = restrict( 'transaksi/BeritaAcara/proses', TRUE);
						$roleCetak = restrict( 'transaksi/BeritaAcara/cetak', TRUE);
						foreach($qry->result_array() as $row){
							// Button
							
							if($roleProses == TRUE){
								$BeritaLink = '<a href="'.site_url($this->module).'/BeritaAcara/data/'.encode($row['id']).'" class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Proses"> <i class="ti-reload"></i> </a>';
							}else{
								$BeritaLink = "";
							}
							
							if($roleCetak == TRUE){
								$CetakLink = '<a target="_blank" href="'.site_url($this->module).'/BeritaAcara/cetak/'.encode($row['id']).'" target="_blank" class="btn btn-square btn-purple text-white table-action"  data-provide="tooltip" title="Cetak"> <i class="ti-printer"></i> </a>';
							}else{
								$CetakLink = "";
							}
							$btn = $CetakLink.' '.$BeritaLink;

							
							$tgl = ($row['TanggalPermintaan'] != NULL) ? IndonesianDate($row['TanggalPermintaan']) : '';
							$kunjungan = ($row['TglKunjung'] != 0000-00-00) ? IndonesianDate($row['TglKunjung']) : '';
							$realisasi = ($row['TglRealisasi'] != NULL) ? IndonesianDate($row['TglRealisasi']) : '';
							// var_dump($row['TglKunjung']);die;
							
							$records["data"][] = array(
							$no++,
							"<b>".$row['NoOrder']."</b>",
							$row['NamaPelanggan'],
							$row['NamaPj'],
							'<span class="badge badge-success">'.$row['StatusPermintaan']. '</span>',
							($row['totdtPermintaan'] > 0) ? '<a id="btnList" data-provide="tooltip" href="#" data-url="'.site_url($this->module .'/BeritaAcara/list_alat/'.encode($row['id'])).'" title="List Alat">'.$row['totdtPermintaan'].'</a> ' : $row['totdtPermintaan'],
							$tgl,
							$kunjungan,
							$realisasi,
							$btn
							);
						}
					}
					$records["draw"] = $sEcho;
					$records["recordsTotal"] = $iTotalRecords;
					$records["recordsFiltered"] = $iTotalRecords;

					echo json_encode($records);
		}else if($type == 'proses'){
				$columns = array(
						1 => 'pdaId',
						2 => 'pdaPermintaanDetailId',
						3 => 'pmtdtPermintaanId'
					);
					$dat = array();
					$data = $this->M_berita->list_detail_alkes($id)->result_array();

					foreach($data as $i => $dt){
						$dat[$i] = $dt['id'];
					}
					$object = array();

					$in = $dat;

					$order = array();
					if($this->input->post('order')){
						foreach( $this->input->post('order') as $row => $val){
							$order[$columns[$val['column']]] = $val['dir'];
						}
					}

					$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

					$qry = $this->M_berita->list_alkes($object, $length, $this->input->post('start'), $order,NULL,$in);
					// var_dump($qry->result_array());die;
					$iTotalRecords = (!is_null($qry)) ? intval($this->M_berita->list_alkes($object, NULL, NULL, NULL, 'counter',$in)) : 0;
					$iDisplayStart = intval($this->input->post('start'));
					$sEcho = intval($this->input->post('draw'));
					$records = array();
					$records["data"] = array();
					if(!is_null($qry)){
						$no = $iDisplayStart + 1;
						$roleProses = restrict( 'transaksi/BeritaAcara/proses', TRUE);
						foreach($qry->result_array() as $row){
							// Button
							
							if($roleProses == TRUE){
								$BeritaLink = '<a href="'.site_url($this->module).'/BeritaAcara/proses/'.encode($row['id']).'/'.$idx.'" id="btnProses" class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Proses"> <i class="ti-reload"></i> </a>';
							}else{
								$BeritaLink = "";
							}
						
							$btn = $BeritaLink;
							
							$records["data"][] = array(
							($row['Merk'] != NULL) ? '<input type="checkbox" name="id[]" value="'. $row['id'] .'">' : '',
							$no++,
							$row['NamaAlkes'],
							$row['Merk'],
							$row['Tipe'],
							$row['NoSeri'],
							$row['LokasiAlat'],
							'<span class="badge badge-'.$row['Class']. '">'.$row['Status']. '</span>',
							// ($row['totdtPermintaan'] > 0) ? '<a id="btnList" data-provide="tooltip" href="#" data-url="'.site_url($this->module .'/BeritaAcara/list_alat/'.encode($row['id'])).'" title="List Alat">'.$row['totdtPermintaan'].'</a> ' : $row['totdtPermintaan'],
							$btn
							);
						}
					}
					$records["draw"] = $sEcho;
					$records["recordsTotal"] = $iTotalRecords;
					$records["recordsFiltered"] = $iTotalRecords;

					echo json_encode($records);

		}
		
	}

	public function data($idx)
	{
		$id = decode($idx);
		restrict( 'transaksi/BeritaAcara/data', TRUE);
		$tpl['module'] = $this->module.'/BeritaAcara';
		$tpl['roleProses'] = restrict( 'transaksi/BeritaAcara/proses', TRUE);
		$tpl['roleAddProses'] = restrict( 'transaksi/BeritaAcara/add_proses', TRUE);;
		$tpl['idx'] = $idx;

			$tpl['pmt'] = $this->M_permintaan->get_detail_permintaan($id)->row_array();
			$tpl['dtpmt'] = $this->M_berita->list_detail_alkes($id)->result_array();

			$pmtdtAlat = $this->M_berita->getPmtAlkes($id)->result_array();
			$tpl['Detail'] = $pmtdtAlat;
			$tpl['stKali'] = $this->M_berita->list_ref_status_kalibrasi()->result_array();
			

			$this->template->inject_partial('modules_css', multi_asset( array(
				'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
				), 'css' ) );

			$this->template->inject_partial('modules_js', multi_asset( array(
				'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
				'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
				), 'js' ) );

			$this->template->title('Berita Acara');
			$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
			$this->template->set_breadcrumb( 'Proses' , '' );
			$this->template->build($this->module.'/v_berita_proses', $tpl);
		
	}

	public function proses($idx,$pmt)
	{
		$id = decode($idx);
		restrict( 'transaksi/BeritaAcara/proses', TRUE);
		$tpl['module'] = $this->module.'/BeritaAcara';
		$tpl['idx'] = $idx;

		$this->form_validation->set_rules('no_seri', 'Nomor Seri', 'required');
		if ($this->form_validation->run() == TRUE) {

			if( empty($this->input->post('no_seri')) ){
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Nomor Seri Wajib Disi'));
				redirect(site_url($tpl['module'].'/data/'.$pmt));
			}elseif( empty($this->input->post('tipe_alat')) ){
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Tipe Alat Wajib Disi'));
				redirect(site_url($tpl['module'].'/data/'.$pmt));
			}
				$params = array(
					'pdaMerk' => $this->input->post('merk'),
					'pdaTipe' => $this->input->post('tipe_alat'),
					'pdaNoSeri' => $this->input->post('no_seri'),
					'pdaNoSertifikat' => $this->input->post('no_sertifikat'),
					'pdaLokasiALat' => $this->input->post('lokasi_alat'),
					'pdaStatusKalibrasi' => $this->input->post('status'),
					'pdaCatatanKalibrasi' => $this->input->post('catatan'),
					'pdaJamMulaiKalibrasi' => $this->input->post('jam_mulai'),
					'pdaJamSelesaiKalibrasi' => $this->input->post('jam_selesai'),
				);
				// var_dump($params);die;
				$rs = $this->M_berita->update_berita($params,$id);
				$rs = true;
				if ($rs) {
					$status = array(
						"StatusId" => 3,
						"pmtId" => decode($pmt)
					);
					// var_dump($status);die;
					$update_status = $this->M_berita->update_status_permintaan($status);

					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Ubah Berita Acara berhasil.'));
				} else {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Ubah Berita Acara gagal.'));
				}
				redirect(site_url($tpl['module'].'/data/'.$pmt));
			}

			$tpl['dtPmtAlat'] = $this->M_berita->permintaan_detail_alats($id);
			$tpl['stKali'] = $this->M_berita->list_ref_status_kalibrasi()->result_array();
			$this->load->view($this->module . '/v_berita_mdl_form', $tpl);
			// var_dump($tpl['dtPmtAlat']);
	}


	public function add_proses($idx)
	{
		// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = decode($idx);
		restrict( 'transaksi/BeritaAcara/add_proses', TRUE);
		$tpl['module'] = $this->module.'/BeritaAcara';
		$tpl['idx'] = $idx;
		$this->form_validation->set_rules('alat_tambahan', 'Alat Tambahan', 'required');
		if ($this->form_validation->run() == TRUE) {
			$cek = $this->M_berita->get_list_permintaan_detail($this->input->post('alat_tambahan'))->row_array();
				// cek datanya dulu
				$jml = $cek['JumlahAlat'] + 1;
				$jmlHarga = $jml * $cek['HargaDasar'];

				$params = array(
					'pdaMerk' => $this->input->post('merk'),
					'pdaTipe' => $this->input->post('tipe_alat'),
					'pdaNoSeri' => $this->input->post('no_seri'),
					'pdaLokasiALat' => $this->input->post('lokasi_alat'),
					'pdaStatusKalibrasi' => $this->input->post('status'),
					'pdaCatatanKalibrasi' => $this->input->post('catatan'),
					'pdaJamMulaiKalibrasi' => $this->input->post('jam_mulai'),
					'pdaJamSelesaiKalibrasi' => $this->input->post('jam_selesai'),
					'pdaPermintaanDetailId' => $this->input->post('alat_tambahan'),
					'pmtdtHarga' => $jmlHarga,
					'pmtdtJumlahAlat' => $jml
				);

				$update_insert = $this->M_berita->upin_alat_detail($params);
				if ($update_insert) {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Ubah Berita Acara berhasil.'));
				} else {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Ubah Berita Acara gagal.'));
				}
				redirect(site_url($tpl['module'].'/data/'.$idx));
			


		}
	}

	public function list_alat($idx)
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = decode($idx);
		
		$tpl['alkes'] = $this->M_berita->list_alkes_det($id)->result_array();
		$this->load->view($this->module . '/v_berita_list', $tpl);
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

		$this->template->build($this->module. '/v_berita_cetak', $tpl);
	}

	public function print_kartu()
	{
		$tpl['module'] = $this->module.'/BeritaAcara';

		
		
		if ($this->input->is_ajax_request()){
			$params = $this->input->post('params');
			foreach($params as $i=> $val){
				$data[$i] = encode($val);
			}

			$query = http_build_query(array('data' => $data));
			$uri = site_url($tpl['module'].'/print_kartu?'.$query);
			$result = array('status' => TRUE, 'msg' => 'Proses verifikasi berhasil.','url'=> $uri);
			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}else{

			$par = $this->input->get('data');
			foreach($par as $i=> $val){
				$data[$i] = decode($val);
			}

			$tpl['data']= $data;


			$this->template->set_layout('layout_blank')
						->set_partial('modules_js','modules_js')
						->set_partial('modules_css','modules_css');

			$this->template->build($this->module. '/v_berita_cetak_kartu', $tpl);
			
			// var_dump($data);
		}
		
	}

}


/* End of file BeritaAcara.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\transaksi\controllers\BeritaAcara.php */