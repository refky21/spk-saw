<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_alatKalibrasi extends CI_Model {
    var $base_table = 'ref_alat_kalibrasi';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function list_alatKalibrasi($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
      $this->db->select(' alatId as id,
                          alatNama as nama,
                          alatKode as kode,
                          alatMerk as merk,
                          alatNoseri as noSeri,
                          alatKeterangan as keterangan,
                          alatIsAktif as status     
                      ');
      
      if(!is_null($object)) {
        foreach($object as $row => $val)
        {
            if(preg_match("/(<=|>=|=|<|>)(\s*)(.+)/i", trim($val), $matches))
            $this->db->where( $row .' '.$matches[1], $matches[3]);
            else
            $this->db->where( $row .' LIKE', '%'.$val.'%');
        }
        if(!is_null($limit) && !is_null($offset)){
            $this->db->limit($limit, $offset );
        }

        if(!empty($order)){
            foreach($order as $row => $val)
            {
                $ordered = (isset($val)) ? $val : 'ASC';
                $this->db->order_by($row, $val);
            }
        }

        if(is_null($status)){
            $query = $this->db->get( $this->base_table );
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results($this->base_table);
        }
      }
    }

    function addAlatKalibrasi($params) {
      $this->db->insert($this->base_table, $params);
      return ($this->db->affected_rows() > 0);
    }

    function updateAlatKalibrasi($id, $params) {
      $this->db->where('alatId', $id);
      $this->db->update($this->base_table, $params);
      return ($this->db->affected_rows() > 0);
    }

    function deleteAlatKalibrasi($id) {

      $this->db->where('alatId', $id)->delete($this->base_table);
      return ($this->db->affected_rows() > 0);
    }

    function detailAlatKalibrasi($id) {
      $this->db->select(' alatId as id,
                          alatNama as nama,
                          alatKode as kode,
                          alatMerk as merk,
                          alatNoSeri as noSeri,
                          alatKeterangan as keterangan,
                          alatIsAktif as status
                      ');

      $this->db->where('alatId', $id);
      $query = $this->db->get($this->base_table);
      return $query->row_array();
    }
}