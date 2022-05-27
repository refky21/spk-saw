<form id="form" class="form-horizontal" method="POST" action="<?php echo site_url($module . '/proses_detail/'.$hashId) ?>">
<?php 
    if ($detailAlat['Status'] == '2') {
        $label = 'Selesai';
        $btnColor = 'btn-success';
        $value_status = '1';
    }else{
        $label = 'Pending';
        $btnColor = 'btn-warning';
        $value_status = '2';
    }
?>
<input type="hidden" name="status" value="<?php echo $value_status ?>">
        <div class="modal-body">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama Alat Kalibrasi</label>
                    <div class="col-sm-8 ">
                            <b><?php echo strtoupper($detailAlat['AlatKaliNama']); ?></b>
                    </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama Alat Kesehatan</label>
                    <div class="col-sm-8 ">
                            <b><?php echo strtoupper($detailAlat['NamaAlkes']); ?></b>
                    </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Harga Dasar Alat Kesehatan</label>
                    <div class="col-sm-8 ">
                            <b><?php echo format_rupiah($detailAlat['HargaDasar']); ?></b>
                    </div>
            </div>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Harga Permintaan</label>
                    <div class="col-sm-8 ">
                            <b><?php echo format_rupiah($detailAlat['Harga']); ?></b>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-bold <?php echo $btnColor; ?>" data-perform="confirm"><?php echo $label; ?></button>
        </div>
    </form>