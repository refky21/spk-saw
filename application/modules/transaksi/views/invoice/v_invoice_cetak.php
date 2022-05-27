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

.judul {
  width: 80px;
  height: 25px;
  background-color: #fff;
  float: right;
  margin-right: 80px;
  margin-top: -10px;
}
.judul p {
  font-size: 30px;
  font-weight: bolder;
  font-style: italic;
  text-align: center;
}

.footer {
  display: flex;
  padding: 5px;
}
.signature {
  width: 50%;
  text-align: center;
  float: center;
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

        <div class="judul">
         <p>INVOICE</p>
        </div>
        <div id="content">
          <table width="100%">
            <tbody>
              <tr>
                <td width="10%">
                  Kepada
                </br>
                  Alamat
                </br>
                </br>
                  No. Tlp
                </td>
                <td width="45%">
                  : <?= $invoice['NamaPelanggan']; ?>
                  </br>
                  : <?= $invoice['AlamatPelanggan']; ?>
                  </br>
                  </br>
                  : <?= $invoice['HpPelanggan']; ?>
                </td>
                <td width="15%">
                  Nomor Invoice
                  </br>
                  Tanggal
                  </br>
                  </br>
                  </br>

                </td>
                <td width="25%">
                  : <?= $invoice['Noinvoice'];?>
                  </br>
                  : <?= $invoice['Tglinvoice']; ?>
                  </br>
                  </br>
                  </br>
                </td>
                </td>
              </tr>
            </tbody>
          </table>

          </br>

          <table class="table-data left" width="100%">
            <thead>
              <tr>
                <th width="10%">No.</th>
                <th>Nama Alat</th>
                <th width="5%">Qty</th>
                <th>Tarif</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $no = 1;
                $nama = [];
                $temp = [];
                foreach ($data as $d) :
              ?>

              <tr>
                <td><?= $no++; ?></td>
                <td class="left"><?= $d['namaAlkes']; ?></td>
                <td><?= $d['qty']; ?></td>
                <td class="left">Rp. <?= format_rupiah($d['HargaPermintaan']); ?></td>
                <td class="left">Rp. 
                  <?php 
                    $tarif = $d['qty'] * $d['HargaPermintaan'];
                    echo format_rupiah($tarif); 
                 ?></td>
              </tr>
              <?php endforeach; ?>
              <tr>
                <td rowspan="7"></td>
                <td class="left">Jumlah</td>
                <td><?= $jumlah['jumlah']; ?></td>
                <td></td>
                <td class="left">Rp. 
                <?php
                  $t = 0;
                  foreach ($data as $alkes) :
                    $qty = $alkes['qty'];
                    $harga = $alkes['HargaPermintaan'];
                    $total = $qty * $harga;
                    $t += $total;
                    $sum = array_sum(explode(',',$t));
                  endforeach;
                  echo format_rupiah($sum);
                ?></td>
              </tr>
              <tr>
                <td class="left" colspan="2" style="border-right: 0;">Potongan</td>
                <td style="border-left: 0;  text-align: right;">0%</td>
                <td class="left">Rp.</td>
              </tr>
              <tr>
                <td class="left" colspan="3">Dasar Pengenaan Pajak</td>
                <td class="left">Rp. <?php echo format_rupiah($sum); ?></td>
              </tr>
              <tr>
                <td class="left" colspan="3">Biaya Akomodasi dan Transportasi</td>
                <td class="left">Rp. <?= format_rupiah($invoice['BiayaKunjungan']); ?></td>
              </tr>
              <tr>
                <td class="left" colspan="3">PPN</td>
                <td class="left">Rp.
                  <?php 
                  $total = $sum + $invoice['BiayaKunjungan'];
                  $jml_ppn = $invoice['PPN'] / 100;
                  $ppn = $sum * $jml_ppn;
                  echo format_rupiah($ppn);
                  ?>
                </td>
              </tr>
              <tr>
                <td class="left" colspan="3"><i>Down Payment</i>/ uang muka</td>
                <td class="left">Rp. 
				<?php 
					$tes = $sum + $invoice['BiayaKunjungan'] + $ppn - $invoice['JmlTagihan'];
					
					if($tes != 0){
						echo format_rupiah($invoice['JmlTagihan']);
					}else{
						
						echo format_rupiah(0);
					}
                    
                  ?></td>
              </tr>
              <tr>
                <td class="left" colspan="3">Total</td>
                <td class="left">Rp.
                  <?php 
					$tes = $sum + $invoice['BiayaKunjungan'] + $ppn - $invoice['JmlTagihan'];
					
					if($tes == 0){
						echo format_rupiah($invoice['JmlTagihan']);
					}else{
						echo format_rupiah($tes);
					}
                    
                  ?>
                </td>
              </tr>
            </tbody>
          </table>

          </br>

          <div class="footer">
            <div class="signature">
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
            </div>
            <div class="keterangan">
              <h3>Keterangan:</h3>
              <p>Pembayaran ditransfer ke rekening:</p>
              <p>Bank Rakyat Indonesia Cabang Yogyakarta Cikditiro</p>
              <p>a/n PT. Adi Multi Kalibrasi</p>
              <p>No. Rek: 0029-01-001643-56-6</p>
              <p>Bukti transfer dikirim ke email lku@uad.ac.id</p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
  
</body>
</html>