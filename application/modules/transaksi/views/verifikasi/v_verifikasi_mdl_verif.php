<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<style type="text/css">
	.form-group{
		margin-bottom: 0px;
	}
</style>
<form class="" id="form" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">
<input type="hidden" name="id" value="<?= $Plgn['id'];?>">
  	
  	<div class="">


    	<div class="form-group row">
	       <label for="staticEmail" class="col-sm-4 col-form-label">Nama Pelanggan</label>
		    
		    <div class="col-sm-8 ">
		    		<b><?php echo $Plgn['NamaPelanggan']; ?></b>
		    </div>

	    </div>

    	<div class="form-group row">
	       <label for="staticEmail" class="col-sm-4 col-form-label">Penanggung Jawab</label>
		    
		    <div class="col-sm-8 ">
		    		<b><?php echo ucwords(strtolower($Plgn['PenanggungJawab'])); ?></b>
		    </div>

	    </div>
		
		<div class="form-group row">
	       		<label for="staticEmail" class="col-sm-4 col-form-label">Status Permintaan</label>
		    <div class="col-sm-8 info-mhs">
		    	 <select data-provide="selectpicker" data-width="30%" title="-- Pilih --" name="status">
                        <?php foreach($StPmt as $st){ ?>
                            <option value="<?= $st['stId'];?>"><?= $st['stNama'];?></option>
                        <?php } ?>
                    </select>
		    </div>

	    </div>

   </div>
   <footer class=" text-right">
   	<input type="hidden" name="action" value="submit">
   	<button class="btn btn-secondary" data-dismiss="modal" type="reset">Batal</button>
   	<button class="btn btn-primary" type="submit" name="submit" data-perform="confirm">Simpan</button>
  	</footer>
</form>
