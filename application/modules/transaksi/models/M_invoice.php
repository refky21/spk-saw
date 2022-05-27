<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_invoice extends CI_Model {

    var $base_table = 'permintaan';

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
                            invJumlahTagihan as JumlahTagihan,
                            invTerbayar as JumlahBayar,
                            pmtNoOrder as NoOrder,
                            plgnNama as NamaPelanggan,
                            plgnContact as NamaPj,
                        ');
        $this->db->join('permintaan','pmtId=invPermintaan');
        $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
        $this->db->order_by('invId','DESC');
        
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
            $query = $this->db->get( 'invoice' );
            if ( $query->num_rows() > 0 ) return $query;
            return NULL;
        } else if($status == 'counter'){
            return $this->db->count_all_results('invoice');
        }
    }

    }

    public function permintaan_detail_alat_total($id)
    {
        $this->db->select('pdaPermintaanDetailId')->where(array(
				"pdaIsVerifikasi"=> 1,
				"skIsDikerjakan" => 1
        ));
        $this->db->join("ref_status_kalibrasi","skId=pdaStatusKalibrasi");
        $this->db->where_in('pdaPermintaanDetailId',$id);
        $query = $this->db->get('permintaan_detail_alat');
        
        return $query->num_rows();
    }

    public function permintaan_detail_harga_total($id)
    {
        // $this->db->select_sum('pmtdtHarga');
        $this->db->select_sum('pmtdtHarga');
        $this->db->where_in('pmtdtId',$id);
        $query = $this->db->get('permintaan_detail');
        
        return $query->row_array();
    }

    public function permintaan_detail($id)
    {
        $this->db->select('pmtdtId');
        $this->db->where('pmtdtPermintaanId',$id);
        $query = $this->db->get('permintaan_detail');
        
        return $query->result_array();
    }

    public function getPmt()
    {
        $sql = "SELECT 
                        pmtId as PermintaanId,
                        pmtNoOrder as NoOrder,
                        pmtTglPengajuan as TglPermintaan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
                        pmtdtHarga as HargaTotalAlat,
                        pmtTglRencanaKunjungan as TglKunjungan,
                        pmtTglRealisasi as TglRealisasi,
                        (SELECT COUNT(pdaPermintaanDetailId)
                            FROM permintaan_detail_alat 
                            JOIN ref_status_kalibrasi ON skId=pdaStatusKalibrasi
                            WHERE pdaIsVerifikasi = '1' AND skIsDikerjakan= '1' AND pdaPermintaanDetailId=pmtdtId
                        )as TotalAlat,
                        alkesNamaBarang as NamaBarang
            FROM permintaan
            JOIN permintaan_detail ON pmtdtPermintaanId=pmtId
            JOIN ref_pelanggan ON pmtPelangganId=plgnId
            JOIN ref_alkes ON alkesId = pmtdtAlkesId
            WHERE NOT pmtStatusId = '5'
            GROUP BY pmtId
        ";

        $query = $this->db->query($sql);

    return $query;
    }

    public function hitung_invoice($pmtId)
    {
        $this->db->select("(SELECT COUNT(pdaPermintaanDetailId)
		FROM permintaan_detail_alat 
		JOIN ref_status_kalibrasi ON skId=pdaStatusKalibrasi
		WHERE pdaIsVerifikasi = 1 AND skIsDikerjakan= 1 AND pdaPermintaanDetailId=pmtdtId
		)as TotalAlat,

		(SELECT COUNT(pdaPermintaanDetailId)
		FROM permintaan_detail_alat 
		JOIN ref_status_kalibrasi ON skId=pdaStatusKalibrasi
		WHERE pdaIsVerifikasi = 1 AND skIsDikerjakan= 1 AND pdaPermintaanDetailId=pmtdtId
		) * pmtdtHarga as TotalHarga,
		pmtdtHarga,
		pmtdtAlkesId,
		alkesNamaBarang
		");
		$this->db->join('ref_alkes','pmtdtAlkesId = alkesId');
		$this->db->where('pmtdtPermintaanId', $pmtId);

		$data = $this->db->get('permintaan_detail')->result_array();

        return $data;

    }
