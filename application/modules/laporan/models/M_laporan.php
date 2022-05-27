<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {
    var $base_table = 'permintaan';
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function get_permintaan() {
      $this->db->select('pmtId as id, pmtNoOrder as nomorOrder');
      $query = $this->db->get($this->base_table);
      return $query->result_array();
    }

    public function get_list_permintaan($object = [], $limit = NULL, $offset = NULL, $order = [], $status = NULL) {
      $this->db->select(' 
                        pmtId as id,
                        pmtNoOrder as nomorOrder,
                        pmtTglRealisasi as tglpelaksanaan,
                        pdaNoSeri as noseri,
                        pdaMerk as merk,
                        pdaTipe as tipe,
                        pdaLokasiAlat as lokasialat,
                        skNama as statuskalibrasi,
                        pdaNoSertifikat as nosertifikat,
                        UserRealName as namaTeknisi,
                        alkesNamaBarang as namaAlkes
                      ');
      $this->db->join('permintaan_detail', 'pmtId = pmtdtPermintaanId', 'left');
      $this->db->join('permintaan_detail_alat', 'pmtdtId = pdaPermintaanDetailId', 'left');
      $this->db->join('ref_alkes', 'pmtdtAlkesId = alkesId', 'left');
      $this->db->join('ref_status_kalibrasi', 'skId = pdaStatusKalibrasi', 'left');
      $this->db->join('sys_user', 'UserName = pdaUserKalibrasi', 'left');
      // $this->db->where('pmtId', $id);

      if(!is_null($object)) {
        foreach($object as $row => $val)
        {
          if(preg_match("/(<=|>=|=|<|>)(\s*)(.+)/i", trim($val), $matches))
            $this->db->where( $row .' '.$matches[1], $matches[3]);
          else
            $this->db->where( $row .' LIKE', '%'.$val.'%');
        }
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
        $qry = $this->db->get( $this->base_table );
        if ( $qry->num_rows() > 0 ) return $qry;
        return NULL;
      } else if($status == 'counter'){
        return $this->db->count_all_results($this->base_table);
      }
    }

    public function get_detail_permintaan($object) {
      $this->db->select(' 
                        pmtId as id,
                        pmtNoOrder as nomorOrder,
                        pmtTglRealisasi as tglpelaksanaan,
                        pdaNoSeri as noseri,
                        pdaMerk as merk,
                        pdaTipe as tipe,
                        pdaLokasiAlat as lokasialat,
                        skNama as statuskalibrasi,
                        pdaNoSertifikat as nosertifikat,
                        UserRealName as namaTeknisi,
                        alkesNamaBarang as namaAlkes,
                        plgnNama AS NamaPelanggan,
                      ');
      $this->db->join('permintaan_detail', 'pmtId = pmtdtPermintaanId', 'left');
      $this->db->join('permintaan_detail_alat', 'pmtdtId = pdaPermintaanDetailId', 'left');
      $this->db->join('ref_alkes', 'pmtdtAlkesId = alkesId', 'left');
      $this->db->join('ref_status_kalibrasi', 'skId = pdaStatusKalibrasi', 'left');
      $this->db->join('sys_user', 'UserName = pdaUserKalibrasi', 'left');
      $this->db->join('ref_pelanggan','pmtPelangganId=plgnId','left');

      if(!is_null($object)) {
        foreach($object as $row => $val)
        {
           if ($val != '') {
              
              if(preg_match("/(<=|>=|=|<|>)(\s*)(.+)/i", trim($val), $matches))
                 $this->db->where( $row .' '.$matches[1], $matches[3]);
              else
                 $this->db->where( $row .' LIKE', '%'.$val.'%');
           }
        }
     }

     $query = $this->db->get($this->base_table);
     return $query;
    }

  }