<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends Dashboard_Controller {

	var $module = 'permintaan';

	function __construct() 
	{
		parent::__construct();
		restrict();
		$this->load->model($this->module.'/M_permintaan');
		$this->load->helper($this->module.'/pmt');
	}

	public function index()
	{
		$tpl['module']    = $this->module.'/Permintaan';
		$tpl['modulespk']    = $this->module.'/Spk';
		$tpl['roleAdd']    = restrict('permintaan/Permintaan/add', TRUE);
		
		$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

		
			// var_dump(get_user_group());
    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
		$this->template->title('Permintaan');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Data Permintaan' , '' );
		$this->template->build($this->module.'/v_permintaan_index', $tpl);
	}

	public function read()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Permintaan';
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

		$qry = $this->M_permintaan->list_prmnt($object, $length, $this->input->post('start'), $order,NULL,get_user_id());
		$iTotalRecords = (!is_null($qry)) ? intval($this->M_permintaan->list_prmnt($object, NULL, NULL, NULL, 'counter')) : 0;
		$iDisplayStart = intval($this->input->post('start'));
		$sEcho = intval($this->input->post('draw'));
		$records = array();
    	$records["data"] = array();
		if(!is_null($qry)){
			$no = $iDisplayStart + 1;
			$roleEdit = restrict( 'permintaan/Permintaan/edit', TRUE);
			$roleDelete = restrict('permintaan/Permintaan/delete', TRUE);
			$roleSuratTgs = restrict('permintaan/Surat_tugas/index', TRUE);
			$roleSuratKal = restrict('permintaan/Permintaan/surat_kalibrasi', TRUE);
			foreach($qry->result_array() as $row){
				// Button

				if($roleSuratTgs == TRUE){
					$SuratLink = '<a href="'.site_url($this->module).'/Surat_tugas/index/'.encode($row['id']).'" class="btn btn-square btn-warning text-white table-action"  data-provide="tooltip" title="Surat Tugas"> <i class="ti-email"></i> </a>';
				}else{
					$SuratLink = "";
				}

				if($roleEdit == TRUE){
					$editLink = '<a href="'.site_url($this->module).'/Permintaan/edit/'.encode($row['id']).'"  class="btn btn-square btn-info text-white table-action"  data-provide="tooltip" title="Edit Permintaan"> <i class="fa fa-pencil"></i> </a>';
				}else{
					$editLink = "";
				}

				if($roleDelete == TRUE){
					$deleteLink = '<a href="'.site_url($this->module).'/Permintaan/delete/'.encode($row['id']).'" id="del-btn" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" title="Hapus Permintaan"> <i class="ti-trash"></i> </a>';
				}else{
					$deleteLink = "";
				}

				if($roleSuratKal == TRUE) {
					$SuratKalLink = '<a target="_blank" href="'.site_url($this->module).'/permintaan/surat_kalibrasi/'.encode($row['id']).'" class="btn btn-square btn-success text-white table-action"  data-provide="tooltip" title="Surat Kalibrasi"> <i class="ti-printer"></i> </a>';
				} else {
					$SuratKalLink = "";
				}

				

				$tgl = ($row['TanggalPermintaan'] != NULL) ? IndonesianDate($row['TanggalPermintaan']) : '';
				// var_dump($tgl);die;
				$kunjungan = ($row['TglKunjung'] != NULL) ? IndonesianDate($row['TglKunjung']) : '';
				$realisasi = ($row['TglRealisasi'] != NULL) ? IndonesianDate($row['TglRealisasi']) : '';
				if($row['totdtPermintaan'] <= 0){
					$btn = $editLink.' '. $deleteLink;
				} else {
					$btn = $SuratKalLink.' '.$SuratLink.' ' .$editLink;
				}
				$records["data"][] = array(
				$no++,
				"<b>".$row['NoOrder']."</b>",
				$row['NamaPelanggan'],
				$row['NamaPj'],
				'<span class="badge badge-'.$row['Class'].'">'.$row['StatusPermintaan']. '</span>',
				($row['totdtPermintaan'] > 0) ? '<a id="btnUsulan" data-provide="tooltip" href="#" data-url="'.site_url($this->module .'/Permintaan/list_alat/'.encode($row['id'])).'" title="List Alat">'.$row['totdtPermintaan'].'</a> ' : $row['totdtPermintaan'],
				// '<div class="text-center">'. $row['totdtPermintaan'] . '</div>',
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
	}

	public function add()
	{
		$module = $this->module.'/Permintaan';
		restrict('permintaan/Permintaan/add', TRUE);
		$tpl['module'] = $module;
		$config =  getConfig(array("ConfigCode" => "defaultPPN"));
		$tpl['PPN'] = $config['Value'];
		
		$tpl['roleKalibrasiAdd'] = restrict('permintaan/Permintaan/alat_kalibrasi', TRUE);;
		$tpl['roleAlkesAdd'] = restrict('permintaan/Permintaan/detail', TRUE);

		
		$list_pelanggan = $this->M_permintaan->list_pelanggan();

		$this->form_validation->set_rules('plgnId', 'Pelanggan', 'required');
		if ($this->form_validation->run()) {
			// $valid = $this->M_permintaan->validation('permintaan',array('pmtPelangganId' => $this->input->post('plgnId')));
			// if($valid > 0){
			// 	$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'danger', 'text' => 'Pelanggan Ini Sudah Melakukan Permintaan.'));
			// 	redirect(site_url($module));
			// }

			$params = array(
				'pmtPelangganId'   => $this->input->post('plgnId'),
				'pmtTglRencanaKunjungan' => $this->input->post('tgl_real'),
				'pmtTglPengajuan' => $this->input->post('tgl_pmt_real'),
				'pmtCatatan' => $this->input->post('pmtCatatan'),
				'pmtPPN' => $this->input->post('ppn'),
				'pmtLamaKunjungan' =>$this->input->post('durasi_pengerjaan'),
				'pmtBiayaKunjungan' => str_replace('.','',$this->input->post('biaya_kunjungan')),
        	);

			
			$insert = $this->M_permintaan->insert_permintaan($params);
			$pmt_id = $this->M_permintaan->last_insert();
			
			if ($insert) {
				$id_alkes = $this->input->post('brg_id[]');
				$hrg = $this->input->post('harga[]');
				$jml_alat = $this->input->post('jml_alat[]');
				$hrg_diskon = $this->input->post('hrg_diskon[]');
				$jns_diskon = $this->input->post('jnsDiskon[]');
				$lok_alat = $this->input->post('lokasi_alat[]');
				
				// Alkes
				if(!empty($id_alkes)){
					foreach($id_alkes as $i => $alkes){
						$params = array(
							'pmtdtPermintaanId' => $pmt_id,
							'pmtdtAlkesId' => decode($id_alkes[$i]),
							'pmtdtHarga' => $hrg[$i],
							'pmtdtJumlahDiskon' => $hrg_diskon[$i],
							'pmtdtJumlahAlat' => $jml_alat[$i],
							'pmtdtJenisDiskon' => $jns_diskon[$i],
						);
						$insert_dt = $this->M_permintaan->insertDetailPermintaan($params);
						$insert_dt_id = $this->M_permintaan->last_insert();
						// insert berita barang
							for ($x = 0; $x <= $jml_alat[$i]-1; $x++) {
								$pr = array(
									'pdaPermintaanDetailId' => $insert_dt_id,
								);
							$this->M_permintaan->InsertDetailAlkes($pr);
						}
					}	
				}

				// Kalibrator
				$kalibrasi = $this->input->post('kalibrasi_id[]');
				if(!empty($kalibrasi)){
					foreach($kalibrasi as $i => $id_kali){
						$pmt_dt = array(
							'pakPermintaanId' => $pmt_id,
							'pakAlatId' => decode($id_kali),
						);
						$insert_kali = $this->M_permintaan->InsertPermintaanKalibrator($pmt_dt);
					}
				}
				
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Buat Permintaan berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Buat Permintaan gagal.'));
			}
			redirect(site_url($module));
		}
		$error = $this->form_validation->error_array();
		if (!empty($this->form_validation->error_array())) {
			foreach($error as $err) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Buat Permintaan gagal. '.$err));  
			}
			redirect(site_url($module));  
		}
		$tpl['listPlgn'] = $list_pelanggan;
		$tpl['listAlat'] = $this->M_permintaan->list_alat_kalibrasi();
			$this->template->title( 'Buat Permintaan' );
			$this->template->set_breadcrumb( 'Beranda' , 'dashboard');
			$this->template->set_breadcrumb( 'Permintaan' , 'permintaan/Permintaan');
			$this->template->set_breadcrumb( 'Buat Permintaan' , '');
			$this->template->inject_partial('modules_css', multi_asset( array(
			'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
			), 'css' ) );

    	$this->template->inject_partial('modules_js', multi_asset( array(
			'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
			'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
			), 'js' ) );
			$this->template->build($this->module .'/v_permintaan_form', $tpl);

	}

	function ajax_select(){
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$id = $this->input->post('PlgnId');
		$list = $this->M_permintaan->list_pelanggan($id);
		if(!empty($list)){
			$data = array(
						'data' => $list,
						'type' => 'success'
			);
		}else{
			$data = array(
						'data' => NULL,
						'type' => 'error'
			);
		}
		

		$this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
	}

	// Detail Barang
	public function detail($type = 'alkes')
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		
		$tpl['module']  = $this->module . '/Permintaan';
		$this->template->title( 'Buat Permintaan' );
			$this->template->set_breadcrumb( 'Beranda' , 'dashboard');
			$this->template->set_breadcrumb( 'Permintaan' , 'permintaan/Permintaan');
			$this->template->set_breadcrumb( 'Buat Permintaan' , '');
		if($type=='alkes'){
			$this->load->view($this->module . '/v_permintaan_mdl_alkes', $tpl);
		}elseif($type=='kalibrasi'){
			$this->load->view($this->module . '/v_permintaan_mdl_kalibrasi', $tpl);
		}
	}
	public function detail_read($jenis = 'alkes')
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		$module = $this->module.'/Permintaan';
		// if ($jenis == 'alkes') {
			$columns = array(
				1 => 'alkesId',
				2 => 'alkesKodeBarang',
				3 => 'alkesNamaBarang'
			);
			$object = array();
			$filter_key = $this->input->post('search');
			if($filter_key['value'] != ''){
				$object['alkesNamaBarang'] = $filter_key['value'];
			}

			$order = array();

			$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

			$qry = $this->M_permintaan->get_data_alkes($object, $length, $this->input->post('start'), $order);
			// var_dump($qry->result_array());die;
			$iTotalRecords = (!is_null($qry)) ? intval($this->M_permintaan->get_data_alkes($object, NULL, NULL, NULL, 'counter')) : 0;
			$iDisplayStart = intval($this->input->post('start'));
			$sEcho = intval($this->input->post('draw'));
			$records = array();
			$records["data"] = array();
			if(!is_null($qry)){
				$no = $iDisplayStart + 1;
				foreach($qry->result_array() as $row){
					
					$records["data"][] = array(
					$no++,
					$row['alkesId'],
					$row['KodeBarang'],
					$row['NamaAlkes'],
					intval($row['HargaDasar']),
					'<a class="btn btn-info btn-xs" href="#" data-id="'.encode($row['alkesId']).'" id="btnPilih" data-provide="tooltip" title="Pilih Barang"><i class="fa fa-check"></i></a> '
					);
				}
			}
			$records["draw"] = $sEcho;
			$records["recordsTotal"] = $iTotalRecords;
			$records["recordsFiltered"] = $iTotalRecords;

			echo json_encode($records);
	}

	public function alat_kalibrasi()
	{
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		
		$tpl['module']  = $this->module . '/Permintaan';
		$this->template->title( 'Buat Permintaan' );
			$this->template->set_breadcrumb( 'Beranda' , 'dashboard');
			$this->template->set_breadcrumb( 'Permintaan' , 'permintaan/Permintaan');
			$this->template->set_breadcrumb( 'Buat Permintaan' , '');

		$this->load->view($this->module . '/v_permintaan_mdl_kalibrasi', $tpl);
	}

	public function datatables_kalibrasi()
	{
		$columns = array(
				1 => 'alatId',
				2 => 'alatKode',
				3 => 'alatNama'
			);
			$object = array();
			$filter_key = $this->input->post('search');
			if($filter_key['value'] != ''){
				$object['alatNama'] = $filter_key['value'];
			}

			$order = array();

			$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');

			$qry = $this->M_permintaan->list_alat_kalibrasi($object, $length, $this->input->post('start'), $order);
			// var_dump($qry->result_array());die;
			$iTotalRecords = (!is_null($qry)) ? intval($this->M_permintaan->list_alat_kalibrasi($object, NULL, NULL, NULL, 'counter')) : 0;
			$iDisplayStart = intval($this->input->post('start'));
			$sEcho = intval($this->input->post('draw'));
			$records = array();
			$records["data"] = array();
			if(!is_null($qry)){
				$no = $iDisplayStart + 1;
				foreach($qry->result_array() as $row){
					
					$records["data"][] = array(
					$no++,
					$row['alatId'],
					$row['kodeName'],
					$row['alatMerk'],
					$row['alatNoSeri'],
					'<a class="btn btn-info btn-xs" href="#" data-id="'.encode($row['alatId']).'" id="btnPilih" ><i class="fa fa-check"></i> Pilih</a> '
					);
				}
			}
			$records["draw"] = $sEcho;
			$records["recordsTotal"] = $iTotalRecords;
			$records["recordsFiltered"] = $iTotalRecords;

			echo json_encode($records);
	}

	public function list_alat($id = null)
	{
		$id = decode($id);
		
		$tpl['alkes'] = $this->M_permintaan->get_detail($id)->result_array();
		$this->load->view($this->module . '/v_permintaan_detail', $tpl);
	}

	public function edit($idx)
	{
		$id = decode($idx);
		$module = $this->module.'/Permintaan';
		restrict('permintaan/Permintaan/edit', TRUE);
		
		$tpl['module'] = $module;
		$tpl['hashId'] = $idx;
		$tpl['roleKalibrasiAdd'] = restrict('permintaan/Permintaan/alat_kalibrasi', TRUE);;
		$tpl['roleAlkesAdd'] = restrict('permintaan/Permintaan/detail', TRUE);

		$config =  getConfig(array("ConfigCode" => "defaultPPN"));
		$tpl['PPN'] = $config['Value'];

		$detail_pelanggan = $this->M_permintaan->get_detail_permintaan($id)->row_array();
		$list_pelanggan = $this->M_permintaan->list_pelanggan();
		$barang = $this->M_permintaan->get_list_detail_alkes($id);
		$kalibrator = $this->M_permintaan->list_alat_kalibrasi_detail($id)->result_array();


		$this->form_validation->set_rules('plgnId', 'Pelanggan', 'required');
		if ($this->input->post('brg_id[]')) {
            $this->form_validation->set_rules('jml_alat[]', 'Jumlah', 'trim|required|numeric');
            $this->form_validation->set_rules('harga[]', 'Harga Perkiraan', 'trim|required|numeric');
        }
		if ($this->form_validation->run()) {

			$params = array(
				'pmtId' => $detail_pelanggan['Id'],
				'pmtPelangganId' =>$this->input->post('plgnId'),
				'pmtRencanaKunjungan' =>$this->input->post('tgl_real'),
				'pmtTglPengajuan' =>$this->input->post('tgl_pmt_real'),
				'pmtCatatan' =>$this->input->post('pmtCatatan'),
				'pmtPPN' =>$this->input->post('ppn'),
				'pmtLamaKunjungan' =>$this->input->post('durasi_pengerjaan'),
				'pmtBiayaKunjungan' =>$this->input->post('biaya_kunjungan'),
			);
			// var_dump($params);
			$update = $this->M_permintaan->update_permintaan($params);
			if($update){
				$id_alkes = $this->input->post('brg_id[]');
				$hrg = $this->input->post('harga[]');
				$jml_alat = $this->input->post('jml_alat[]');
				$hrg_diskon = $this->input->post('hrg_diskon[]');
				$jns_diskon = $this->input->post('jnsDiskon[]');
				$lok_alat = $this->input->post('lokasi_alat[]');
				// Alkes
				if(!empty($id_alkes)){
					foreach($barang as $i => $detail){
						$this->M_permintaan->deletePermintaanDetailById($detail['id']);
						$this->M_permintaan->deletePermintaanAlkes($detail['id']);
					}
					foreach($id_alkes as $i => $alkes){
						$params = array(
							'pmtdtPermintaanId' => $detail_pelanggan['Id'],
							'pmtdtAlkesId' => decode($id_alkes[$i]),
							'pmtdtHarga' => $hrg[$i],
							'pmtdtJumlahDiskon' => $hrg_diskon[$i],
							'pmtdtJumlahAlat' => $jml_alat[$i],
							'pmtdtJenisDiskon' => $jns_diskon[$i],
						);
						$insert_dt = $this->M_permintaan->insertDetailPermintaan($params);
						$insert_dt_id = $this->M_permintaan->last_insert();

						// insert berita barang
						for ($x = 0; $x <= $jml_alat[$i]-1; $x++) {
							$pr = array(
								'pdaPermintaanDetailId' => $insert_dt_id,
							);
							$this->M_permintaan->InsertDetailAlkes($pr);
						}
					}
					
				}else{
					foreach($barang as $i => $detail){
						$this->M_permintaan->deletePermintaanDetailById($detail['id']);
					}
				}

				$kalibrasi = $this->input->post('kalibrasi_id[]');
				// Kalibrator
				if(!empty($kalibrasi)){
					foreach($barang as $i => $detail){
						$this->M_permintaan->deleteKalibratorByPermintaanDetail($detail_pelanggan['Id']);
					}

					foreach($kalibrasi as $i => $id_kali){
						$pmt_dt = array(
							'pakPermintaanId' => $detail_pelanggan['Id'],
							'pakAlatId' => decode($id_kali),
						);
						$insert_kali = $this->M_permintaan->InsertPermintaanKalibrator($pmt_dt);
						$insert_kali_id = $this->M_permintaan->last_insert();
					}
				}else{
					foreach($barang as $i => $detail){
						$this->M_permintaan->deleteKalibratorByPermintaanDetail($detail_pelanggan['Id']);
					}
				}

            	$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Ubah Permintaan berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'danger', 'text' => 'Ubah Permintaan gagal.'));
			}
			redirect(site_url($module));
		}
		$error = $this->form_validation->error_array();
		if (!empty($this->form_validation->error_array())) {
			foreach($error as $err) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Ubah Permintaan gagal. '.$err));  
			}
			redirect(site_url($module));  
		}

		$this->template->title( 'Perubahan Data Permintaan' );
        $this->template->set_breadcrumb( 'Beranda' , 'dashboard');
        $this->template->set_breadcrumb( 'Permintaan' , 'permintaan/Permintaan');
        $this->template->set_breadcrumb( 'Ubah Permintaan' , '');

		$this->template->inject_partial('modules_css', multi_asset( array(
										'vendor/datatables/css/dataTables.bootstrap4.min.css' => '_theme_',
										), 'css' 
		));
    	$this->template->inject_partial('modules_js', multi_asset( array(
										'vendor/datatables/js/jquery.dataTables.min.js' => '_theme_',
										'vendor/datatables/js/dataTables.bootstrap4.min.js' => '_theme_',
										),'js' 
		) );

		$tpl['dtPlgn'] = $detail_pelanggan;
		$tpl['listPlgn'] = $list_pelanggan;
		$tpl['barang'] = $barang;
		$tpl['kalibrator'] = $kalibrator;
		$tpl['listAlat'] = $this->M_permintaan->list_alat_kalibrasi();
		$this->template->build($this->module .'/v_permintaan_edit', $tpl);

	}

	public function delete($idx)
	{
		$id = decode($idx);
		$detil = $this->M_permintaan->get_detail_permintaan($id);
		restrict('permintaan/Permintaan/delete', TRUE);
		if (!is_null($detil)) {
			$rs = $this->M_permintaan->delete($id);
			if ($rs) {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => TRUE, 'type' => 'success', 'text' => 'Hapus Permintaan berhasil.'));
			} else {
				$this->session->set_flashdata('msg', array('title' => 'Informasi!','status' => FALSE, 'type' => 'warning', 'text' => 'Hapus Permintaan gagal.'));
			}
		}
		redirect(site_url($this->module.'/Permintaan'));  
	}

	public function surat_kalibrasi($idx) {

		restrict('permintaan/Permintaan/surat_kalibrasi', TRUE);

		$id = decode($idx);
		$tpl['title']					= 'Cetak Surat Kalibrasi';
		$tpl['detail']				= $this->M_permintaan->get_detail_permintaan($id)->row_array();
		$tpl['alat']					= $this->M_permintaan->get_list_detail_alkes($id);
		$tpl['total']					= $this->M_permintaan->get_total_alat($id);
		$tpl['permintaan']		= $this->M_permintaan->get_akomodasi($id);
		$tpl['row']		= $this->M_permintaan->get_total($id);

		$this->template->set_layout('layout_blank')
									 ->set_partial('modules_js', 'modules_js')
									 ->set_partial('modues_css','modules_css');
		$this->template->build($this->module.'/surat_kalibrasi/v_suratkalibrasi_index', $tpl);
	}

	


	// ========================== Tidak Terpakai ========================= //

}


/* End of file Permintaan.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\permintaan\controllers\Permintaan.php */