public function getListPermintaan()
{
    $this->db->select("pmtId as PermintaanId,
                        pmtNoOrder as NoOrder,
                        pmtTglPengajuan as TglPermintaan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
    ");
    $this->db->select_sum("permintaan_detail.pmtdtHarga","HargaDetailAlat");
    $this->db->group_by("pmtId");
    $this->db->join("permintaan_detail","pmtdtPermintaanId=pmtId");
    $this->db->join("ref_pelanggan","pmtPelangganId=plgnId");
    $this->db->join("ref_status_permintaan","pmtStatusId=stId");
    $this->db->where('pmtStatusId !=',5);

    $query = $this->db->get($this->base_table);

    return $query;
}

public function detail_invoice($id)
{
    
        $sql = "SELECT 
                        pmtId as PermintaanId,
                        pmtNoOrder as NoOrder,
                        pmtTglPengajuan as TglPermintaan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
                        pmtdtHarga as HargaTotalAlat,
                        pmtTglRencanaKunjungan as TglKunjungan,
                        pmtTglRealisasi as TglRealisasi,
                        (SELECT COUNT(pdaId)
                            FROM permintaan_detail_alat 
                            JOIN ref_status_kalibrasi ON skId=pdaStatusKalibrasi
                            WHERE pdaIsVerifikasi = '1' AND skIsDikerjakan= '1'
                        )as TotalAlat
            FROM permintaan
            JOIN permintaan_detail ON pmtdtPermintaanId=pmtId
            JOIN ref_pelanggan ON pmtPelangganId=plgnId
            JOIN ref_alkes ON alkesId = pmtdtAlkesId
            WHERE pmtId = ?
            GROUP BY pmtId
        ";

        $query = $this->db->query($sql,$id);

    return $query;
}

public function ambil_invoice($id)
{
    $this->db->select("invPermintaan as PermintaanId,
                        pmtNoOrder as NoOrder,
                        pmtTglPengajuan as TglPermintaan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
                        invJumlahTagihan as JmlTagihan,
    ");
    $this->db->select_sum("permintaan_detail.pmtdtHarga","HargaDetailAlat");
    $this->db->group_by("pmtId");
    $this->db->join("permintaan","pmtId=invPermintaan");
    $this->db->join("permintaan_detail","pmtdtPermintaanId=pmtId");
    $this->db->join("ref_pelanggan","pmtPelangganId=plgnId");

    $this->db->where('invId',$id);

    $query = $this->db->get('invoice');

    return $query;
}

public function cek_total_nominal($id)
{
    $this->db->select_sum("invJumlahTagihan","JmlTagihan");
    $this->db->where('invPermintaan',$id);

    $query = $this->db->get('invoice');

    return $query;
}



public function insert_invoice($params)
{
    $dt = array(
				'invPermintaan'   => $params['invPermintaan'],
				'invNoInvoice' => $params['invNoInvoice'],
				'invTanggal' => $params['invTanggal'],
				'invJumlahTagihan' => $params['invJumlahTagihan'],
				'invJumlahDP' => $params['invJumlahDP'],
				'invTglInsert' => date("Y-m-d H:i:s"),
				'invInsertUser' => get_user_name(),
            );
    $query = $this->db->insert('invoice', $dt);
        return ($this->db->affected_rows() > 0);
}

public function update_nominal($params)
{
        $dt = array(
            'invJumlahTagihan' => $params['invJumlahTagihan'],
            'invTglEdit' => date("Y-m-d H:i:s"),
			'invEditUser' => get_user_name(),
        );

        $this->db->where('invId',$params['invId']);
        $update = $this->db->update("invoice",$dt);
        return $update;
}


public function update_status_permintaan($params)
{
        $dt = array(
            'pmtStatusId' => $params['pmtStatusId'],
        );

        $this->db->where('pmtId',$params['pmtId']);
        $update = $this->db->update($this->base_table,$dt);
        return $update;
}

public function cetakInvoice($id) {
    $this->db->select(" 
                        invPermintaan as PermintaanId,
                        invJumlahTagihan as JmlTagihan,
                        invJumlahDP as JmlTagihanDP,
                        invTanggal as Tglinvoice,
                        invNoInvoice as Noinvoice,
                        pmtNoOrder as NoOrder,
                        pmtTglPengajuan as TglPermintaan,
                        pmtPPN as PPN,
                        pmtBiayaKunjungan as BiayaKunjungan,
                        plgnNama as NamaPelanggan,
                        plgnAlamat as AlamatPelanggan,
                        plgnHp as HpPelanggan
                    ");
    $this->db->group_by("pmtId");
    $this->db->join("permintaan","pmtId=invPermintaan");
    $this->db->join("permintaan_detail","pmtdtPermintaanId=pmtId");
    $this->db->join("ref_pelanggan","pmtPelangganId=plgnId");

    $this->db->where('invId',$id);

    $query = $this->db->get('invoice');

    return $query;
}

public function dataInvoice($id) {
    $this->db->select(" 
                        alkesNamaBarang as namaAlkes,
                        alkesHargaDasar as tarifAlkes,
                        pmtdtHarga as HargaPermintaan,
                        pmtdtJumlahAlat as qtyAlkes,
                        count(pdaPermintaanDetailId) as qty,
                        ");

    $this->db->group_by('alkesId');
    $this->db->join("permintaan", "pmtId = invPermintaan", 'left');
    $this->db->join("permintaan_detail", "pmtId = pmtdtPermintaanId", 'left');
    $this->db->join("ref_alkes", "alkesId = pmtdtAlkesId", 'left');
    $this->db->join('permintaan_detail_alat', 'pmtdtId = pdaPermintaanDetailId', 'left');
    $this->db->join('ref_status_kalibrasi', 'pdaIsVerifikasi = skId');
    $this->db->where('pdaIsVerifikasi', 1);
    $this->db->where('pdaStatusKalibrasi', 1);
    $this->db->where('skIsDikerjakan', 1);
    $this->db->where('invId',$id);

    $query = $this->db->get('invoice');
    return $query;
}

public function jumlah($id) {
    $this->db->select('
                        count(pdaPermintaanDetailId) as jumlah
                    ');

    $this->db->join('permintaan', 'pmtId = invPermintaan', 'left');
    $this->db->join('permintaan_detail', 'pmtdtPermintaanId = pmtId', 'left');
    $this->db->join('permintaan_detail_alat', 'pmtdtId = pdaPermintaanDetailId', 'left');
    $this->db->join('ref_status_kalibrasi', 'pdaIsVerifikasi = skId');
    $this->db->where('pdaIsVerifikasi', 1);
    $this->db->where('pdaStatusKalibrasi', 1);
    $this->db->where('skIsDikerjakan', 1);
    $this->db->where('invId', $id);
    $query = $this->db->get('invoice');
    return $query->row_array();
}

public function getTeknisi($id)
{
    $this->db->select('ptPermintaanId as id,
                            ptTeknisiId as teknisiId,
                            UserRealName as NamaTeknisi,
                            UserHp as HpTeknisi,
                            GroupName as Jabatan,
                            GroupDescription as Keterangan,
                        ');
        $this->db->join('sys_user','ptTeknisiId=UserId');
        $this->db->join('sys_user_group','UserGroupUserId=UserId');
        $this->db->join('sys_group','UserGroupGroupId=GroupId');
        $this->db->where('ptPermintaanId',$id);

        $query = $this->db->get('permintaan_teknisi');


        return $query->result_array();
}

}