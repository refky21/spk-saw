<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('userdata'))
{
   function userdata($field)
   {
      $ci =& get_instance();
      return $ci->session->userdata($field);
   }
}

if ( ! function_exists('unset_userdata'))
{
   function unset_userdata()
   {
      $ci =& get_instance();
      $data = array('daerah','cabang','nama','nik','glr_depan','glr_belakang','tempat_lahir','tgl_lahir','jenis_kelamin','status_kawin','email','telp','profesi','profesi_lain','pekerjaan','tempat_kerja','step','prev','alamat','propinsi','kabupaten','kecamatan','kelurahan','kodepos','pendidikan','jurusan','is_pesantren','bahasa','org','org_lain','tgl_daftar');
      return $ci->session->unset_userdata($data);
   }
}

if ( ! function_exists('protect_shelter'))
{
    function protect_shelter()
    {
        $ci=& get_instance();
        return $ci->authentication->protect_shelter();
    } 
}



if (!function_exists('set_selected'))
{
    function set_selected($field, $value)
    {
        $ci =& get_instance();
        $usrdt = $ci->session->userdata($field);
        if (set_value($field) != '') {
            $selected = set_select($field, $value);
        } else {
            $selected = ($usrdt == $value) ? 'selected = "selected"' : '';    
        }

        return $selected;
    }
}

if (!function_exists('getBobot'))
{
    function getBobot($pemId = null, $krtId = null)
    {
        $ci=& get_instance();
        $ci->load->database(); 
        
        $sql ="SELECT bbtValue AS bobot
        FROM tr_bobot
        WHERE bbtBhsId = ? AND bbtKrtId = ?
        LIMIT 1
        ";
        $query =  $ci->db->query($sql, array($pemId,$krtId))->result_array();
        return $query[0]['bobot'];
       
            }
}



function simpanHasil($id_supplier,$hasil,$pem_id){
    // $queryCek="SELECT hasil FROM hasil WHERE id_supplier='$id_supplier' AND id_jenisbarang='$this->idCookie'";
    $ci=& get_instance();
    $ci->load->database(); 

    $queryCek = "SELECT hasil from tr_hasil WHERE hslBhsId = '$pem_id' AND hslFwId = '$id_supplier'";
    $execute = $ci->db->query($queryCek);
    // $execute = $ci->db->select('hasil')->from('tr_hasil')->where('hslFwId',$id_supplier)->where('hslBhsId',$pem_id);

    // print_r($execute);die;
    // $execute=$this->getConnect()->query($queryCek);
    if ($execute->num_rows() > 0) {
        $data = array(
            'hasil'=>$hasil
        );
        // $querySimpan="UPDATE hasil SET hasil='$hasil' WHERE id_supplier='$id_supplier' AND id_jenisbarang='$this->idCookie'";
        $querySimpan= $ci->db->where('hslFwId',$id_supplier)->where('hslBhsId', $pem_id)->update('tr_hasil', $data);
    }else{
        $data = array(
            'hasil'=>$hasil,
            'hslFwId'=>$id_supplier,
            'hslBhsId'=>$pem_id
        );
        // $querySimpan="INSERT INTO hasil(hasil,id_supplier,id_jenisbarang) VALUES ('$hasil','$id_supplier','$this->idCookie')";
        $querySimpan = $ci->db->insert('tr_hasil',$data);
    }
    // $execute=$this->getConnect()->query($querySimpan);
    return $querySimpan;

}
        
if (!function_exists('getNilaiMatriks'))
{
    function getNilaiMatriks($pemId = null, $fwId = null)
    {
        $ci=& get_instance();
        $ci->load->database(); 
        
        $sql ="
        SELECT subKrtValue AS nilai,
	kriteriaSifat AS sifat,
	nilaiKrtId AS id_kriteria
        FROM tr_nilai 
        INNER JOIN ref_sub_kriteria ON nilaiAltrId=subKrtId 
        INNER JOIN ref_kriteria ON nilaiKrtId=kriteriaId
        WHERE 
        nilaiBhsId= ? AND 
        nilaiFwId=?
        ";
        return  $ci->db->query($sql, array($pemId,$fwId))->result_array();
        
        // $ci->db->select("subKrtValue as nilai");
        // $ci->db->join('ref_sub_kriteria', 'nilaiAltrId=subKrtId');
        // if($pemId != null){
            //     $ci->db->where('nilaiBhsId', $pemId);
            // }
            // if($fwId != null){
                //     $ci->db->where('nilaiFwId', $pemId);
                // }
                // $query = $ci->db->get('tr_nilai');
                
                // return $ci->result_array();
                
                // return $selected;
            }
        }
        
