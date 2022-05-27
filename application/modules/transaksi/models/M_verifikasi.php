<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_verifikasi extends CI_Model {

    var $base_table = 'permintaan';

    public function __construct()
    {
        parent::__construct();
    }

    function list_data($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL)
    {
        $this->db->select('pmtId AS id, 
                            plgnNama AS NamaPelanggan, 
                            plgnContact AS NamaPj, 
                            stNama as StatusPermintaan,
                            stClass,
                            pmtCatatan as Catatan,
                            pmtNoOrder as NoOrder,
                            pmtTglPengajuan as TanggalPermintaan,
                            pmtTglRencanaKunjungan as TglKunjung,
                            pmtTglRealisasi as TglRealisasi,
                            IFNULL(COUNT(permintaan_detail.pmtdtId), 0) as totdtPermintaan,
                            ');
        $this->db->join('permintaan_detail','pmtId=pmtdtPermintaanId','left');
        $this->db->join('permintaan_detail_alat','pdaId=pdaPermintaanDetailId','left');
        $this->db->join('ref_pelanggan','pmtPelangganId=plgnId','left');
        $this->db->join('ref_status_permintaan','pmtStatusId=stId','left');
        $this->db->group_by('pmtId');
        
        if(get_user_group() != 1){
            $this->db->join('permintaan_teknisi','ptPermintaanId=pmtId','left');
            $this->db->where('ptTeknisiId',get_user_id());
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

    function list_alkes($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL,$in = NULL)
    {
        $this->db->select('pdaId AS id, 
                            pdaPermintaanDetailId AS PmtDtId, 
                            pdaMerk AS Merk, 
                            pdaTipe as Tipe,
                            pdaNoSeri as NoSeri,
                            pdaLokasiAlat as LokasiAlat,
                            pdaStatusKalibrasi as StatusKalibrasi,
                            pdaIsVerifikasi as StatusVerifikasi,
                            pdaCatatanKalibrasi as Catatan,
                            pdaJamMulaiKalibrasi as JamMulai,
                            pdaJamSelesaiKalibrasi as JamSelesai,
                            pmtdtAlkesId as AlkesId,
                            alkesNamaBarang as NamaAlkes,
                            alkesKodeBarang as KodeAlkes,
                            skNama as Status,
                            skClass as Class,
                            ');
        $this->db->join('permintaan_detail','pdaPermintaanDetailId=pmtdtId','left');
        $this->db->join('ref_alkes','pmtdtAlkesId=alkesId','left');
        $this->db->join('ref_status_kalibrasi','pdaStatusKalibrasi=skId','left');

        if(!empty($in)){
            $this->db->where_in('pdaPermintaanDetailId', $in);
        }
        
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
            $query = $this->db->get( 'permintaan_detail_alat' );
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results('permintaan_detail_alat');
        }
    }

    }

    public function list_detail_alkes($id)
    {
        $this->db->select("alkesKodeBarang as KodeBarang, 
                alkesNamaBarang as NamaAlkes, 
                alkesId,
                pmtdtId as id,
                pmtdtPermintaanId as PmtId,
                pmtdtHarga as HargaPmt,
                pmtdtJumlahAlat as JmlAlat,
                pmtdtJumlahDiskon as JmlDiskon,
                pmtdtJenisDiskon as JnsDiskon,
            ");
    $this->db->join('permintaan_detail','pmtdtPermintaanId=pmtId');
    $this->db->join('ref_alkes','pmtdtAlkesId=alkesId');
    $this->db->where('pmtId',$id);

    $query = $this->db->get($this->base_table);
    return $query;
    }
public function list_alkes_det($id)
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

public function get_list_permintaan_detail($id)
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
    $this->db->where('pmtdtId',$id);
    $query = $this->db->get('permintaan_detail');
    return $query;
}

public function upin_alat_detail($params)
{
    // update data detail dulu
    $dt = array(
        'pmtdtHarga' => $params['pmtdtHarga'],
        'pmtdtJumlahAlat' => $params['pmtdtJumlahAlat']
    );

    $this->db->where('pmtdtId',$params['pdaPermintaanDetailId']);
    $update = $this->db->update('permintaan_detail',$dt);

    if($update){
        $detail_alat = array(
                'pdaMerk' => $params['pdaMerk'],
                'pdaTipe' => $params['pdaTipe'],
                'pdaNoSeri' => $params['pdaNoSeri'],
                'pdaLokasiALat' => $params['pdaLokasiALat'],
                'pdaStatusKalibrasi' => $params['pdaStatusKalibrasi'],
                'pdaCatatanKalibrasi' => $params['pdaCatatanKalibrasi'],
                'pdaJamMulaiKalibrasi' => $params['pdaJamMulaiKalibrasi'],
                'pdaJamSelesaiKalibrasi' => $params['pdaJamSelesaiKalibrasi'],
                'pdaPermintaanDetailId' => $params['pdaPermintaanDetailId'],
                'pdaTglKalibrasi' => date('Y-m-d H:i:s'),
                'pdaUserKalibrasi' => get_user_name(),
        );
        $insert = $this->db->insert('permintaan_detail_alat',$detail_alat);
    }else{
        $insert = FALSE;
    }

    return $insert;
}

function update_status_alat($params)
{
    $data = array(
        'pdaIsVerifikasi' => $params['pdaIsVerifikasi'],
        'pdaTglVerifikasi' => date("Y-m-d H:i:s"),
        'pdaUserVerifikasi' => get_user_name(),
    );
    $this->db->where('pdaId', $params['pdaId']);
    return $this->db->update('permintaan_detail_alat', $data);
}

public function permintaan_detail_alats($id)
{
    $this->db->select("pdaId as id,
        pdaMerk as Merek,
        pdaTipe as Tipe,
        pdaNoSeri as NoSeri,
        pdaLokasiAlat as LokasiAlat,
        pdaStatusKalibrasi as StatusId,
        pdaCatatanKalibrasi as Catatan,
        pdaJamMulaiKalibrasi as JamMulai,
        pdaJamSelesaiKalibrasi as JamSelesai,
        skNama as StatusNama,
    ");
    $this->db->join('ref_status_kalibrasi','pdaStatusKalibrasi=skId','left');
    $this->db->where('pdaId',$id);
    $query = $this->db->get('permintaan_detail_alat');

    return $query->row_array();

}

public function list_ref_status_kalibrasi()
{
    $this->db->select("*");
    $query = $this->db->get('ref_status_kalibrasi');
    return $query;
}

public function update_berita($params,$id)
{
    $params = array(
        'pdaMerk' => $params['pdaMerk'],
        'pdaTipe' => $params['pdaTipe'],
        'pdaNoSeri' => $params['pdaNoSeri'],
        'pdaLokasiALat' => $params['pdaLokasiALat'],
        'pdaStatusKalibrasi' => $params['pdaStatusKalibrasi'],
        'pdaCatatanKalibrasi' => $params['pdaCatatanKalibrasi'],
        'pdaJamMulaiKalibrasi' => $params['pdaJamMulaiKalibrasi'],
        'pdaJamSelesaiKalibrasi' => $params['pdaJamSelesaiKalibrasi'],
        'pdaTglKalibrasi' => date('Y-m-d H:i:s'),
        'pdaUserKalibrasi' => get_user_name(),
    );
    $this->db->where('pdaId',$id);
    $update = $this->db->update('permintaan_detail_alat',$params);

    return $update;
}

public function get_verifikasi()
{
    $this->db->select("*");
    $query = $this->db->get('ref_status_permintaan');
    return $query;
}

public function update_permintaan($params)
{
    $par = array(
        'pmtStatusId' => $params['pmtStatusId']
    );
    $this->db->where('pmtId',$params['pmtId']);
    $update = $this->db->update('permintaan',$par);

    return $update;
}

public function getPmtAlkes($id)
{
    $this->db->select('pmtdtId as IdDetail,
                        pmtdtPermintaanId as IdPermintaan,
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


}