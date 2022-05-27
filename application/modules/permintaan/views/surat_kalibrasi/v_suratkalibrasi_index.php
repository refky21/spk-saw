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
 td, th {
   font-size: 12px !important;
 }

/* Create two equal columns that floats next to each other */
.column-1 {
  float: left;
  width: 85%;
}
.column-2 {
  float: left;
  width: 15%;
}
 .row {
  display: flex;
 }
/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

</style>
<body>
<div class="" id="common">
  <div class="container">
    <div id="page">
      <div class="logo float">
        <img src="<?= $this->config->item('base_url'); ?>assets/img/logo.png" alt="">
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
      <div class="left">
        <hr class="line">
        <br>
          <h4 class="left"><i>PERMINTAAN KALIBRASI</i></h4>
          <p>No: <?= $detail['nomor']; ?></p>
      </div>

      <br>

      <div id="main-body">
        <table class="table table-data left" width="100%">
          <tr>
            <td class="left" width="20%">
              Tanggal Permintaan 
              </br>
              Nama Pemilik
              </br>
              Alamat
              </br>
              </br>
              No. Telpon
              </br>
              Perkiraan Selesai
              </br>
            </td>
            <td class="left" width="40%" style="border-right: none; font-weight: normal; font-size: 12px;">
              <?= IndonesianDate($detail['TglAjuan']); ?>
              </br>
              <?= $detail['NamaPelanggan']; ?>
              </br>
              <?= $detail['Alamat']; ?>
              </br>
              </br>
              <?= $detail['plgnHp']; ?>
              </br>
              15 hari kerja
              </br>
            </td>
            <td class="left" width="40%" style="border-left: none; font-weight: normal; font-size: 12px;">
              Kepada Yth. <?= $detail['NamaPj']; ?>
              </br>

              </br>
              Hp. <?= $detail['plgnHp']; ?>
              </br>
              </br>

              </br>

              </br>
            </td>
          </tr>
        </table>

        <table class="table-data" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th rowspan="2">No.</th>
              <th rowspan="2">Nama Alat</th>
              <th rowspan="2">Merk/Spec</th>
              <th rowspan="2">Qty</th>
              <th rowspan="2">Biaya Satuan</th>
              <th rowspan="2" width="10%">Jumlah</th>
              <th colspan="6" width="20%">Kaji Ulang</th>
              <th rowspan="2">Kesimpulan</th>
              <th rowspan="2">Catatan Kaji Ulang</th>
            </tr>
            <tr>
              <th>A</th>
              <th>B</th>
              <th>C</th>
              <th>D</th>
              <th>E</th>
              <th>F</th>
            </tr>
          </thead>

          <tbody>
          <?php 
          $no = 1;
          $sp = 1;
          foreach ($alat as $data) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $data['NamaAlkes']; ?></td>
              <td></td>
              <td><?= $data['JmlAlat']; ?></td>
              <td class="left">Rp. <?= format_rupiah($data['HargaDasar']); ?></td>
              <td class="left">
                <?php 
                $qty = $data['JmlAlat'];
                $harga = $data['HargaDasar'];
                echo "Rp."." ". format_rupiah($qty * $harga);
                ?>
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td id="kaji-<?= $sp++; ?>" rowspan="" class="left"></td>
              <?php endforeach; ?>

            </tr>

            <tr>
              <td colspan="3" >Sub Total</td>
              <td>
                <?= $total['pmtdtJumlahAlat']; ?>
              </td>
              <td></td>
              <td class="left">Rp. 
                <?php
                $t = 0;
                foreach ($alat as $data) :
                  $qty = $data['JmlAlat'];
                  $harga = $data['HargaDasar'];
                  $total = $qty * $harga;
                  $t += $total;
                  $sum = array_sum( explode(',',$t) );
                endforeach;
                echo format_rupiah($sum);
                ?>
              </td>
              <td colspan="8" rowspan="6" class="left">
                Keterangan Kaji Ulang:
                </br>
                Diisi tanda <i>V</i>  bila sesuai dan tanda <i>X</i>  bila tidak sesuai
              </td>
            </tr>
            <tr>
              <td colspan="5" style="text-align: right;">Potongan &emsp; &emsp; 0%</td>
              <td class="left">Rp. -</td>
            </tr>
            <tr>
              <td colspan="5" style="text-align: right;">Biaya Akomodasi dan Transportasi</td>
              <td class="left">Rp. <?= format_rupiah($permintaan['akomodasi']); ?></td>
            </tr>
            <tr>
              <td colspan="5" style="text-align: right;">Dasar Penganaan Pajak</td>
              <td class="left">Rp. -</td>
            </tr>
            <tr>
              <td colspan="5" style="text-align: right;">PPN</td>
              <td class="left">Rp. 
                <?php 
                $total = $sum + $permintaan['akomodasi'];
                $jml_ppn = $detail['ppn'] / 100;
                $ppn = $sum * $jml_ppn;
                echo format_rupiah($ppn);
                
                ?>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="text-align: right;">Total</td>
              <td class="left">Rp. <?= format_rupiah($sum + $permintaan['akomodasi'] + $ppn);?></td>
            </tr>
          </tbody>
        </table>

        </br>
        </br>

        <div class="signature">
          <table width="100%">
            <tbody>
              <tr>
                <td width="50%">
                  Customer,
                  </br>
                  </br>
                  </br>
                  </br>
                  <?= $detail['NamaPj']; ?>
                </td>
                <td width="50%">
                  Penerima,
                  </br>
                  </br>
                  </br>
                  </br>
                  <?php 
                  $penerima =  getConfig(array("ConfigCode" => "defaultPenerima"))['Value']; 
                  // echo $penerima;
                  echo get_user_real_name();
                  ?>
                </td>
              </tr>
            </tbody>
          </table>

          </br>

          <table class="ttd" width="100%">
            <tbody>
            <tr>
                <td width="10%" style="font-weight: normal;">
                  FR - 016
                </td>
                <td width="90%" style="padding-right: 90px; font-weight: normal;">
                  Catatan: Lembar ini digunakan untuk pengambilan alat dan sertifikat
                </td>
              </tr>
            </tbody>
          </table>
              
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="<?= $this->config->item('base_url') . 'themes/theadmin/vendor/jquery/jquery.min.js' ?>"></script>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){
    var j = <?= $row; ?>;
    $('#kaji-1').attr('rowspan', j);
    $('#kaji-1').html(`A. Kesesuaian Ruang Linkup 
                       </br>
                       B. Kesesuaian Metode
                       </br>
                       C. Kesiapan SDM
                       </br>
                       D. Kesiapan Kalibrator
                       </br>
                       E. Cek Visual
                       </br>
                       F. Waktu Pengerjaan
                   `);

    var r = j+1;
    for (let i = 2; i < r; i++) {
      $('#kaji-'+i+'').remove();
    }
  });

</script>