if (!function_exists('normalisasi'))
{
    function normalisasi($array,$sifat,$nilai){
        if ($sifat=='Benefit'){
            $result=$nilai/max($array);
        }elseif ($sifat=='Cost'){
            $result=min($array)/$nilai;
        }
        return round($result,3);
    }
}
if (!function_exists('getBobot'))
{
    function getBobot($id_kriteria){
        $ci=& get_instance();
        $ci->load->database(); 


    }
}

function getArrayNilai($id_kriteria, $pem_id){
    $ci=& get_instance();
        $ci->load->database(); 
    $data=array();
    // $queryGetArrayNilai="SELECT nilai_kriteria.nilai AS nilai FROM nilai_supplier INNER JOIN nilai_kriteria ON nilai_supplier.id_nilaikriteria=nilai_kriteria.id_nilaikriteria WHERE nilai_supplier.id_kriteria='$id_kriteria' AND nilai_supplier.id_jenisbarang='$this->idCookie'";
    $queryGetArrayNilai="SELECT subKrtValue AS nilai
        FROM tr_nilai 
        INNER JOIN ref_sub_kriteria ON nilaiAltrId=subKrtId
        WHERE 
        nilaiKrtId=? AND 
        nilaiBhsId=?";
    // $execute=$this->getConnect()->query($queryGetArrayNilai);
    $execute = $ci->db->query($queryGetArrayNilai, array($id_kriteria, $pem_id))->result_array();
    foreach ($execute as $key => $row) {
        array_push($data,$row['nilai']);
    }
    // while ($row=$execute->fetch_array(MYSQLI_ASSOC)) {
    //     array_push($data,$row['nilai']);
    // }
    return $data;
}

        if (!function_exists('radio_selected'))
{
    function radio_selected($field, $value)
    {
        $ci =& get_instance();
        $usrdt = $ci->session->userdata($field);
        if (set_value($field) != '') {
            $selected = set_radio($field, $value);
        } else {
            $selected = ($usrdt == $value) ? 'checked' : '';    
        }

        return $selected;
    }
}


if ( ! function_exists('encode'))
{
  function encode($str = NULL)
  {
     $ci =& get_instance();
     if( $ci->config->item('app_encrypt_mode') ==  TRUE){
        $ci->load->library('encrypt');
        $ci->encrypt->set_mode(MCRYPT_MODE_CFB);
        //$ci->encrypt->set_cipher($ci->config->item('app_set_cipher'));
        $enc = str_replace('=', '',$ci->encrypt->encode($str));

        return strtr($enc, array('+' => '_','/'=>'-')) ;
     } else {
        $sec = $ci->config->item('s3cUr1ty');
        $key = sha1($sec);
        $strLen = strlen($str);
        $keyLen = strlen($key);
        $j = 0;
        $hash ="";
        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($str,$i,1));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
        }
        return $hash;
     }

  }
}

if ( ! function_exists('decode'))
{
  function decode($str = NULL)
  {
     $ci =& get_instance();
     if( $ci->config->item('app_encrypt_mode') ==  TRUE){
        $ci->load->library('encrypt');
        $ci->encrypt->set_mode(MCRYPT_MODE_CFB);
        //$ci->encrypt->set_cipher($ci->config->item('app_set_cipher'));
        $pad = strlen($str) % 4;
        if ($pad) {
            $padlen = 4 - $pad;
            $str .= str_repeat('=', $padlen);
        }
        return $ci->encrypt->decode(strtr($str, array('_' => '+','-'=>'/')));
     } else {
        $sec = $ci->config->item('s3cUr1ty');
        $key = sha1($sec);
        $strLen = strlen($str);
        $keyLen = strlen($key);
        $j = 0;
        $hash = "";
        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($str,$i,2)),36,16));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $hash .= chr($ordStr - $ordKey);
        }
        return $hash;
     }

  }
}

