<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Spk extends Dashboard_Controller {
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
		echo "SPK";
	}
}


/* End of file Spk.php */
/* Location: F:\wampp64\www\uad\amk\application\modules\permintaan\controllers\Spk.php */