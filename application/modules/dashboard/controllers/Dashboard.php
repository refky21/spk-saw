<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Dashboard_Controller {

	var $module = 'dashboard';
	
	
    function __construct() {
        parent::__construct();		
		// restrict();
    }
	
	public function index()
	{
		protect_acct();
		
		#$this->template->inject_partial('modules_css', css( 'inbox.css', '_theme_') );
		
		$tpl['module'] = $this->module.'/Dashboard';
		if ($message = $this->session->flashdata('message')) {
			if(is_array($message)){
				$tpl['message'] = $message;
			} else {
				$tpl['message']['text'] = $message;
				$tpl['message']['status'] = 'info';
			}
		} else {
			$tpl['message'] = NULL;
		}


		$this->template->title( 'Selamat Datang' );
		$this->template->set_breadcrumb( 'Beranda' , site_url('dashboard'), 'ace-icon fa fa-home home-icon blue' );
		$this->template->build($this->module. '/v_index', $tpl);
		
		// echo 'Hallo';
	}


	public function detail_alat($idx)
	{
		// $id=decode($idx);

		// $tpl['title'] = 'Detail Alat';

		// $this->db->select("pdaId as id,
					// pdaMerk as Merk,
					// pdaTipe as Tipe,
					// pdaNoSeri as NoSeri,
					// pdaLokasiAlat as Lokasi,
					// pdaTglKalibrasi as TglKalibrasi,
					// pdaNoSertifikat as NoSertifikat,
					// pdaCatatanKalibrasi as Catatan,
					// pdaJamMulaiKalibrasi as JamMulai,
					// pdaJamSelesaiKalibrasi as JamSelesai,
					// DATE_ADD(pdaTglKalibrasi, INTERVAL 1 YEAR) as TglReKalibrasi,
					// alkesKodeBarang as KodeAlkes,
					// alkesNamaBarang as NamaAlkes,
					// pmtNoOrder as NomorOrder,
					// plgnNama as NamaPelanggan,
					// plgnAlamat as Alamat,
					// plgnContact as PenanggungJawab,
					// plgnHp as Contact,
					// skNama as Status
					// ");
	// $this->db->where('pdaId',$id);
	// $this->db->join('ref_status_kalibrasi','pdaStatusKalibrasi=skId');
	// $this->db->join('permintaan_detail','pdaPermintaanDetailId=pmtdtId');
	// $this->db->join('ref_alkes','pmtdtAlkesId=alkesId');
	// $this->db->join('permintaan','pmtdtPermintaanId=pmtId');
	// $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
	// $alat = $this->db->get('permintaan_detail_alat')->row_array();

	// $tpl['dt'] = $alat;


		// $this->template->set_layout('layout_blank')
								// ->set_partial('modules_js','modules_js')
								// ->set_partial('modues_css','modules_css');
		// $this->template->build($this->module.'/v_berita_cetak_detail', $tpl);

	}

}