if ( ! function_exists('IndonesianDate'))
{
    function IndonesianDate($strDate, $day = false)
    {
        if (is_null($strDate)) return;
        $hari = array("null", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Ahad");
        $date = explode("-", nice_date($strDate, 'd-n-Y'));
        $bln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
                    'September','Oktober','November','Desember');
        $today = ($day) ? $hari[nice_date($strDate, 'N')] . ', ' : '';
        if($date[0] != 'Invalid Date')
        {
            return $today . $date[0].' '.$bln[$date[1]-1].' '.$date[2];
        }
        else
        {
            return '-';
        }
    }
}

// Custom

if ( ! function_exists('format_rupiah')){
    function format_rupiah($number, $decimal_point = ',', $thousand_seperator = '.'){
        if (floatval($number) == (int)$number){
            $number = number_format($number, 0, $decimal_point, $thousand_seperator);
        } else {
            $number = rtrim($number, '.0');
            $number = number_format($number, strlen(substr(strrchr($number, '.'), 1)), $decimal_point, $thousand_seperator);
        }
        return $number;
    }
}

if ( ! function_exists('nomor_order')){
    function nomor_order($tgl=null){
        $ci =& get_instance();

        $tgls = date("Y-m-d");
        $tgl=explode("-",$tgls);
        // format 361.20.12.2021
        $ci->db->select('pmtNoOrder as NoOrder');
        $ci->db->order_by('pmtId','DESC');
        $permintaan = $ci->db->get('permintaan')->row_array();
        if($permintaan != null){
            $noOr = explode(".",$permintaan['NoOrder']);
            $num = $noOr[0] + 1;
            $length = strlen($num);

            if($noOr[3] != $tgl[0]){
                $no_order = "001.".$tgl[2].".".$tgl[1].".".$tgl[0];
            }elseif($length == 1){
                $no_order = "00".$num.".".$tgl[2].".".$tgl[1].".".$tgl[0];
            }else if ($length == 2) {
                $no_order = "0".$num.".".$tgl[2].".".$tgl[1].".".$tgl[0];
            }else if ($length == 3) {
                $no_order = $num.".".$tgl[2].".".$tgl[1].".".$tgl[0];
            }
        }else{
            $no_order = "001.".$tgl[2].".".$tgl[1].".".$tgl[0];
        }


        return $no_order;


    }
}

if ( ! function_exists('getConfig')){
    function getConfig($where = null){

        // var_dump($where);
        $ci =& get_instance();
        $ci->db->select('ConfigCode as Config, ConfigName as Name, ConfigValue as Value');
        if(!empty($where)){
            $ci->db->where($where);
        }
        

        $config = $ci->db->get('sys_config');



        return $config->row_array();
    }
}

if ( ! function_exists('nomor_invoice')){
    function nomor_invoice($tgl=null){
        $ci =& get_instance();

        $year = date("y");
        // format 361.20.12.2021
        $ci->db->select('invNoInvoice as Invoice');
        $ci->db->order_by('invId','DESC');
        $permintaan = $ci->db->get('invoice')->row_array();
        if($permintaan != null){
            $noOr = explode("/",$permintaan['Invoice']);
            $num = $noOr[0] + 1;
            $length = strlen($num);

            if($noOr[3] != $year){
                $no_order = "001/AMK-INV/VI/".$year;
            }elseif($length == 1){
                $no_order = "00".$num."/AMK-INV/VI/".$year;
            }else if ($length == 2) {
                $no_order = "0".$num."/AMK-INV/VI/".$year;
            }else if ($length == 3) {
                $no_order = $num."/AMK-INV/VI/".$year;
            }
        }else{
            $no_order = "001/AMK-INV/VI/".$year;
        }


        return $no_order;


    }
}
//


if (! function_exists('push_array')) 
{
    function push_array($src,$in,$pos){
        if(is_int($pos)) {
            $array = array_merge(array_slice($src,0,$pos), $in, array_slice($src,$pos));
        } else {
            foreach($src as $k => $v){
                if($k == $pos) $array = array_merge($src,$in);
                $array[$k]=$v;
            }
        }

        return $array;
    }
}
