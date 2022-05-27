<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_framework extends CI_Model {
    var $base_table = 'ref_framework';
    var $secondary_table = 'ref_pemrograman';

    public function __construct()
    {
        parent::__construct();
    }

    function list_framework($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('fwId AS id, fwNama AS nama, pemNama as pemrograman');
        $this->db->join('ref_pemrograman', 'ref_framework.fwPmId = ref_pemrograman.pemId');
        $this->db->order_by('fwId', 'DESC');
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

    public function ListPemrograman($id = null)
    {
        $this->db->select('pemId as id , pemNama as nama');
        if(!empty($id)){
            $this->db->where('pemId', $id);
        }

        $query = $this->db->get($this->secondary_table);

        return $query;
    }


    public function insertdata($params, $table)
    {
        $query = $this->db->insert($table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function getData($id = null)
    {
        $this->db->select('fwId as id , fwNama as nama, fwPmId as PemId');
        if(!empty($id)){
            $this->db->where('fwId', $id);
        }

        $query = $this->db->get($this->base_table);

        return $query;
    }


    public function updatedata($params)
    {
        $dt = [
            'fwNama' => $params['fwNama'],
            'fwPmId' => $params['fwPmId']
        ];
        $this->db->where('fwId', $params['id']);
        $query = $this->db->update($this->base_table,$dt);
        return $query;
    }

    public function deletedata($id)
    {
        $this->db->where('fwId', $id);
        return $this->db->delete($this->base_table);
    }






}