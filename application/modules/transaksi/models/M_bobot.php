<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_bobot extends CI_Model {
    var $base_table = 'tr_bobot';
    public function __construct()
    {
        parent::__construct();
    }

    function list_bobot($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('bbtKrId as id,
                            bbtBhsId as id_pem,
                            bbtKrtId as kriteria_id,
                            bbtValue as bobot,
                            kriteriaNama as kriteria,
                            pemNama as pemrograman
                            ');
        $this->db->join('ref_kriteria','kriteriaId=bbtKrtId');
        $this->db->join('ref_pemrograman','pemId=bbtBhsId');
        $this->db->group_by('bbtBhsId');
        
        
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





    public function getBahasa()
    {
        $this->db->select('pemId as id, pemNama as nama');
        $query =  $this->db->get('ref_pemrograman');

        return $query->result_array();
    }

    public function getKriteria()
    {
        $this->db->select('kriteriaId as id , 
        kriteriaNama as nama
        ');

        $query = $this->db->get('ref_kriteria');

        return $query->result_array();
    }

    public function getAlternatif($id = null)
    {
        $this->db->select('subKrtId as id , 
        subKrtNama as nama,
        subKrtValue as nilai
        ');
        $this->db->order_by('subKrtValue', 'ASC');
        $this->db->where('subKrtKriteriaId', $id);

        $query = $this->db->get('ref_sub_kriteria');

        return $query->result_array();
    }

    public function insertBobot($params)
    {
        $data = array (
            'bbtBhsId' => $params['bbtBhasId'],
            'bbtKrtId' => $params['bbtKrtId'],
            'bbtValue' => $params['bbtValue'],
        );
        $insert = $this->db->insert('tr_bobot', $data);
    
        return $insert;
    }

    public function getBhs($id = null)
    {
        $this->db->select('pemNama as nama');
        $this->db->where('pemId', $id);
        $query = $this->db->get('ref_pemrograman');

        return $query->row();
    }

    public function getDetailBobot($id)
    {
        $this->db->select('kriteriaNama as kriteria,
                            pemNama as pemrograman,
                            kriteriaSifat as Sifat,
                            subKrtNama as bobot
                            ');
        $this->db->where('bbtBhsId', $id);
        $this->db->join('ref_kriteria', 'bbtKrtId=kriteriaId');
        $this->db->join('ref_sub_kriteria', 'subKrtKriteriaId=kriteriaId');
        $this->db->join('ref_pemrograman', 'bbtBhsId=pemId');
        $this->db->group_by('subKrtKriteriaId');
        $query = $this->db->get('tr_bobot');

        return $query->result_array();
    }

    public function cekDataBobot($id)
    {
        // $this->db->num_rows('bbtBhsId');
        $this->db->where('bbtBhsId', $id);

        $query = $this->db->get('tr_bobot');

        return $query->num_rows();
    }

    public function DeleteBobot($id)
    {
        $this->db->where('bbtBhsId',$id)->delete($this->base_table);
        return ($this->db->affected_rows() > 0);
    }



}


