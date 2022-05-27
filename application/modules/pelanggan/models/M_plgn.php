<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_plgn extends CI_Model {
    var $base_table = 'ref_pelanggan';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    function list_plgn($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select("plgnId AS id, 
                            plgnNama AS nama, 
                            plgnContact AS PenanggungJawab, 
                            plgnHp AS hp,
                            katNama as Kategory,
                            CONCAT((plgnAlamat),(' '),(kabNama),(' '),(propinsiNama)) as Alamat");
        $this->db->join('kabupaten','plgnKabId=kabId','left');
        $this->db->join('propinsi','kabPropId=propinsiId','left');
        $this->db->join('ref_kategori_pelanggan','plgnKategoriId=katId','left');
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

    public function InsertPelanggan($data)
    {
        $params = array('plgnNama' => $data['pelanggan'],
                    'plgnAlamat' => $data['alamatPlgn'],
                    'plgnContact' => $data['penanggung_jawab'],
                    'plgnKategoriId' => $data['plgnKategoriId'],
                    'plgnKabId' => $data['plgnKabId'],
                    'plgnHp' => $data['hp']);
        // var_dump($params);die;
        $query = $this->db->insert($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function GetDetailPelanggan($id)
    {
        $this->db->select("plgnId AS id, 
                            plgnNama AS nama, 
                            plgnContact AS PenanggungJawab, 
                            plgnHp AS hp,
                            katNama as Kategory,
                            plgnKategoriId as KatPlgn,
                            plgnAlamat as Alamat");
        $this->db->join('kabupaten','plgnKabId=kabId','left');
        $this->db->join('propinsi','kabPropId=propinsiId','left');
        $this->db->join('ref_kategori_pelanggan','plgnKategoriId=katId','left');

        $this->db->where('plgnId', $id);
        $query = $this->db->get($this->base_table);
        return $query->row_array();
    }

    public function list_type()
    {
        $this->db->select('katId AS id, katNama AS Kategori');
        $query = $this->db->get("ref_kategori_pelanggan");
        return $query->result_array();
    }

    public function list_prop()
    {
        $this->db->select('propinsiId AS id, propinsiNama AS PropNama');
        $query = $this->db->get("propinsi");
        return $query->result_array();
    }

    public function get_kabupaten($id)
    {
        $this->db->select('kabId AS id, kabNama AS KabNama, kabPropId as PropId');
        $this->db->where('kabPropId',$id);
        $query = $this->db->get("kabupaten");
        return $query->result_array();
    }

    public function updatePelanggan($id, $params) {
        $this->db->where('plgnId', $id);
        $this->db->update($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
    }

    public function DeletePelanggan($id)
    {
        $this->db->where('plgnId',$id)->delete($this->base_table);
        return ($this->db->affected_rows() > 0);
    }



}