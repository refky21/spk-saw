
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title><?= $title;?></title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            -webkit-print-color-adjust: exact;
        }

        .krs_box {
            border: 1px solid #000;
        }

        .krs_box * {
            text-align: center;
            padding: 0 1px;
        }

        .krs_box td,
        .krs_box th {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .krs_box th {
            font-size: 12px;
        }

        .tl {
            text-align: left;
            padding-left: 10px
        }

        .tc {
            text-align: center;
        }

        .tr {
            text-align: right;
        }

        .tj {
            text-align: justify;
        }

        .fb {
            font-weight: bold;
        }

        .line {
            border-bottom: 1px dashed #000;
            clear: both;
        }
    </style>
</head>

<body cz-shortcut-listen="true">
    <div style="margin:0 auto;width:800px;">
        <br><br>
        <table align="center" width="800" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td><img src="http://lku.uad.ac.id/wp-content/uploads/logo1.png" height="50" width="180"></td>
                    <td width="350" style="font-weight:bold;text-align:center;">

                        <div style="font-size:16px;font-family:Times New Roman,Times,serif">BUKTI KALIBRASI ALAT
                        </div>
                        <div style="font-size:12px;">PT Adi Multi Kalibrasi</div>
                    </td>
                    <td style="font-size:11px;text-align:right;" valign="top">
                        <div style="font-weight: bold;">ALAMAT</div>
                        <div>
                            Jalan Cendana No.9A Semaki, Yogyakarta 55166
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table border="0" width="800" cellspacing="0" cellpadding="0" align="center">
            <tbody>
                <tr>
                    <td width="250">Nama Pelanggan</td>
                    <td>:</td>
                    <td><B><?= $dt['NamaPelanggan'];?></B></td>
                    <td width="190">STATUS</td>
                    <td width="12">:</td>
                    <td><B><?= $dt['Status'];?></B></td>
                </tr>
                <tr>
                    <td width="250">Penanggung Jawab</td>
                    <td>:</td>
                    <td><?= $dt['PenanggungJawab'];?></td>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td><?= $dt['Contact'];?></td>
                </tr>
                <tr>
                    <td width="80">Alamat</td>
                    <td width="12">:</td>
                    <td width="470"><?= $dt['Alamat'];?></td>

                    <td>Tanggal Cetak / IP</td>
                    <td>:</td>
                    <td width="270"> <?= date('Y-m-d H:i:s');?> / <?= $this->input->ip_address(); ?></td>
                </tr>
                <tr>
                    <td>Nama Alat</td>
                    <td>:</td>
                    <td><B><?= $dt['NamaAlkes'];?></B></td>
                    <td>Kode Alkes</td>
                    <td>:</td>
                    <td><?= md5($dt['KodeAlkes']);?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table width="800" style="font-size: 1.1em;" align="center" border="0" cellpadding="0" cellspacing="0"
            class="krs_box">
            <tbody>
                <tr>
                    <td class="tl" style="padding: 8px;">ID Alat</td>
                    <td class="tl"><?= sha1(encode(md5($dt['id'])));?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">No Order</td>
                    <td class="tl"><B><?= $dt['NomorOrder'];?></B></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">No Sertifikat</td>
                    <td class="tl"><B><?= $dt['NoSertifikat'];?></B></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Status Kalibrasi</td>
                    <td class="tl" style="background:#f2f2f2"><B><?= $dt['Status'];?></B></td>
                </tr>
                 <tr>
                    <td class="tl" style="padding: 8px;">Merek</td>
                    <td class="tl"><?= $dt['Merk'];?></td>
                </tr>

                <tr>
                    <td class="tl" style="padding: 8px;">Tipe</td>
                    <td class="tl"><b><?= $dt['Tipe'];?></b></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">No Seri Alat</td>
                    <td class="tl"><?= $dt['NoSeri'];?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Lokasi Alat</td>
                    <td class="tl"><?= $dt['Lokasi'];?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Catatan</td>
                    <td class="tl"><?= $dt['Catatan'];?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Jam Mulai Kalibrasi</td>
                    <td class="tl"><?= $dt['JamMulai'];?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Jam Selesai Kalibrasi</td>
                    <td class="tl"><?= $dt['JamSelesai'];?></td>
                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Tanggal Kalibrasi</td>
                    <td class="tl"><?= IndonesianDate($dt['TglKalibrasi']);?> </td>

                </tr>
                  <tr>
                    <td class="tl" style="padding: 8px;">Jadwal Kalibrasi Ulang</td>
                    <td class="tl"><?= IndonesianDate($dt['TglReKalibrasi']);?></td>

                </tr>
                <tr>
                    <td class="tl" style="padding: 8px;">Scan Detail Alat</td>
                    <td class="tl">
                        <center>
                            <?php
                            $uri = 'dashboard/detail_alat/'.encode($dt['id']);
                            ?>
                            <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&choe=UTF-8&chl=<?= $this->config->item('base_url'); ?><?= $uri; ?>" alt="barcode" />
                            <p><?= $this->config->item('base_url'); ?></p>
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <div class="line"></div>
        <table width="100%" border="0">
            <tbody>
                <tr>
                    <td>
                        <div align="center">
                            Penanggung Jawab,<br>
                            <br><br><br><br><br><br><br><br><br>
                            <br> (<?= $dt['PenanggungJawab'];?>)
                        </div>
                    </td>
                

                    <td align="right">
                        <br><br>
                        <div align="center">
                            Yogyakarta, <?= IndonesianDate(date("Y-m-d"));?><br>PT Adi Multi Kalibrasi<br>
                            <br>
                            <br><br><br><br><br><br><br><br> 
                            (________________________)

                        </div>
                        <br><br>
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br>
    </div>
    <div style="text-align:center;" class="tc">[<a href="#" onclick="print()">CETAK</a>]</div>
    <br><br>
</body>

</html>