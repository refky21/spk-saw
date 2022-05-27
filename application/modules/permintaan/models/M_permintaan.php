<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_permintaan extends CI_Model {
    var $base_table = 'permintaan';
    public function __construct()
    {
        parent::__construct();
    }

    function list_prmnt($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL,$teknisi = null)
    {
        $this->db->select('pmtId AS id, 
                            plgnNama AS NamaPelanggan, 
                            plgnContact AS NamaPj, 
                            stNama as StatusPermintaan,
                            stClass as Class,
                            pmtCatatan as Catatan,
                            pmtNoOrder as NoOrder,
                            pmtTglPengajuan as TanggalPermintaan,
                            pmtTglRencanaKunjungan as TglKunjung,
                            pmtLamaKunjungan as LamaKunjungan,
                            pmtTglRealisasi as TglRealisasi,
                            IFNULL(COUNT(permintaan_detail.pmtdtId), 0) as totdtPermintaan
                            ');
        $this->db->join('permintaan_detail','pmtId=pmtdtPermintaanId','left');
        $this->db->join('ref_pelanggan','pmtPelangganId=plgnId','left');
        $this->db->join('ref_status_permintaan','pmtStatusId=stId','left');
        $this->db->group_by('pmtId');
        if(get_user_group() != 1){
            $this->db->join('permintaan_teknisi','ptPermintaanId=pmtId','left');
            $this->db->where('ptTeknisiId',$teknisi);
        }
        $this->db->where('pmtStatusId !=',0);
        
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
    public function list_detail($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL,$id)
    {
        $table = 'permintaan_detail';
        $this->db->select('pmtdtId as id,
                            pmtdtPermintaanId as pmtId,
                            pmtdtAlkesId as AlkesId,
                            pmtdtHarga as HargaPermintaan,
                            pmtdtJumlahAlat as Qty,
                            pmtdtAlkesId as AlkesId,
                            alkesNamaBarang as NamaAlkes,
                            alkesKodeBarang as KodeAlkes,
                            pmtdtJumlahDiskon as JmlDiskon,
                            pmtdtJenisDiskon as JnsDiskon,
                            pmtdtAlatKalibrasiId as AlatKlbId,
                            alatKode as KodeAlat,
                            alatNama as NamaAlat,
                            pmtdtLokasiAlat as LokasiAlat,
                            pmtdtStatusKalibrasi as StatusKlbId,
                            skNama as StatusKalibrasi
                        ');
        $this->db->join('ref_alkes','pmtdtAlkesId=alkesId','left');
        $this->db->join('ref_alat_kalibrasi','pmtdtAlatKalibrasiId=alatId','left');
        $this->db->join('ref_status_kalibrasi','pmtdtStatusKalibrasi=skId','left');
        $this->db->where('pmtdtPermintaanId',$id);
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
            $query = $this->db->get('permintaan_detail');
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results('permintaan_detail');
        }
    }

}

public function getDtplgn($id)
{
    $this->db->select('pmtId as id,
                        pmtPelangganId as PmtPelangganId,
                        plgnNama as NamaPelanggan,
                        plgnAlamat as AlamatPelanggan,
                        plgnContact as PenanggungJawab,
                        plgnHp as HpPelanggan
                    ');
    $this->db->join('ref_pelanggan','pmtPelangganId=plgnId','left');
    $this->db->where('pmtId',$id);

    return $this->db->get('permintaan')->row_array();
}

public function insert_detail($params)
{
    $query = $this->db->insert('permintaan_detail', $params);
        return ($this->db->affected_rows() > 0);
}

public function get_detail_permintaan($id)
{
    $this->db->select('pmtId as Id,
                        pmtPelangganId as PelangganId,
                        pmtCatatan as Catatan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
                        plgnContact as PenanggungJawab,
                        plgnALamat as Alamat,
                        plgnContact as NamaPj,
                        plgnHp,
                        pmtPPN as ppn,
                        pmtNoOrder as nomor,
                        pmtTglPengajuan as TglAjuan,
                        pmtLamaKunjungan as LamaKunjungan,
                        pmtTglRencanaKunjungan as TglKunjungan,
                        pmtTglRealisasi as TglRealisasi,
    ');
    $this->db->where('pmtId',$id);
    $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
    $query = $this->db->get( $this->base_table );
    return $query;
}

public function list_pelanggan($id = null)
{
    $this->db->select('plgnId,
                        plgnAlamat as AlamatPelanggan,
                        plgnContact as Contact,
                        plgnHp as Hp,
                        plgnNama as Pelanggan
                    ');
    if(!empty($id)){
        $this->db->where('plgnId',$id);
    }

    $query = $this->db->get('ref_pelanggan');
    if(!empty($id)){
        return $query->row_array();
    }else{
        return $query->result_array();
    }

}

public function get_detail($id)
{
    $this->db->select('pmtdtPermintaanId as IdPermintaan,
                        pmtdtAlkesId as AlkesId,
                        pmtdtHarga as Harga,
                        pmtdtJumlahAlat as JumlahAlat,
                        pmtdtJumlahDiskon as JumlahDiskon,
                        pmtdtJenisDiskon as JenisDiskon,
                        alkesNamaBarang as NamaAlkes,
                        alkesHargaDasar as HargaDasar
                    ');
    $this->db->join('ref_alkes','pmtdtAlkesId=alkesId');
    $this->db->where('pmtdtPermintaanId',$id);
    $query = $this->db->get('permintaan_detail');
    return $query;
}

public function validation($table,$where)
{
    $this->db->where($where);
    $query = $this->db->get($table);

    return $query->num_rows();

}

public function update_permintaan($params)
{
        // $this->db->trans_begin();
    // var_dump($params);die;
        $dt = array(
            'pmtTglRencanaKunjungan' => $params['pmtRencanaKunjungan'],
            'pmtTglPengajuan' => $params['pmtTglPengajuan'],
            'pmtCatatan' => $params['pmtCatatan'],
            'pmtPelangganId' => $params['pmtPelangganId'],
            'pmtPPN' => $params['pmtPPN'],
            'pmtLamaKunjungan' => $params['pmtLamaKunjungan'],
            'pmtBiayaKunjungan' => str_replace('.','',$params['pmtBiayaKunjungan']),
            'pmtTglEdit' => date('Y-m-d H:i:s'),
            'pmtEditUser' => get_user_name()
        );

        $this->db->where('pmtId',$params['pmtId']);
        $update = $this->db->update('permintaan',$dt);
        // if($update){
        //     if(!empty($params['pmtdtId'])){
        //         $this->db->where('pmtdtPermintaanId',$params['pmtId']);
        //         $delbrg = $this->db->delete('permintaan_detail');
        //         foreach($params['pmtdtId'] as $i => $val) {
        //             $pmt_dt = array(
        //                 'pmtdtPermintaanId' => $params['pmtId'],
        //                 'pmtdtAlkesId' => decode($params['pmtdtAlkesId'][$i]),
        //                 'pmtdtHarga' => $params['pmtdtHarga'][$i],
        //                 'pmtdtJumlahDiskon' => $params['pmtdtJumlahDiskon'][$i],
        //                 'pmtdtJenisDiskon' => $params['pmtdtJenisDiskon'][$i],
        //                 // 'pmtdtAlatKalibrasiId' => decode($params['pmtdtAlatKalibrasiId'][$i]),
        //                 'pmtdtJumlahAlat' => $params['pmtdtJumlahAlat'][$i],
        //                 'pmtdtTglInsert' => date('Y-m-d H:i:s'),
        //                 'pmtdtInsertUser' => get_user_name()
        //             );
        //             $insert = $this->db->insert('permintaan_detail', $pmt_dt);
        //         } 
        //     }else{
        //         $this->db->where('pmtdtPermintaanId',$params['pmtId']);
        //         $hitdata = $this->db->get('permintaan_detail')->num_rows();
        //         if($hitdata > 0){
        //             $this->db->where('pmtdtPermintaanId',$params['pmtId']);
        //             $delbrg = $this->db->delete('permintaan_detail');
        //         }else{
        //             $insert    = true;
        //         }
        //     }
        //     // alat kalibrasi
        //     if(!empty($params['pakAlatId'])){
        //         $this->db->where('pakPermintaanId',$params['pmtId']);
        //         $delbrg = $this->db->delete('permintaan_kalibrator');
        //         foreach($params['pakAlatId'] as $i => $val) {
        //             $pmt_dt = array(
        //                 'pakPermintaanId' => $params['pmtId'],
        //                 'pakAlatId' => decode($params['pakAlatId'][$i]),
        //             );
        //             $insert = $this->db->insert('permintaan_kalibrator', $pmt_dt);
        //         }
        //     }else{
        //         $this->db->where('pakPermintaanId',$params['pmtId']);
        //         $hitdata = $this->db->get('permintaan_kalibrator')->num_rows();
        //         if($hitdata > 0){
        //             $this->db->where('pakPermintaanId',$params['pmtId']);
        //             $delbrg = $this->db->delete('permintaan_kalibrator');
        //         }else{
        //             $insert    = true;
        //         }
        //     }
                
            
        // }

        return $update;
}

public function deletePermintaanDetailById($id)
{
    $this->db->where('pmtdtId',$id);
    $delbrg = $this->db->delete('permintaan_detail');
    return $delbrg;
}

public function insertDetailPermintaan($params)
{
    $pmt_dt = array(
        'pmtdtPermintaanId' => $params['pmtdtPermintaanId'],
        'pmtdtAlkesId' => $params['pmtdtAlkesId'],
        'pmtdtHarga' => str_replace('.','',$params['pmtdtHarga']),
        'pmtdtJumlahDiskon' => $params['pmtdtJumlahDiskon'],
        'pmtdtJenisDiskon' => $params['pmtdtJenisDiskon'],
        'pmtdtJumlahAlat' => $params['pmtdtJumlahAlat'],
        'pmtdtTglEdit' => date('Y-m-d H:i:s'),
        'pmtdtEditUser' => get_user_name(),
        'pmtdtTglInsert' => date('Y-m-d H:i:s'),
        'pmtdtInsertUser' => get_user_name()
    );

    $insert = $this->db->insert('permintaan_detail', $pmt_dt);
    return $insert;
}

// kalibrator
public function InsertPermintaanKalibrator($params)
{
    $pmt_dt = array(
        'pakPermintaanId' => $params['pakPermintaanId'],
        'pakAlatId' => $params['pakAlatId'],
    );
    $insert = $this->db->insert('permintaan_kalibrator', $pmt_dt);
    return $insert;
}

public function deleteKalibratorByPermintaanDetail($id)
{
    $this->db->where('pakPermintaanId',$id);
    $delbrg = $this->db->delete('permintaan_kalibrator');
    return $delbrg;
}

public function InsertDetailAlkes($params)
{
    $pmt_dt = array(
        'pdaPermintaanDetailId' => $params['pdaPermintaanDetailId'],
    );
    $insert = $this->db->insert('permintaan_detail_alat', $pmt_dt);
    return $insert;
}

public function deletePermintaanAlkes($id)
{
    $this->db->where('pdaPermintaanDetailId',$id);
    $delbrg = $this->db->delete('permintaan_detail_alat');
    return $delbrg;
}



public function insert_permintaan($params)
{
    // $this->db->trans_begin();
    // var_dump($params);die;
    // Insert Permintaan
    $pmt = array(
        'pmtPelangganId' => $params['pmtPelangganId'],
        'pmtNoOrder' => nomor_order(),
        'pmtTglPengajuan' => $params['pmtTglPengajuan'],
        'pmtTglRencanaKunjungan' => $params['pmtTglRencanaKunjungan'],
        'pmtCatatan' => $params['pmtCatatan'],
        'pmtPPN' => $params['pmtPPN'],
        'pmtLamaKunjungan' => $params['pmtLamaKunjungan'],
        'pmtBiayaKunjungan' => $params['pmtBiayaKunjungan'],
        'pmtStatusId' => 1,
        'pmtTglInsert' => date('Y-m-d H:i:s'),
        'pmtInsertUser' => get_user_name()
    );
    $insert = $this->db->insert('permintaan', $pmt);
    
    return $insert;
}

function last_insert(){
    return $this->db->insert_id();
}

public function delete($id)
{
    $this->db->where('pmtId', $id);
    return $this->db->delete($this->base_table);
}

public function delete_detil($id)
{
    $this->db->where('pmtdtId', $id);
    return $this->db->delete('permintaan_detail');
}

public function get_data_alkes($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
{
    $this->db->select("CONCAT((alkesKodeBarang),(' | '),(alkesNamaBarang)) as AlkesKodeName, alkesHargaDasar as HargaDasar, alkesKodeBarang as KodeBarang, alkesNamaBarang as NamaAlkes, alkesId");
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
            $query = $this->db->get('ref_alkes');
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results('ref_alkes');
        }
    }
}

public function get_list_detail_alkes($id)
{
    $this->db->select("alkesKodeBarang as KodeBarang, 
                        pmtdtId as id,
                        alkesNamaBarang as NamaAlkes, 
                        pmtdtAlkesId as alkesId,
                        pmtdtHarga as HargaPmt,
                        alkesHargaDasar as HargaDasar,
                        pmtdtJumlahAlat as JmlAlat,
                        pmtdtJumlahDiskon as JmlDiskon,
                        pmtdtJenisDiskon as JnsDiskon,
                        pmtdtPermintaanId as PmtId,
                    ");
    $this->db->join('ref_alkes','pmtdtAlkesId=alkesId');
    $this->db->where('pmtdtPermintaanId',$id);

    $query = $this->db->get('permintaan_detail');
    return $query->result_array();
}

public function list_alkes($id = null)
{
    $this->db->select("CONCAT((alkesKodeBarang),(' | '),(alkesNamaBarang)) as AlkesKodeName, alkesKodeBarang as KodeBarang, alkesNamaBarang as NamaAlkes, alkesId");
    if(!empty($id)){
        $this->db->where('alkesId',$id);
    }
    $query = $this->db->get('ref_alkes');
    
    return $query;
}


public function list_alat_kalibrasi_detail($id)
{
    $this->db->select("CONCAT((alatKode),(' | '),(alatNama)) as kodeName, alatId,alatKode,alatNama,alatMerk,alatNoSeri,pakPermintaanId");
    $this->db->where('pakPermintaanId',$id);
    $this->db->join('ref_alat_kalibrasi','pakAlatId=alatId');
    $query = $this->db->get('permintaan_kalibrator');

    return $query;
}

public function list_alat_kalibrasi($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
{
    $this->db->select("CONCAT((alatKode),(' | '),(alatNama)) as kodeName, alatId,alatKode,alatNama,alatMerk,alatNoSeri");
    $this->db->where('alatIsAktif',1);
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
            $query = $this->db->get('ref_alat_kalibrasi');
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results('ref_alat_kalibrasi');
        }
    }
}

public function get_total_alat($id) {
    $this->db->select_sum('pmtdtJumlahAlat');
    $this->db->where('pmtdtPermintaanId', $id);
    $query = $this->db->get('permintaan_detail');
    return $query->row_array();          
}

public function get_total($id) {
    // $this->db->select_sum('pmtdtJumlahAlat');
    $this->db->where('pmtdtPermintaanId', $id);
    $query = $this->db->get('permintaan_detail');
    return $query->num_rows();          
}

public function get_akomodasi($id) {
    $this->db->select('pmtBiayaKunjungan as akomodasi');
    $this->db->where('pmtId', $id);
    $query = $this->db->get('permintaan');
    return $query->row_array(); 
}

public function get_penawaran($id) {
    $this->db->select('
                        pmtBiayaKunjungan as akomodasi,
                        pmtTglPengajuan as tanggal,
                        pmtNoOrder as nomor,
                        count(pdaPermintaanDetailId) as jumlah,
                        pmtPPN as PPN,
                        plgnNama as pelanggan
                    ');
    $this->db->join('ref_pelanggan', 'pmtPelangganId = plgnId', 'left');
    $this->db->join('permintaan_detail', 'pmtId = pmtdtPermintaanId', 'left');
    $this->db->join('permintaan_detail_alat', 'pmtdtId = pdaPermintaanDetailId', 'left');
    $this->db->join('ref_alkes', 'pmtdtAlkesId = alkesId', 'left');
    $this->db->where('pmtId', $id);
    $query = $this->db->get('permintaan');
    return $query->row_array();
}

public function penawaran($id) {
    $this->db->select('
                        alkesNamaBarang as namaAlat,
                        pmtdtJumlahAlat as qty,
                        alkesHargaDasar as harga
                    ');
    $this->db->join('permintaan_detail', 'pmtId = pmtdtPermintaanId', 'left');
    $this->db->join('ref_alkes', 'pmtdtAlkesId = alkesId', 'left');
    $this->db->where('pmtId', $id);
    $query = $this->db->get('permintaan');
    return $query->result_array();
}


}