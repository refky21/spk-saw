<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kwitansi extends CI_Model {

    var $base_table = 'invoice';

    public function __construct()
    {
        parent::__construct();
    }

    function list_invoice($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('invId AS id, 
                            invPermintaan AS IdPermintaan, 
                            invNoInvoice AS Invoice, 
                            invTanggal as TanggalTerbit,
                            invTglBayar as TanggalBayar,
                            invJumlahTagihan as JumlahTagihan,
                            invTerbayar as JumlahBayar,
                            pmtNoOrder as NoOrder,
                            plgnNama as NamaPelanggan,
                            plgnContact as NamaPj,
                        ');
        $this->db->join('permintaan','pmtId=invPermintaan');
        $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
        $this->db->order_by('invId','DESC');
        $this->db->where('invTerbayar !=',NULL);
        
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
            $query = $this->db->get($this->base_table);
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results($this->base_table);
        }
    }

    }


    public function getListInvoice()
{
    
    $this->db->select("invId as id,
                        invNoInvoice as NomorInvoice,
                        invJumlahTagihan as JumlahTagihan,
                        invTanggal as TanggalInvoice,
                        invPermintaan as Permintaan,
                    ");
    // $this->db->join("permintaan","invPermintaan.pmtId");
    $this->db->where('invTerbayar', NULL);

    $query = $this->db->get($this->base_table);

    return $query;
}

public function update_pembayaran($params)
{
    $dt = array(
        "invTerbayar" => $params['invTerbayar'],
        "invTglBayar" => date("Y-m-d H:i:s"),
        "invUserBayar" => get_user_name(),
        "invTglEdit" => date("Y-m-d H:i:s"),
        "invEditUser" => get_user_name(),
    );

    $this->db->where('invId',$params['invId']);
    $update = $this->db->update('invoice',$dt);

    
    return $update;
}

public function update_status_permintaan($params)
{
        $dt = array(
            'pmtStatusId' => 5,
        );

        $this->db->where('pmtId',$params['invPermintaan']);
        $update = $this->db->update('permintaan',$dt);
        return $update;
}


public function getInvoice($id)
{
    $this->db->select("invId as id,
                        invNoInvoice as NomorInvoice,
                        invJumlahTagihan as JumlahTagihan,
                        invTerbayar as JumlahTerbayar,
                        invTanggal as TanggalInvoice,
                        invPermintaan as Permintaan,
                    ");
    $this->db->where('invId',$id);
    $query = $this->db->get($this->base_table);

    return $query->row_array();
}


public function total_bayar($id)
{
    $this->db->select_sum('invTerbayar','TotalBayar');
    $this->db->where('invPermintaan',$id);
    $query = $this->db->get($this->base_table);

    return $query->row_array();
}

public function total_tagihan($id)
{
    $this->db->select_sum('invJumlahTagihan','TotalTagihan');
    $this->db->where('invPermintaan',$id);
    $query = $this->db->get($this->base_table);

    return $query->row_array();
}

public function cetak($id) {
    $this->db->select('
                        invId as id,
                        invTerbayar as JumlahBayar,
                        invNoInvoice AS Invoice,
                        plgnContact as NamaPj,
                        plgnNama as NamaPelanggan,
                        pmtNoOrder as NoOrder
                    ');
    $this->db->where('invId', $id);
    $this->db->join('permintaan','pmtId=invPermintaan');
    $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
    $query = $this->db->get('invoice');
    return $query->row_array();
}

public function cetakAlat($id) {
    $this->db->select('
                        invId as id,
                        alkesNamaBarang as namaAlkes
                    ');
    $this->db->where('invId', $id);
    $this->db->join("permintaan", "pmtId = invPermintaan", 'left');
    $this->db->join("permintaan_detail", "pmtId = pmtdtPermintaanId", 'left');
    $this->db->join("ref_alkes", "alkesId = pmtdtAlkesId", 'left');
    $query = $this->db->get('invoice');
    return $query->result_array();
}


}