<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_list_alat extends CI_Model {

    var $base_table = 'permintaan';

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function list_permintaan($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
      $this->db->select(' pmtId as id,
                          plgnNama as NamaPelanggan,
                          pmtNoOrder as NomorOrder,
                          alkesKodeBarang as KodeBarang,
                          alkesNamaBarang as NamaBarang,
                          pmtdtJumlahAlat as JumlahAlat     
                      ');
        $this->db->join("ref_pelanggan","pmtPelangganId=plgnId");
        $this->db->join("permintaan_detail","pmtId=pmtdtPermintaanId");
        $this->db->join("ref_alkes","pmtdtAlkesId=alkesId");
        if(get_user_group() != 1){
            $this->db->join('permintaan_teknisi','ptPermintaanId=pmtId','left');
            $this->db->where('ptTeknisiId',get_user_id());
        }
        
        $this->db->order_by('pmtNoOrder','ASC');
        $this->db->group_by('pmtId');
      
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

    public function getPelanggan($postData)
    {
    
        $response = array();

        if(isset($postData['search']) ){
            $this->db->select("plgnNama as NamaPelanggan, plgnId as Id, pmtId as PermintaanId, pmtNoOrder as NoOrder");
            $this->db->join("permintaan","pmtPelangganId=plgnId");
            $this->db->where("pmtNoOrder like '%".$postData['search']."%' ");
            // $this->db->orwhere("pmtNoOrder like '%".$postData['search']."%' ");
            $query = $this->db->get('ref_pelanggan')->result();

            foreach($query as $row ){
                $response[] = array("value"=>$row->PermintaanId,"label"=>$row->NoOrder);
            }
        }
        return $response;

    }

}


/* End of file M_alatKalibrasi.php */