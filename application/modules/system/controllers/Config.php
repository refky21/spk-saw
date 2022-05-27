<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config extends Auth_Controller {

	function __construct() {
        parent::__construct();
		// loadmodel
		restrict();
    }
	
	public function index()
	{			
		$tpl['module'] = 'system/Config';
		
		$this->template->inject_partial('modules_css', multi_asset( array(
																		'css/components-md.css' => '_theme_',
																		'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' => '_theme_',
																		), 'css' ) );
																		
		$this->template->inject_partial('modules_js', multi_asset( array(
																'js/datatable.js' => '_theme_',
																'js/metronic.js' => '_theme_',
																'plugins/jquery.blockui.min.js' => '_theme_',
																'plugins/datatables/media/js/jquery.dataTables.min.js' => '_theme_',
																'plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' => '_theme_',
																'js/bootbox.min.js' => '_theme_',
															), 'js' ) );
		$this->template->title( 'Pengaturan Data Umum' );
		$this->template->set_breadcrumb( 'Dashboard' , 'dashboard' );
		$this->template->set_breadcrumb( 'Pengaturan' , 'dashboard' );
		$this->template->set_breadcrumb( 'Data Umum' , 'system/Config/index');
		
		$this->template->build('system/v_config_index', $tpl);
	}
	
	function ajax($action = NULL)
    {
		$this->load->model('system/m_config');
		
		if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
		
		if($action == 'datatables'){
			$columns = array(
				1 => 'ConfigName',
				2 => 'UnitName',
				3 => 'ConfigType',
			);
			
			$object = array();
			
			if($this->input->post('search_nama') != ''){
				$object['ConfigName'] = $this->input->post('search_nama');
			}
			
			if($this->input->post('search_unit') != ''){
				$object['UnitName'] = $this->input->post('search_unit');
			}
			
			if($this->input->post('search_tipe') != ''){
				$object['ConfigType'] = $this->input->post('search_tipe');
			}
			
			$order = array();
			if($this->input->post('order')){
				foreach( $this->input->post('order') as $row => $val){
					$order[$columns[$val['column']]] = $val['dir'];
				}
			}
			$length = ($this->input->post('length') == -1) ? NULL : $this->input->post('length');
			
			$qry = $this->m_config->get_config($object, $length, $this->input->post('start'), $order, NULL);
			$iTotalRecords = (!is_null($qry)) ? intval($this->m_config->get_config($object, NULL, NULL, array(), 'counter')) : 0;
			$iDisplayStart = intval($this->input->post('start'));
			$sEcho = intval($this->input->post('draw'));
			
			
			$records = array();
			$records["data"] = array(); 
			if(!is_null($qry)){
				foreach($qry->result_array() as $row){
					$records["data"][] = array(
						/* '<input type="checkbox" name="id[]" value="'. $row['ConfigId'] .'">', */
						$row['ConfigName'],
						$row['UnitName'],
						$row['ConfigType'],
						'<a href="'. site_url( 'system/Config/update/'. $row['ConfigId'] ) .'" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Ubah</a>',
					);
				}
			}
			
			$records["draw"] = $sEcho;
			$records["recordsTotal"] = $iTotalRecords;
			$records["recordsFiltered"] = $iTotalRecords;

			echo json_encode($records);
		}
	}
	
	public function update( $config_id = NULL )
	{
		$this->load->model('system/m_config');	
		if(is_null( $config_id )) show_404();
		if(is_null( $data_config = $this->m_config->get_config(array('ConfigId' => ' = '. $config_id ), NULL, NULL, NULL, NULL) )) show_404();
									
		$tpl['module'] = 'system/Config';
		$tpl['data_config'] = $data_config->row();
		
		$this->form_validation->set_rules('ConfigValue', 'Text SMS', 'required');
		$this->form_validation->set_error_delimiters('<div class="help-block col-xs-12 col-sm-reset inline">', '</div>');
		if ($this->form_validation->run()) {
			$data  = array(	
							'ConfigValue'	=> $this->input->post('ConfigValue'),
						);
			if( $this->m_config->update_config($data, array('ConfigId' =>  $config_id)) ) {
				$this->session->set_flashdata('message_form', array('status' => 'success', 'title' => 'Informasi', 'message' => 'Data berhasil disimpan.'));
			} else {
				$this->session->set_flashdata('message_form', array('status' => 'danger', 'title' => 'Peringatan', 'message' => 'Data gagal disimpan.'));
			}
			redirect('system/Config/update/'. $config_id);
		} else {
			$this->template->title( 'Update Pengaturan Umum' );
			$this->template->set_breadcrumb( 'Dashboard' , 'dashboard' );
			$this->template->set_breadcrumb( 'Pengaturan Data' , 'system/Config/index');
			$this->template->set_breadcrumb( 'Update Data' , 'system/Config/update/'. $config_id);
			$this->template->build('system/v_config_update', $tpl);
		}
	}
}