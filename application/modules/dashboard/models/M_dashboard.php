<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}	


	function data_grafik($filter){
		$this->db->select('count(*) as data, beaNama as PeriodeBeasiswa'); 
		$this->db->join('beasiswa_tawar','pendaftaran.pendBeatawarId = beasiswa_tawar.beatawarId'); 
		$this->db->join('beasiswa','beasiswa_tawar.beatawarBeaId = beasiswa.beaId'); 
        $this->db->from('pendaftaran');
		$this->db->where($filter);
        $this->db->group_by('pendBeatawarId');
        return $this->db->get()->result();
	}

	function get_list_beasiswa()
	{
	   $this->db->select('beaId as id, beaNama AS nama, instansiNama AS instansi');
	   $this->db->join('instansi', 'instansiId = beaSumberInstansiId');
	   $query = $this->db->get('beasiswa');
	   
	   return ($query->num_rows() > 0 ) ? $query->result_array() : NULL;
	}

	 function get_list_tahun()
   {
      $this->db->select('beatawarTahun as tahun');
      $this->db->group_by('beatawarTahun');
      $query = $this->db->get('beasiswa_tawar');
      return ($query->num_rows() > 0 ) ? $query->result_array() : NULL;
   }

   function total_beasiswa(){
	$query = $this->db->get('beasiswa_tawar');

	return $query->num_rows();
   }

   function total_daftar($where = null){
	   if($where != ''){
		   $this->db->where($where);
	   }
	$query = $this->db->get('pendaftaran');

	return $query->num_rows();
   }
}