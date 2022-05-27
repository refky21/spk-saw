<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_suratugas extends CI_Model {
    var $base_table = 'permintaan_teknisi';
    public function __construct()
    {
        parent::__construct();
    }

    public function list_teknisi($object = array(), $limit = NULL, $offset = NULL, $order = array(), $status = NULL,$id)
    {
        $this->db->select('ptPermintaanId as id,
                            ptTeknisiId as teknisiId,
                            UserRealName as NamaTeknisi,
                            UserHp as HpTeknisi,
                            GroupName as Jabatan,
                            GroupDescription as Keterangan,
                            plgnNama as NamaPelanggan,
                        ');
        $this->db->join('sys_user','ptTeknisiId=UserId');
        $this->db->join('sys_user_group','UserGroupUserId=UserId');
        $this->db->join('sys_group','UserGroupGroupId=GroupId');

        $this->db->join('permintaan','ptPermintaanId=pmtId');
        $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
        $this->db->where('ptPermintaanId',$id);
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

public function insert_teknisi($params)
{
        $query = $this->db->insert($this->base_table, $params);
        return ($this->db->affected_rows() > 0);
}

public function get_tugas_teknisi($id = null)
{
    $this->db->select("*");
    $this->db->where('ptPermintaanId',$id);
    $query = $this->db->get($this->base_table);

    return $query->result_array();
}

public function get_list_teknisi($id = null)
{
    $this->db->select("UserId as id,UserRealName as NamaTeknisi");
    $this->db->join('sys_user_group','UserGroupUserId=UserId');
    $this->db->where_in('UserGroupGroupId',array('2','3'));
    if(!empty($id)){
        $this->db->where_not_in('UserId',$id);
    }
    $query = $this->db->get('sys_user');

    return $query->result_array();
}

public function delete($id,$teknisi)
{
    $this->db->where(array(
        'ptPermintaanId' => $id,
        'ptTeknisiId' => $teknisi
    ));
    return $this->db->delete($this->base_table);
}

public function cetak($id) {
    $this->db->select('plgnNama as NamaPelanggan, pmtTglRencanaKunjungan');
    $this->db->join('permintaan','ptPermintaanId=pmtId');
    $this->db->join('ref_pelanggan','pmtPelangganId=plgnId');
    $this->db->where('ptPermintaanId',$id);
    return $this->db->get($this->base_table)->row_array();

}




}