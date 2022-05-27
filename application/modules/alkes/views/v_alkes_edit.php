<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<form class="" id="form" method="POST" action="<?php echo site_url($module.'/update/'.$data['id']); ?>">
    <div class="">
            <div class="form-group">
            <label class="require" for="input-required">Kode Barang</label>
            <input type="text" class="form-control"  name="alkesKodeBarang" value="<?php echo $data['KodeBarang'] ?>">
	        <input class="form-control" type="hidden" name="id" value="<?php echo $data['id'] ?>" >
            <span class="invalid-feedback" id="error_kodbar"></span>
            </div>

            <div class="form-group">
            <label class="require">Nama Barang</label>
            <input type="text" class="form-control" name="alkesNamaBarang" value="<?php echo $data['nama'] ?>">
            <span class="invalid-feedback" id="error_nambar"></span>
            </div>

            <div class="form-group">
            <label class="require">Harga Dasar</label>
            <input type="text" class="form-control" id="hargadasar"  name="alkesHargaDasar"  value="<?php echo intval($data['HargaDasar']) ?>">
            <span class="invalid-feedback" id="error_hardas"></span>
            </div>

            <div class="form-group">
            <label >Keterangan</label>
            <textarea class="form-control" name="alkesKeterangan"><?php echo $data['keterangan'] ?></textarea>
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>

            <div class="form-group">
                <label for="select">Status</label>
                <select class="form-control" name="alkesIsAktif">
                <option value="1" <?php echo ($data['Status'] == 1) ? "" : "selected"; ?>>Aktif</option>
                <option value="0" <?php echo ($data['Status'] == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
                </select>
            </div>
    </div>
    <footer class=" text-right">
        <input type="hidden" name="action" value="submit">
        <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
        <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>
