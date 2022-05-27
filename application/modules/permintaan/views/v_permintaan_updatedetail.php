<form id="form" class="form-horizontal" method="POST" action="<?php echo site_url($module . '/update_detail/'.$hashId) ?>">
<input type="hidden" name="id" value="<?= $hashId;?>>
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Alat Kalibrasi</label>
                <div class="col-sm-12">
                    <select data-provide="selectpicker" name="AlatKalibrasi" data-live-search="true" data-width="100%">
                        <option>-- Pilih Alat --</option>
                        <?php foreach($listAlat as $alat): ?>
                        <option <?php echo ($detailAlat['AlatKalibrasi'] == $alat['alatId']) ? 'selected' : '' ;?> value="<?= $alat['alatId'];?>"><?= $alat['kodeName'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="harga" class="col-form-label">Harga</label>
                    <input type="text" class="form-control" id="harga" name="harga" value="<?= intval($detailAlat['Harga']); ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="jmlAlat" class="col-form-label">Jumlah Alat</label>
                    <input type="text" class="form-control" id="jmlAlat" name="jmlAlat" value="<?= $detailAlat['JumlahAlat']; ?>">
                </div>
                <div class="form-group col-md-2">
                <label for="jnsDiskon" class="col-form-label">Jenis Diskon</label>
                <select id="jnsDiskon" name="jnsDiskon" class="form-control">
                    <option <?php echo ($detailAlat['JenisDiskon'] == 'nominal') ? 'selected' : '' ;?> value="nominal">Nominal</option>
                    <option <?php echo ($detailAlat['JenisDiskon'] == 'persen') ? 'selected' : '' ;?> value="persen">Persen</option>
                </select>
                </div>
                <div class="form-group col-md-3">
                <label for="jmlDiskon" class="col-form-label">Jumlah Diskon</label>
                <input type="text" class="form-control" id="jmlDiskon" name="jmlDiskon" value="<?= intval($detailAlat['JumlahDiskon']); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputEmail4" class="col-form-label">Alat Kesehatan</label>
                    <select data-provide="selectpicker" name="Alkes" data-live-search="true" data-width="100%">
                        <option>-- Pilih Alkes --</option>
                        <?php foreach($listAlkes as $alkes): ?>
                        <option <?php echo ($detailAlat['AlkesId'] == $alkes['alkesId']) ? 'selected' : '' ;?> value="<?= $alkes['alkesId'];?>"><?= $alkes['AlkesKodeName'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                <label for="lokasiALat" class="col-form-label">Lokasi Alat</label>
                <input type="text" class="form-control" name="lokasiALat" id="lokasiALat"value="<?= $detailAlat['LokasiAlat']; ?>">
                </div>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-bold btn-primary">Simpan</button>
        </div>
    </form>