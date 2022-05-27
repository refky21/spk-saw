<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
    <title><?= $title; ?></title>  
    <link rel="stylesheet" media="print" href="<?php echo $this->config->item('base_url') ?>assets/css/cetak_print.css">     
    <link rel="stylesheet" media="screen" href="<?php echo $this->config->item('base_url') ?>assets/css/cetak_screen.css"/>
<style>

</style>
</head>

<body>
    <div id="common">
            <div class="container">
                <div id="page">
                    <div>
                        <div class="logo float">
                            <img src="<?php echo $this->config->item('base_url') ?>assets/img/logo.png">
                        </div>
                        <?php
                            $KopNama =  getConfig(array("ConfigCode" => "defaultKopNama"))['Value'];
                            $KopSub =  getConfig(array("ConfigCode" => "defaulKopSub"))['Value'];
                            $KopAlamat =  getConfig(array("ConfigCode" => "defaultKopDetailAlamt"))['Value'];
                            $KopSK =  getConfig(array("ConfigCode" => "defaultKopSK"))['Value'];
                            $Pimpinan =  getConfig(array("ConfigCode" => "defaultPimpinan"))['Value'];
                        ?>
                        <div class="alamat">
                            <h1><?= $KopNama;?></h1>
                            <h2><?= $KopSub;?></h2>
                            <p><?= $KopAlamat;?></p>
                            <h3><?= $KopSK;?></h3>
                        </div>
                    </div>
                    <div id="header">
                        <hr class="line">
                        <br>
                        <u>
                            <h4>DAFTAR ALAT YANG AKAN DI KALIBRASI</h4>
                        </u>
                        <p>Nomor Order : <?= $berita['nomor']; ?></p>
                        <hr class="line">
                    </div>

                    <div id="main-body">
                        <table cellspacing="1%" cellpadding="2%">
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td><?= $berita['NamaPelanggan']; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td><?= $berita['Alamat']; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>No. Telepon</td>
                                <td><?= $berita['plgnHp']; ?></td>
                            </tr>
                            <tr>
                                <td>Contact Person</td>
                                <td><?= $berita['PenanggungJawab']; ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pekerjaan</td>
                                <td><?= Indonesiandate($berita['TglKunjungan']); ?></td>
                            </tr>
                        <table>
                        <hr class="line">
                        <div class="left">
                            <table class="table-data"  cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Alat Kesehatan</th>
                                        <th>Yg Diajukan</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach ($alkes as $a) :
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="left"><?= $a['NamaAlkes']; ?></td>
                                        <td><?= $a['JumlahAlat']; ?></td>
                                        <?php  endforeach; ?>
                                    </tr> 
                                </tbody>
                            </table>
                            <div class="box">
                                <div class="title">Catatan : </div>
                                <div class="isi">
                                    <p>&nbsp;. <?= $berita['Catatan']; ?></p>
                                </div>
                            </div>
    <br>
                            <!-- ttd -->
                            <div class="signature">
                  <table width="100%">
                     <tbody><tr>
                        <td colspan="3" valign="top">
                       Pelanggan                        </td>
                     </tr>
                     <tr class="signature">
                        <td width="45%" valign="top">
                           Tanda Tangan & Cap                           <br>
                           <br>
                           <br>
                           <br>
                           <br>
                           <br>
                           <hr>                        </td>
                        <td width="5%"></td>
                        <td width="45%" valign="top">
                          Koordinator Teknis                          <br>
                          Tanda Tangan
                           <br>
                           <br>
                           <br>
                           <br>
                           <br>
                           <hr>
                        </td>
                     </tr>
                  </tbody></table>

                     
                     
                  </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>


</body>
</html>