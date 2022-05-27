<form id="form" class="form-horizontal" method="POST" action="<?php echo site_url($module . '/add/'.$hashId) ?>">
        <div class="modal-body">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Petugas</label>
                <div class="col-sm-12">
                    <select data-provide="selectpicker" name="ptTeknisiId" data-live-search="true" data-width="100%">
                        <option>-- Pilih Teknisi --</option>
                        <?php foreach($listTeknisi as $ptgs): ?>
                        <option  value="<?= $ptgs['id'];?>"><?= $ptgs['NamaTeknisi'];?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-bold btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-bold btn-primary">Simpan</button>
        </div>
    </form>
