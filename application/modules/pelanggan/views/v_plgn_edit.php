<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<form class="" id="form" method="POST" action="<?php echo site_url($module.'/update/'.$data['id']); ?>">
   
        <input class="form-control" type="hidden" name="id" value="<?php echo $data['id'] ?>" >

    <div class="">
        <div class="form-group">
        <label class="require" for="input-required">Kategori Pelanggan</label>
            <select name="kat_plgn" data-provide="selectpicker" data-live-search="true" title="Pilih Kategori" data-width="100%">
            <?php foreach($listKat as $ka){?>
                <option <?php echo ($data['KatPlgn'] == $ka['id']) ? 'selected' : ''; ?> value="<?= $ka['id'];?>"><?= $ka['Kategori'];?></option>
            <?php }?>
            </select>
        </div>

        <div class="form-group">
        <label class="require" for="input-required">Nama</label>
        <input type="text" class="form-control"  name="nama" value="<?php echo $data['nama'] ?>">
        <!-- <span class="invalid-feedback" id="error_nama"></span> -->
        </div>

            <div class="form-group">
            <label >Penanggung Jawab</label>
            <input type="text" class="form-control" name="penanggung_jawab" value="<?php echo $data['PenanggungJawab'] ?>">
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>

            <div class="form-group">
            <label >No.Handphone</label>
            <input type="text" class="form-control" name="hp" value="<?php echo $data['hp'] ?>">
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>

            <div class="form-group">
            <label >Alamat</label>
            <textarea class="form-control" name="alamatPlgn" ><?php echo $data['Alamat'] ?></textarea>
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>


</div>
<footer class=" text-right">
    <input type="hidden" name="action" value="submit">
    <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
    <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>