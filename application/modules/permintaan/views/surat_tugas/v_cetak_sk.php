<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
   <head>
      <title>Cetak Surat Keputusan</title>  
      <link rel="stylesheet" media="print" href="<?php echo $this->config->item('base_url') ?>assets/css/cetak_print.css">     
      <link rel="stylesheet" media="screen" href="<?php echo $this->config->item('base_url') ?>assets/css/cetak_screen.css"/>

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
   </head>
   <body>
      <div id="common">
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
               <div id="header">
                  <hr class="line">
                  <br />
                  <br />
                  <h1>SURAT TUGAS</h1>
                  <h3>NOMOR : 049/ST/LKU/VIII/<?= date('Y');?></h3>
                  <br />				
               </div>

               <br />

               <div id="main-body">
                  
                  <div class="left">
                     <p style="margin-left: 7.5rem;">Direktur <?= $KopNama;?>, memberikan tugas kepada:</p>
                     <br />
                     <div class="center" style=" margin: auto; width: 70%;">
                        <table class="table-data"  cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>NO.</th>
                                 <th>NAMA</th>
                                 <th>JABATAN</th>
                              </tr> 
                           </thead>
   
                           <?php $no = 1; ?>
                           <?php foreach ($teknisi as $data) : ?>
   
                           <tbody>
                              <tr>
                                 <th style="padding: 1rem; "><?= $no++; ?></th>
                                 <td style="padding: 1rem; "><?= $data['NamaTeknisi']; ?></td>
                                 <td style="padding: 1rem; "><?= $data['Jabatan']; ?></td>
                              </tr>
                           </tbody>
   
                           <?php endforeach; ?>
                        </table>	
                     </div>

                     <br />
                     <br />

                     <div style="margin-left: 7.5rem;">
                        <p>untuk melaksanakan kalibrasi dan pengujian alat kesehatan di <?= $cetak['NamaPelanggan']; ?> pada <?= IndonesianDate(date('Y-m-d', strtotime($cetak['pmtTglRencanaKunjungan'])),true); ?>.</p>
                        <div>
                           <p>Demikian surat tugas ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
                        </div>
                     </div>

                     <br />
                     <br />

                     <div class="signature">
                        <table width="100%">
                           <tr>
                              <td></td>
                              <td width="35%">
                                 <table width="100%">
                                    <tr>
                                       <td>Yogyakarta, <?= IndonesianDate(date('Y-m-d')); ?></td>
                                    </tr>
                                    <tr>
                                       <td>Direktur</td>
                                    </tr>
                                    
                                 </table>
                              </td>
                           </tr>
                        </table>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <table width="100%">
                           <tr>
                              <td></td>
                              <td width="35%">
                                 <table width="100%">

                                    <tr>
                                       <td><?= $Pimpinan;?></td>
                                    </tr>
                                    
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </div>
                  
                  </div>

               </div>
                        
            
            </div>
        </div>
     </div>

   </body>
</html>
