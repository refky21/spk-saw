<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<form class="" id="form" method="POST" action="<?php echo site_url($module.'/update/'.encode($data['subKrtId'])); ?>">
<input  type="hidden" name="id" value="<?php echo encode($data['subKrtId']) ?>" >
    <div class="">
                <div class="form-group">
                    <label for="select"  class="require">Kriteria</label>
                    <select class="form-control" name="kriteriaId" required>
                        <option>Pilih Kriteria</option>
                        <?php 
                        foreach($kriteria as $row){

                            if($data['subKrtKriteriaId'] == $row->id){
                                echo '<option value="'.$row->id.'" selected>'.$row->nama.'</option>';
                            }else{
                                echo '<option value="'.$row->id.'">'.$row->nama.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="require" for="input-required">Nilai</label>
                    <input type="text" class="form-control"  name="subValue" value="<?= $data['subKrtValue'];?>">
                    <span class="invalid-feedback" id="error_kodbar"></span>
                </div>
                <div class="form-group">
                    <label class="require" for="input-required">Sub-Kriteria</label>
                    <input type="text" class="form-control"  name="subNama" value="<?= $data['subKrtNama'];?>">
                    <span class="invalid-feedback" id="error_kodbar"></span>
                </div>
    </div>
    <footer class=" text-right">
        <input type="hidden" name="action" value="submit">
        <button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
        <button class="btn btn-primary" type="submit" data-perform="confirm">Simpan</button>
    </footer>
</form>
