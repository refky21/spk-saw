<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<form class="" id="form" method="POST" action="<?= site_url($module.'/update/'.$data['id']); ?>">
    <!-- <h4 class="card-title"><strong>Horizontal</strong></h4> -->

    <div class="">

      
      <div class="form-group">
        <label >Kode Alat Kalibrasi</label>
        <input type="text" class="form-control" name="kode" value="<?= $data['kode'] ?>">
        <span class="invalid-feedback" id="error_keterangan"></span>
      </div>

      <div class="form-group">
        <label class="require" for="input-required">Nama Alat Kalibrasi</label>
        <input type="text" class="form-control"  name="nama"  value="<?= $data['nama'] ?>">
        <input class="form-control" type="hidden" name="id" value="<?= $data['id'] ?>" >
        <span class="invalid-feedback" id="error_nama"></span>
      </div>

      <div class="form-group">
        <label class="require" for="input-required">Merk Alat Kalibrasi</label>
        <input type="text" class="form-control"  name="merk"  value="<?= $data['merk'] ?>">
        <span class="invalid-feedback" id="error_merk"></span>
      </div>
      <div class="form-group">
        <label class="require" for="input-required">No Seri Alat Kalibrasi</label>
        <input type="text" class="form-control"  name="no_seri"  value="<?= $data['noSeri'] ?>">
        <span class="invalid-feedback" id="error_no_seri"></span>
      </div>

      <div class="form-group">
        <label >Keterangan</label>
        <textarea class="form-control" name="keterangan"><?= $data['keterangan'] ?></textarea>
        <span class="invalid-feedback" id="error_keterangan"></span>
      </div>

      <div class="form-group">
        <label for="select">Status</label>
        <select class="form-control" name="alatKalibrasiIsAktif">
        <option value="1" <?= ($data['status'] == 1) ? "" : "selected"; ?>>Aktif</option>
        <option value="0" <?= ($data['status'] == 0) ? "selected" : ""; ?>>Tidak Aktif</option>
        </select>
      </div>
    </div>
<footer class=" text-right">
    <input type="hidden" name="action" value="submit">
    <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
    <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>