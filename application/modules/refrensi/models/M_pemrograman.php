<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemrograman extends CI_Model {
    var $base_table = 'ref_pemrograman';
    public function __construct()
    {
        parent::__construct();
    }

    function list_bahasa($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('pemId AS id, pemNama AS nama');
        $this->db->order_by('pemId', 'DESC');
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


    public function getPemrograman($id)
    {
        $this->db->select('pemId as Id , pemNama as Nama');
        $this->db->where('pemId',$id);
        $query = $this->db->get($this->base_table);

        return $query->row_array();
    }


    public function insertPemrograman($params)
    {
        $query = $this->db->insert($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function UpdatePemrograman($params)
    {

        $dt = array(
            'pemNama' => $params['pemNama']
        );

        $this->db->where('pemId', $params['id']);
        $query = $this->db->update($this->base_table,$dt);
        return $query;
    }
    public function getKriteria($id = null)
    {
        $this->db->select('kriteriaId AS id, kriteriaNama AS nama, kriteriaSifat as sifat');

        if(!empty($id)){
            $this->db->where('kriteriaId', $id);
        }
        $query = $this->db->get('ref_kriteria');

        return $query->result_array();
    }

    public function DeletePemrograman($id)
    {
        $this->db->where('pemId',$id)->delete($this->base_table);
        return ($this->db->affected_rows() > 0);
    }







}