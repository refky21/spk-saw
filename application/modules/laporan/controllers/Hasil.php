<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends Dashboard_Controller {

	var $module = 'laporan';

	function __construct() 
	{
		parent::__construct();
		$this->load->model($this->module.'/M_hasil');
	}


	public function index()
	{
		$tpl['module']    = $this->module.'/Hasil';

		$tpl['pemrograman']    = $this->M_hasil->getBahasa();
		
		$this->template->title('Hasil');
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard/Dashboard/index' );
		$this->template->set_breadcrumb( 'Hasil' , '' );
		$this->template->build($this->module.'/hasil/v_index', $tpl);
	}


	public function get_view_ajax()
	{
		// print_r($this->input->post());


		$data['totalKriteria']    = $this->M_hasil->countKriteria();
		$data['getKriteria']    = $this->M_hasil->getKriteria();
		$data['getAlternatif']    = $this->M_hasil->getFrameworkUse($this->input->post('pemrograman'));
		
		$execute   = $this->M_hasil->getHasil($this->input->post('pemrograman'));
		$data['getHasil'] = '<p>Jadi rekomendasi pemilihan Framework <i>'.$execute['pemNama'].'</i> jatuh pada <i>'.$execute['fwNama'].'</i> dengan Nilai <b>'.round($execute['hasil'],3).'</b></p>';


		$this->load->view($this->module.'/hasil/v_view', $data);
	}
}


/* End of file Hasil.php */
/* Location: D:\xampp\htdocs\apps\skripsi\spkframewroks\application\modules\laporan\controllers\Hasil.php */