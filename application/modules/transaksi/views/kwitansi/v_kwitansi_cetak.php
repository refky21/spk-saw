<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>

  <link rel="stylesheet" media="print" href="<?= $this->config->item('base_url') ?>assets/css/cetak_print.css">
  <link rel="stylesheet" media="screen" href="<?= $this->config->item('base_url') ?>assets/css/cetak_screen.css">
</head>
<style>
  .garis {
    border: 1px solid #000;
    color: #000;
    background-color: #000;
  }
</style>
<body>
  <div id="common">
    <div class="container">
      <div id="page">
        <div class="header" width="70%">
          <table class="table-data" width="100%">
            <tbody>
              <tr>
                <td rowspan="5">
                  <img src="<?= $this->config->item('base_url'); ?>assets/img/logo.png" alt="">
                </td>
                <td rowspan="5" class="left">
                  <?php
                  $KopNama =  getConfig(array("ConfigCode" => "defaultKopNama"))['Value'];
                  $KopSub =  getConfig(array("ConfigCode" => "defaulKopSub"))['Value'];
                  $KopAlamat =  getConfig(array("ConfigCode" => "defaultKopDetailAlamt"))['Value'];
                  $KopSK =  getConfig(array("ConfigCode" => "defaultKopSK"))['Value'];
                  $Pimpinan =  getConfig(array("ConfigCode" => "defaultPimpinan"))['Value'];
                  ?>
                  <b><?= $KopNama; ?></b>
                  <br>
                  <b><?= $KopSub; ?></b>
                  <!-- <P>Jl. Cendana No 9A, Semaki, Yogyakarta 55166 Telp: (0274)563515 ext. 1615</P> -->
                  <p><?= $KopAlamat; ?></p>
                  <b><?= $KopSK; ?></b>
                </td>
              </tr>
             
            </tbody>
          </table>
          <br>
          <br>
          <p style="font-size: 26px;"><b>KWITANSI</b></p>
          <br>
          <br>
          <table width="100%" style="font-weight: bold; font-style: italic;">
            <tr>
              <td width="20%">Nomor</td>
              <td>: <?= $cetak['Invoice']?></td>
            </tr>
            <tr>
              <td width="20%"><br>Sudah diterima dari</td>
              <td>: <?= $cetak['NamaPelanggan']; ?> </td>
            </tr>
            <tr>
              <td width="20%"><br>Terbilang</td>
              <td>: <?= penyebut($cetak['JumlahBayar']); ?> rupiah</td>
            </tr>
            <tr>
              <td width="20%"><br>Untuk membayar</td>
              <td>: Biaya Kalibrasi Alat Kesehatan Sesuai Invoice Nomor : <?= $cetak['Invoice']; ?></td>
            </tr>

           
          </table>
          <br>
          <br>
          <hr class="garis">
          <table width="100%">
            <tr>
              <td width="15%" style="font-weight: bold; font-style: italic;">Jumlah</td>
              <td width="20%" style="font-weight: bold; font-style: italic;">Rp. <?= format_rupiah($cetak['JumlahBayar']); ?></td>
              <td width="65%" style="text-align: center;">Yogyakarta, <?= IndonesianDate(date('d-M-Y')); ?></td>
            </tr>
          </table>
          <hr class="left" style="border: 1px solid #000; color: #000; background-color: #000; width: 35%; margin-left: 0;">
          <br>
          <br>
          <br>
          <table width="100%">
            <tr>
              <td width="15%"></td>
              <td width="20%"></td>
              <td width="65%" style="text-align: center;"><?php echo get_user_real_name(); ?></td>
            </tr>
          </table>
          <br>
<!-- 
          <table width="100%">
            <tr>
              <td width="50%">
                Tanggal Pengesahan:
                <br>
                <br>
                Direktur Utama:
                <br>
                <br>
                <?php 
                $Pimpinan =  getConfig(array("ConfigCode" => "defaultPimpinan"))['Value']; 
                echo $Pimpinan;
                ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 1px solid #989898; color: #989898; background-color: #989898; width: 35%; margin-left: 0;">
              </td>
              <td width="50%">
                <span style="border: 1px solid #989898; padding: 4px;"><?= IndonesianDate(date('d-M-Y')); ?></span>
                <br>
                <br>
                Tanda Tangan
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <hr style="border: 1px solid #989898; color: #989898; background-color: #989898; width: 35%; margin-left: 0;">
              </td>
            </tr>
          </table>
          <br>
          <p>History atau komentar kendali dokumen</p>
          <p><u>Versi</u> &nbsp; &nbsp; &nbsp;<u>Tanggal Revisi</u> &#160;&#160;&#160;  <u>Komentar Perubahan</u> &#160;&#160;&#160;&#160;&#160;&#160; <u>Direvisi oleh:</u></p>
           -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>