<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_alkes extends CI_Model {
    var $base_table = 'ref_alkes';
    public function __construct()
    {
        parent::__construct();
    }

    function list_alkes($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('alkesId AS id, alkesNamaBarang AS nama, alkesKodeBarang as KodeBarang, alkesHargaDasar AS HargaDasar, alkesKeterangan AS keterangan, alkesIsAktif as Status');
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


    public function insertAlkes($params)
    {
        $query = $this->db->insert($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function UpdateAlkes($id, $params)
    {
        $this->db->where('alkesId', $id);
        $query = $this->db->update($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }
    public function GetDetailAlkes($id)
    {
        $this->db->select('alkesId AS id, alkesNamaBarang AS nama, alkesKodeBarang as KodeBarang, alkesHargaDasar AS HargaDasar, alkesKeterangan AS keterangan, alkesIsAktif as Status');
        $this->db->where('alkesId', $id);
        $query = $this->db->get($this->base_table);

        return $query->row_array();
    }

    public function DeleteAlkes($id)
    {
        $this->db->where('alkesId',$id)->delete($this->base_table);
        return ($this->db->affected_rows() > 0);
    }







}