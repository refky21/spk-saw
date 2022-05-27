<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<form class="" id="form" method="POST" action="<?php echo site_url($module.'/update/'.encode($data['Id'])); ?>">
<input  type="hidden" name="id" value="<?php echo $data['Id'] ?>" >
    <div class="">
    <div class="modal-body">
            <div class="form-group">
                <label class="require" for="input-required">Bahasa Pemrograman</label>
                <input type="text" class="form-control"  name="pemNama" value="<?php echo $data['Nama'] ?>">
                <span class="invalid-feedback" id="error_kodbar"></span>
            </div>
        </div>
    </div>
    <footer class=" text-right">
        <input type="hidden" name="action" value="submit">
        <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
        <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>
