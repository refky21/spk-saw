<?php
if ( ! function_exists('kartu')){
function kartu($am="",$alatId="") {

	$index = $am-1;
	$id=$alatId[$index];
	$ci =& get_instance();
	// format 361.20.12.2021
	$ci->db->select("pdaId as id,
					pdaMerk as Merk,
					pdaTipe as Tipe,
					pdaNoSeri as NoSeri,
					pdaLokasiAlat as Lokasi,
					pdaTglKalibrasi as TglKalibrasi,
					pdaNoSertifikat as NoSertifikat,
					pdaCatatanKalibrasi as Catatan,
					DATE_ADD(pdaTglKalibrasi, INTERVAL 1 YEAR) as TglReKalibrasi
					");
	$ci->db->where('pdaId',$id);
	$alat = $ci->db->get('permintaan_detail_alat')->row_array();

	$uri = 'dashboard/detail_alat/'.encode($alat['id']);
	$KopNama =  getConfig(array("ConfigCode" => "defaultKopNama"))['Value'];
	$KopSub =  getConfig(array("ConfigCode" => "defaulKopSub"))['Value'];
	$KopAlamat =  getConfig(array("ConfigCode" => "defaultKopDetailAlamt"))['Value'];
	$KopSK =  getConfig(array("ConfigCode" => "defaultKopSK"))['Value'];
	$Pimpinan =  getConfig(array("ConfigCode" => "defaultPimpinan"))['Value'];
?>
	<table style="width:10.2cm;border:1px solid black; padding-top:4px; font-family:Arial, Helvetica, sans-serif; font-size:11px" class="kartu" border="0">
		<tbody>
			<tr>
				<td colspan="3" style="border-bottom:1px solid black; padding:2px" align="center">
					<table width="98%" class="kartu" cellpadding="0px">
						<tbody>
							<tr>
								<td><img src="http://lku.uad.ac.id/wp-content/uploads/logo1.png" height="49"></td>
								<td align="left" style="font-weight:bold;font-size:11px;">
									<?= $KopNama;?><br>
									<?= $KopSub;?></br>
									Jalan Cendana No.9A Semaki, Yogyakarta 55166</br>
									Telp.(0274) 563515 ext 1615
							</td>
							</tr>
					</tbody>
				    </table>
				</td>
			</tr>
			<tr height="10px"><td width="226">&nbsp;Telah dilakukan pengujian/kalibrasi</td></tr>
			<tr height="10px"><td width="90">&nbsp;No. Sertifikat</td><td width="8">:</td><td width="226" style="font-size:11px;"><?= $alat['NoSertifikat'];?></td></tr>
			<tr height="10px"><td>&nbsp;No. Seri</td><td>:</td><td style="font-size:11px;"><?= $alat['NoSeri'];?></td></tr>    
			<tr height="10px"><td>&nbsp;Tgl Kalibrasi</td><td>:</td><td style="font-size:11px;"><?= IndonesianDate($alat['TglKalibrasi']);?></td></tr>                      
			<tr height="10px"><td >&nbsp;Tgl Re-kalibrasi</td><td>:</td><td style="font-size:11px;"><?= IndonesianDate($alat['TglReKalibrasi']);?></td></tr>
			<tr height="10px"><td>&nbsp;Keterangan</td><td>:</td><td style="font-size:11px;"><?= $alat['Catatan'];?></td></tr>
			<tr height="10px">
				<td colspan="3" valign="top" align="right"><img src="https://chart.googleapis.com/chart?chs=500x500&chld=L|M&cht=qr&choe=UTF-8&chl=<?= $ci->config->item('url_qrcode_amk'); ?><?= $uri; ?>" height="81px" border="thin solid red">,</td>
			</tr>                   
					
			<tr style="background:#000;color:#fff;" align="center">
				<td colspan="3" align="center" width="226">DINYATAKAN AMAN UNTUK PELAYANAN</td>
			</tr>
		</tbody>
	</table>
<span class="style2"><br></span>
<?php        
}
}
?>