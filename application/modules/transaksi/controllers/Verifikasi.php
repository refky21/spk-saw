<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends Dashboard_Controller {

	var $module = 'transaksi';
	var $folder = 'transaksi/verifikasi';
	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_berita');
		$this->load->model($this->module.'/M_verifikasi');
		$this->load->model('permintaan/M_permintaan');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Verifikasi';
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$this->template->title('Verifikasi');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Verifikasi' , '' );
		$this->template->build($this->module.'/verifikasi/v_verifikasi_index', $tpl);
	}

	public function datatables_ajax($type='data',$idx='')
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id=decode($idx);
		$module = $this->module.'/Verifikasi';
		if($type=='data'){
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

					$qry = $this->M_verifikasi->list_data($object, $length, $this->input->post('start'), $order);
					$iTotalRecords = (!is_null($qry)) ? intval($this->M_verifikasi->list_data($object, NULL, NULL, NULL, 'counter')) : 0;
					$iDisplayStart = intval($this->input->post('start'));
					$sEcho = intval($this->input->post('draw'));
					$records = array();
					$records["data"] = array();
					if(!is_null($qry)){
						$no = $iDisplayStart + 1;
						$roleProses = restrict( 'transaksi/Verifikasi/proses', TRUE);
						// $roleCetak = restrict( 'transaksi/Verifikasi/cetak', TRUE);
						foreach($qry->result_array() as $row){
							// Button
							if($roleProses == TRUE){
								$BeritaLink = '<a href="'.site_url($this->module).'/Verifikasi/data/'.encode($row['id']).'" class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" title="Verifikasi Alat"> <i class="ti-check-box"></i> </a>';
								$Verifikasi = '';
								// $Verifikasi = '<a id="btnVerifikasi" href="'.site_url($this->module).'/Verifikasi/proses/vis/'.encode($row['id']).'" class="btn btn-square btn-purple text-white table-action"  data-provide="tooltip" title="Verifikasi Status Layanan"> <i class="ti-check-box"></i> </a>';
							}else{
								$BeritaLink = "";
								$Verifikasi = "";
							}

						
							
							$btn = $Verifikasi.'&nbsp;'.$BeritaLink;

							
							$tgl = ($row['TanggalPermintaan'] != NULL) ? IndonesianDate($row['TanggalPermintaan']) : '';
							$kunjungan = ($row['TglKunjung'] != NULL) ? IndonesianDate($row['TglKunjung']) : '';
							$realisasi = ($row['TglRealisasi'] != NULL) ? IndonesianDate($row['TglRealisasi']) : '';
							
							
							$records["data"][] = array(
								
							$no++,
							"<b>".$row['NoOrder']."</b>",
							$row['NamaPelanggan'],
							$row['NamaPj'],
							'<span class="badge badge-'.$row['stClass']. '">'.$row['StatusPermintaan']. '</span>',
							($row['totdtPermintaan'] > 0) ? '<a id="btnList" data-provide="tooltip" href="#" data-url="'.site_url($this->module .'/Verifikasi/list_alat/'.encode($row['id'])).'" title="List Alat">'.$row['totdtPermintaan'].'</a> ' : $row['totdtPermintaan'],
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
		}elseif($type="alkes"){
			$columns = array(
						2 => 'pdaId',
						3 => 'pdaPermintaanDetailId',
						4 => 'pmtdtPermintaanId'
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

					$qry = $this->M_verifikasi->list_alkes($object, $length, $this->input->post('start'), $order,NULL,$in);
					// var_dump($qry->result_array());die;
					$iTotalRecords = (!is_null($qry)) ? intval($this->M_verifikasi->list_alkes($object, NULL, NULL, NULL, 'counter',$in)) : 0;
					$iDisplayStart = intval($this->input->post('start'));
					$sEcho = intval($this->input->post('draw'));
					$records = array();
					$records["data"] = array();
					if(!is_null($qry)){
						$no = $iDisplayStart + 1;
						$roleProses = restrict( 'transaksi/Verifikasi/proses', TRUE);
						foreach($qry->result_array() as $row){
							// Button
							
							if($roleProses == TRUE){
								$BeritaLink = '<a href="'.site_url($this->module).'/Verifikasi/proses/edit/'.encode($row['id']).'/'.$idx.'" id="btnProses" class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Edit"> <i class="ti-pencil"></i> </a>';
							}else{
								$BeritaLink = "";
							}
						
							$btn = $BeritaLink;
							
							$records["data"][] = array(
								($row['StatusVerifikasi'] == '0') ? '<input type="checkbox" name="id[]" value="'. $row['id'] .'">' : '',
							$no++,
							$row['NamaAlkes'],
							$row['Merk'],
							$row['Tipe'],
							$row['NoSeri'],
							$row['LokasiAlat'],
							$row['JamMulai'],
							$row['JamSelesai'],
							'<span class="badge badge-'.$row['Class']. '">'.$row['Status']. '</span>',
							($row['StatusVerifikasi'] == '0') ? '<span class="badge badge-info">Belum Verifikasi</span>' : '<span class="badge badge-success">Verifikasi</span>',
							($row['StatusVerifikasi'] == '0') ? $btn : '',
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
		$tpl['module']    = $this->module.'/Verifikasi';
		$tpl['idx']    = $idx;
		$tpl['Detail'] = $this->M_berita->getPmtAlkes($id)->result_array();;
		$tpl['stKali'] = $this->M_berita->list_ref_status_kalibrasi()->result_array();

		$data_alkes = $this->M_berita->list_detail_alkes($id);
		$data_plgn = $this->M_permintaan->getDtplgn($id);
		$tpl['Plgn'] = $data_plgn;
		$tpl['Alkes'] = $data_alkes->result_array();
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );

		$this->template->title('Verifikasi');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Verifikasi' , '' );
		$this->template->build($this->folder.'/v_verifikasi_data', $tpl);
	}

	public function proses($type="verif",$idx="",$pmt="")
	{
		// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = decode($idx);
		restrict( 'transaksi/Verifikasi/proses', TRUE);
		$tpl['module'] = $this->module.'/Verifikasi';
		$tpl['idx'] = $idx;

		if($type=="verif"){
			$params = $this->input->post('params');
			foreach($params as $val) 
			{
				$update = $this->M_verifikasi->update_status_alat(array('pdaId' => $val, 'pdaIsVerifikasi' => '1'));
			}
			

			if ($update){
				$result = array('status' => TRUE, 'msg' => 'Proses verifikasi berhasil.');
			} else {
				$result = array('status' => FALSE, 'msg' => 'Proses verifikasi gagal.');
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($result));
		}elseif($type=="vis"){
			if($this->input->post('action') =='submit'){
				$params = array(
					'pmtStatusId' => $this->input->post('status'),
					'pmtId' => $this->input->post('id'),
				);


				$rs = $this->M_verifikasi->update_permintaan($params);
				if ($rs) {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Verifikasi berhasil.'));
				} else {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Verifikasi gagal.'));
				}
				redirect(site_url($tpl['module']));
			}else{
				$data_plgn = $this->M_permintaan->getDtplgn($id);
				$tpl['Plgn'] = $data_plgn;
				$tpl['StPmt'] = $this->M_verifikasi->get_verifikasi()->result_array();
				$this->load->view($this->folder . '/v_verifikasi_mdl_verif', $tpl);
			}

				
			
		}elseif($type=="edit"){
			
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
				if ($rs) {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Ubah Berita Acara berhasil.'));
				} else {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Ubah Berita Acara gagal.'));
				}
				redirect(site_url($tpl['module'].'/data/'.$pmt));
			}

			$tpl['dtPmtAlat'] = $this->M_berita->permintaan_detail_alats($id);
			$tpl['stKali'] = $this->M_berita->list_ref_status_kalibrasi()->result_array();
			$this->load->view($this->module . '/verifikasi/v_verifikasi_mdl', $tpl);
			
			
		}
	}

	public function alat($idx)
	{
	// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = decode($idx);
		restrict( 'transaksi/Verifikasi/alat', TRUE);
		$tpl['module'] = $this->module.'/Verifikasi';
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

				$update_insert = $this->M_verifikasi->upin_alat_detail($params);
				if ($update_insert) {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Ubah Berita Acara berhasil.'));
				} else {
					$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Ubah Berita Acara gagal.'));
				}
				redirect(site_url($tpl['module'].'/data/'.$idx));
			


		}

	}
}


/* End of file Verifikasi.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\transaksi\controllers\Verifikasi.php */