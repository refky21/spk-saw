<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_penilaian extends CI_Model {
    var $base_table = 'tr_nilai';
    public function __construct()
    {
        parent::__construct();
    }

    function list_nilai($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('nilaiId as id,
                            nilaiFwId as id_fw,
                            nilaiBhsId as id_pem,
                            nilaiKrtId as kriteriaId,
                            nilaiAltrId as alternatifId,
                            pemNama as pemrograman,
                            fwNama as Framework,
                            ');
        $this->db->join('ref_kriteria','nilaiKrtid=kriteriaId');
        $this->db->join('ref_pemrograman','nilaiBhsId=pemId');
        $this->db->join('ref_framework','nilaiFwId=fwId');
        $this->db->group_by('nilaiFwId');
        
        
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
    public function getFramework()
    {
        $this->db->select('fwId as id, fwNama as nama, fwPmId as id_pem');
        $query =  $this->db->get('ref_framework');

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

    public function insertNilai($params)
    {
        $data = array (
            'nilaiFwId' => $params['nilaiFwId'],
            'nilaiBhsId' => $params['nilaiBhsId'],
            'nilaiKrtId' => $params['nilaiKrtId'],
            'nilaiAltrId' => $params['nilaiAltrId'],
        );
        $insert = $this->db->insert('tr_nilai', $data);
    
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

    public function cekNilai($fwId)
    {
        $this->db->where('nilaiFwId', $fwId);
        $query = $this->db->get('tr_nilai');

        return $query->num_rows();
    }

    public function cekDataFw($id, $fwId)
    {
        // $this->db->num_rows('bbtBhsId');
        $this->db->where('fwPmId', $id);
        $this->db->where('fwId', $fwId);
        $query = $this->db->get('ref_framework');

        return $query->num_rows();
    }

    public function DeleteNilai($id)
    {
        $this->db->where('nilaiFwId',$id)->delete($this->base_table);
        return ($this->db->affected_rows() > 0);
    }



}


