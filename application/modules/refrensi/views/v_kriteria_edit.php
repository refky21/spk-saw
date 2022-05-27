<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<form class="" id="form" method="POST" action="<?php echo site_url($module.'/update/'.$data['id']); ?>">
    <div class="">
            <div class="form-group">
            <label class="require" for="input-required">Kode Barang</label>
            <input type="text" class="form-control"  name="kriteriaNama" value="<?php echo $data['nama'] ?>">
	        <input class="form-control" type="hidden" name="id" value="<?php echo $data['id'] ?>" >
            <span class="invalid-feedback" id="error_kodbar"></span>
            </div>

            <div class="form-group">
                <label for="select">Status</label>
                <select class="form-control" name="kriteriaSifat">
                <option value="Benefit" <?php echo ($data['sifat'] == 'Benefit') ? "" : "selected"; ?>>Benefit</option>
                <option value="Cost" <?php echo ($data['sifat'] == 'Cost') ? "selected" : ""; ?>>Cost</option>
                </select>
            </div>
    </div>
    <footer class=" text-right">
        <input type="hidden" name="action" value="submit">
        <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
        <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>
