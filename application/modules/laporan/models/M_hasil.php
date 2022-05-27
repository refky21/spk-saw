<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_hasil extends CI_Model {
    var $base_table = 'tr_nilai';
    public function __construct()
    {
        parent::__construct();
    }

   

    public function getBahasa()
    {
        $this->db->select('pemId as id, pemNama as nama');
        $query =  $this->db->get('ref_pemrograman');

        return $query->result_array();
    }

    public function getHasil($id_pem)
    {
        $sql = "SELECT 
        hasil,
        pemNama,
        fwNama
        FROM tr_hasil 
        JOIN ref_pemrograman ON hslBhsId=pemId
        JOIN ref_framework ON hslFwId=fwId
        WHERE hasil=(SELECT MAX(hasil) FROM tr_hasil WHERE hslBhsId=?)";

        $query =  $this->db->query($sql, array($id_pem));

        return $query->row_array();
    }
    public function getFrameworkUse($id)
    {
        $this->db->select('nilaiFwId as id,nilaiBhsId as id_pem, fwNama as nama');
        $this->db->join('ref_framework','nilaiFwId=fwId');
        $this->db->where('nilaiBhsId', $id);
        $this->db->group_by('nilaiFwId');
        $query =  $this->db->get('tr_nilai');

        return $query->result_array();
    }

    public function getFramework($id = null)
    {
        $this->db->select('fwId as id, fwNama as nama, fwPmId as id_pem');
        if($id != null){
            $this->db->where('fwPmId', $id);
        }
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

    public function countKriteria()
    {
        $query = $this->db->get('ref_kriteria');

        return $query->num_rows();
    }

    public function getAlternatif($id = null)
    {
        $this->db->select('subKrtId as id , 
        subKrtNama as nama,
        subKrtValue as nilai
        ');
        $this->db->order_by('subKrtValue', 'ASC');
        if($id != null){
            $this->db->where('subKrtKriteriaId', $id);
        }

        $query = $this->db->get('ref_sub_kriteria');

        return $query->result_array();
    }

    public function getNilai($pemId= null, $fwId = null)
    {
        $this->db->select("
        nilaiId as id,
        nilaiFwId as id_fw,
        nilaiBhsId as id_bhs,
        nilaiKrtId as id_krt,
        nilaiAltrId as id_altr,
        pemNama as nama_pem,
        fwNama as nama_fw,
        kriteriaSifat as sifat,
        subKrtNama as nama_altr,
        subKrtValue as nilai_altr
        ");
        $this->db->join('ref_framework', 'fwId = nilaiFwId');
        $this->db->join('ref_pemrograman', 'pemId = fwPmId');
        $this->db->join('ref_sub_kriteria', 'subKrtId = nilaiKrtId');
        $this->db->join('ref_kriteria', 'kriteriaId = subKrtKriteriaId');
        if($pemId != null){
            $this->db->where('nilaiBhsId', $pemId);
        }
        // if($fwId != null){
        //     $this->db->where('nilaiFwId', $pemId);
        // }
        $query = $this->db->get($this->base_table);

        return $query->result_array();
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


