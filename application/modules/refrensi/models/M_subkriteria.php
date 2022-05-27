<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_subkriteria extends CI_Model {
    var $base_table = 'ref_sub_kriteria';
    public function __construct()
    {
        parent::__construct();
    }

    function list_subkriteria($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('kriteriaId AS idKriteria, 
        subKrtId as id,
        kriteriaNama AS namaKriteria, 
        kriteriaSifat as sifatKirteria,
        subkrtValue as Nilai,
        subkrtNama as Keterangan');
        $this->db->order_by('subKrtId','DESC');
        $this->db->join('ref_kriteria', 'ref_kriteria.kriteriaId = ref_sub_kriteria.subKrtKriteriaId');
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



    public function insertSubKriteria($params)
    {
        $params = [
            'subKrtKriteriaId' => $params['kriteriaId'],
            'subKrtNama' => $params['subNama'],
            'subKrtValue' => $params['subValue']
        ];
        $query = $this->db->insert($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function UpdateData($params)
    {

        $dt = [
            'subKrtKriteriaId' => $params['kriteriaId'],
            'subKrtNama' => $params['subNama'],
            'subKrtValue' => $params['subValue']
        ];


        // var_dump($dt);die;
        $this->db->where('subKrtId', $params['id']);
        $query = $this->db->update($this->base_table,$dt);
        // return ($this->db->affected_rows() > 0);
        return $query;
    }
    public function getKriteria()
    {
        $this->db->select('kriteriaId AS id, kriteriaNama AS nama, kriteriaSifat as sifat');
        $query = $this->db->get('ref_kriteria');

        return $query->result();
    }
    public function getDetailkriteria($id)
    {
        $this->db->where('subKrtId', $id);
        $this->db->select('*');
        $query = $this->db->get($this->base_table);

        return $query->row_array();
    }

    public function DeleteKriteria($id)
    {

        // var_dump($id);die;
        $this->db->where('subKrtId', $id);
        return $this->db->delete('ref_sub_kriteria');
    }







}