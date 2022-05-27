<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<form id="form" class="card form-type-combine" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">
<div class="modal-body">
    <div class="form-groups-attached">
            <div class="form-group">
                <label >Nomor Sertifikat</label>
                <input class="form-control" type="text" name="no_sertifikat" value="<?= (isset($dtPmtAlat['NoSertifikat'])) ? $dtPmtAlat['NoSertifikat'] : '';?>">
            </div>
            
            <div class="row">
                <div class="form-group col-4">
                    <label>Nomor Seri</label>
                    <input class="form-control" type="text" name="no_seri" value="<?= (isset($dtPmtAlat['NoSeri'])) ? $dtPmtAlat['NoSeri'] : '';?>">
                </div>
                <div class="form-group col-4">
                    <label>Merek</label>
                    <input class="form-control" type="text" name="merk" value="<?= (isset($dtPmtAlat['Merek'])) ? $dtPmtAlat['Merek'] :'';?>">
                </div>
                <div class="form-group col-4">
                    <label>Tipe Alat</label>
                    <input class="form-control" type="text" name="tipe_alat" value="<?= (isset($dtPmtAlat['Tipe'])) ? $dtPmtAlat['Tipe'] : '';?>">
                </div>
            </div>

            <div class="form-group">
                <label>Lokasi ALat</label>
                <input class="form-control" type="text" name="lokasi_alat" value="<?= (isset($dtPmtAlat['LokasiAlat'])) ? $dtPmtAlat['LokasiAlat'] : '';?>">
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label>Status Kalibrasi</label><br>
                    <select data-provide="selectpicker" data-width="100%" title="-- Pilih --" name="status">
                        <?php foreach($stKali as $st){ ?>
                            <option <?php 
                            if(isset($dtPmtAlat['StatusId'])){
                                echo ($dtPmtAlat['StatusId'] == $st['skId']) ? 'selected' : '';
                            }
                            ?> value="<?= $st['skId'];?>"><?= $st['skNama'];?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label>Catatan</label>
                    <input class="form-control" type="text" name="catatan" value="<?= (isset($dtPmtAlat['Catatan'])) ? $dtPmtAlat['Catatan'] : '';?>">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label>Jam Mulai</label><br>
                    <input type="text" class="form-control" value="<?= (isset($dtPmtAlat['JamMulai'])) ? $dtPmtAlat['JamMulai'] : '';?>" name="jam_mulai" data-provide="clockpicker" data-autoclose="true" autocomplete="off">
                </div>

                <div class="form-group col-6">
                    <label>Jam Selesai</label>
                    <input class="form-control" type="text" value="<?= (isset($dtPmtAlat['JamSelesai'])) ? $dtPmtAlat['JamSelesai'] : '';?>" name="jam_selesai" data-provide="clockpicker" data-autoclose="true" autocomplete="off">
                </div>
            </div>
            <?php
                if(!empty($Detail)){
            ?>
            <div class="form-group">
                <label>Permintaan Alat Tambahan</label>
                <select data-provide="selectpicker" data-width="100%" title="-- Pilih --" name="alat_tambahan">
                    <?php foreach($Detail as $dt){ ?>
                        <option value="<?= $dt['IdDetail'];?>"><?= $dt['NamaAlkes'];?></option>
                    <?php } ?>
                </select>
            </div>
            <?php
            }
            ?>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-bold btn-primary" data-perform="confirm">Submit</button>
    </div>
</div>




</form>