<?php defined('BASEPATH') OR exit('No direct access allowed'); ?>

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
 .header {
    display: flex;
    margin-left: 0;
    margin-right: 0;
  }

  .logo {
    width: 20%;
  }
  .logo img {
    border-radius: 4px;
    float: left;
    max-width: 110px;
  }

  .alamats {
    width: 80%;
  }

  #content {
    border: 2px solid #000;
    padding: 10px;
    max-width: 100%;
  }

  .keterangan {
    width: 50%;
    border: 1px solid #000;
    max-width: 50%;
    padding: 10px;
  }
  .keterangan h3 {
    font-size: 15px !important;
    font-weight: bolder !important;
  }
  .keterangan p {
    font-size: 12px !important;
  }

  td {
    font-size: 12px !important;
  }

  .garis {
    border: 1px solid #000;
    color: #000;
    background-color: #000;
  }

  .row {
    display: flex;
  }
  .column-1 {
    flex: 50%;
  }
  .column-2 {
    flex: 50%;
  }

  .jud {
    align-items: center;
  }

  .pen {
    border: 1px solid #000;
    max-width: 65%;
    text-align: center;
    margin-bottom: 5px;
    margin-left: auto;
  }
  .pena {
    border: 1px solid #000;
    max-width: 65%;
    text-align: left;
    margin-left: auto;
  }

  .ttd {
    max-width: 300px;
    text-align: center;
    margin-left: auto;
  }
  .m {
    margin-bottom: 70px;
  }


</style>
<body>
  <div id="common">
    <div class="container">
      <div id="page">
        <div class="header" width="100%">
          <div class="logo">
            <img src="<?= $this->config->item('base_url'); ?>assets/img/logo.png" alt="">
          </div>
            <?php
              $KopNama =  getConfig(array("ConfigCode" => "defaultKopNama"))['Value'];
              $KopSub =  getConfig(array("ConfigCode" => "defaulKopSub"))['Value'];
              $KopAlamat =  getConfig(array("ConfigCode" => "defaultKopDetailAlamt"))['Value'];
              $KopSK =  getConfig(array("ConfigCode" => "defaultKopSK"))['Value'];
              $Pimpinan =  getConfig(array("ConfigCode" => "defaultPimpinan"))['Value'];
            ?>
          <div class="alamats">
            <h1><?= $KopNama;?></h1>
            <h2><?= $KopSub;?></h2>
            <p><?= $KopAlamat;?></p>
            <h3><?= $KopSK;?></h3>
          </div>
        </div>

        <hr class="line">
        <hr class="garis" style="  margin-top: -0.4rem;">
        <br>

        <div id="content">

        <div class="row">
          <div class="column-1">
            <div class="jud">
              <table width="100%" style="font-size: 14px;">
                <tbody>
                  <tr>
                    <td width="10%">
                      Kepada
                      <br>
                      Up
                      <br>
                      Email
                    </td>
                    <td>
                      : <?= $tawar['pelanggan']; ?>
                      <br>
                      :
                      <br>
                      :
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="column-2">
            <div class="pen">
              <p>***PENAWARAN***</p>
            </div>
            <div class="pena">
              <table width="100%">
                <tbody>
                  <tr>
                    <td width="50%">
                      NOMOR
                      <br>
                      Tanggal
                      <br>
                      Masa Penawaran
                    </td>
                    <td>
                      : <?=  $tawar['nomor']; ?>
                      <br>
                      : <?=  $tawar['tanggal']; ?>
                      <br>
                      : 1 Bulan
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <p>Dengan hormat,</p>
        <p>Bersama ini kami sampaikan penawaran kalibrasi alat kesehatan sebagai berikut:</p>
        <br>

        <table class="table-data left" width="100%">
          <thead>
            <tr>
              <th width="10%">No.</th>
              <th>Nama Alat</th>
              <th width="5%">Jumlah</th>
              <th>Tarif</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $no = 1;
              foreach ($tawars as $data) :
            ?>
            <tr>
              <td><?= $no++; ?></td>
              <td class="left"><?= $data['namaAlat']; ?></td>
              <td><?= $data['qty']; ?></td>
              <td class="left">Rp. <?= format_rupiah($data['harga']); ?></td>
              <td class="left">Rp. 
                <?php 
                  $tarif = $data['qty'] * $data['harga'];
                  echo format_rupiah($tarif); 
                ?>
              </td>
            </tr>
            <?php 
              endforeach;
            ?>
            <tr>
              <td rowspan="4"></td>
              <td class="left">Jumlah</td>
              <td><?= $tawar['jumlah']; ?></td>
              <td></td>
              <td class="left">Rp.
                <?php 
                $t = 0;
                  foreach ($tawars as $d) :
                    $qty = $d['qty'];
                    $harga = $d['harga'];
                    $total = $qty * $harga;
                    $t += $total;
                    $sum = array_sum(explode(',',$t));
                  endforeach;
                  echo format_rupiah($sum);
                ?>
              </td>
            </tr>
            <!-- <tr>
              <td class="left" colspan="3" style="border-right: 0;">PPN</td>
              <td class="left">Rp.
                <?php 
                  // $jml_ppn = $tawar['PPN'] / 100;
                  // $ppn = $sum * $jml_ppn;
                  // echo format_rupiah($ppn);
                ?>
              </td>
            </tr> -->
            <!-- <tr>
              <td class="left" colspan="3">Biaya Akomodasi dan Transportasi</td>
              <td class="left">Rp. <?//= format_rupiah($tawar['akomodasi']); ?></td>
            </tr> -->
            <tr>
                <td class="left" colspan="3" style="font-weight: bold;">Total</td>
                <td class="left" style="font-weight: bold;">Rp.
                  <?= 
                    format_rupiah($sum);
                  ?>
                </td>
              </tr>
          </tbody>
        </table>
        <br>
        <p>Demikian penawaran kami, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <br>

        <!-- <div class="signature">
          <table width="70%">
            <tbody>
              <tr>
                <td>
                  Keuangan,
                </br>
                </br>
                </br>
                </br>
                </br>
                  <?= getConfig(array("ConfigCode" => "defaultKeuangan"))['Value'];?>
                </td>
              </tr>
            </tbody>
          </table>
        </div> -->

        <div class="ttd"> 
          <div class="m">
            <p>Keuangan</p>
          </div>
          <div class="s">
            <p><?= getConfig(array("ConfigCode" => "defaultKeuangan"))['Value'];?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= $this->config->item('base_url') . 'themes/theadmin/vendor/jquery/jquery.min.js' ?>"></script>
</body>
</html>
