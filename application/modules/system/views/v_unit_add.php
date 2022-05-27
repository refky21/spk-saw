<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
	jQuery(function($) {
		$("#unitParent").select2();
	});
</script>
							<h3 class="header smaller lighter blue">
								<span class="hidden-sm hidden-xs"> Tambah Data Unit</span>
								<span class="hidden-md hidden-lg"> Tambah Unit</span>
							</h3>

							<?php
								if($this->session->flashdata('message_form')){
									$msg = $this->session->flashdata('message_form');
									
							?>
										<div class="alert alert-<?php echo $msg['status'];?> alert-dismissable">
											<button type="button" class="close" data-dismiss="alert">
												<i class="ace-icon fa fa-times"></i>
											</button>
											<strong>
												<i class="ace-icon fa fa-warning"></i>
												<?php echo $msg['title'];?>!!
											</strong>
											<?php echo $msg['message'];?>
											<br />
										</div>
							<?php
								}
							?>
							<?php echo form_open($this->uri->uri_string(), ' class="form-horizontal form-bordered" id="form" role="form"'); ?>
								<div class="form-group <?php echo (form_error('unitParent')) ? 'has-error' :''; ?>">
								<label for="unitParent" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> Unit Parent </label>
								<div class="col-xs-12 col-sm-4">
									<span class="block input-icon input-icon-right">
										<select name="unitParent" id="unitParent" class="width-100">
											<option value="0">Unit Teratas</option>
											<?php foreach($dt_parent_unit->result() as $dt)
											{
												$selected = '';
												if(isset($_POST['unitParent'])){
													if($_POST['unitParent'] == $dt->UnitId){
														$selected = 'selected';
													}
												}
											?>
												<option value="<?php echo $dt->UnitId ?>" <?php echo $selected;?> ><?= $dt->UnitName ?></option> 
											<?php 
											} 
											
											?>					
										</select>
										<?php echo (form_error('unitParent')) ? '<i class="ace-icon fa fa-times-circle"></i>' :''; ?>
										<span class="help-block">Merupakan bentuk hirearki susunan organisasi, silahkan pilih unit tertentu jika unit yang anda masukkan mempunyai sub diatasnya.</span>
									</span>
								</div>
								<?php echo form_error('unitParent'); ?>
							</div>
							
							<div class="hr hr-18 dotted"></div>
							
							<div class="form-group <?php echo (form_error('unitKode')) ? 'has-error' :''; ?>">
								<label for="unitKode" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> Kode Unit </label>
								<div class="col-xs-12 col-sm-4">
									<span class="block input-icon input-icon-right">
										<input name="unitKode" id="unitKode" class="width-100" type="text" value="<?php echo set_value('unitKode');?>" >
										<?php echo (form_error('unitKode')) ? '<i class="ace-icon fa fa-times-circle"></i>' :''; ?>
									</span>
								</div>
								<?php echo form_error('unitKode'); ?>
							</div>
							<div class="hr hr-18 dotted"></div>
							<div class="form-group <?php echo (form_error('unitNama')) ? 'has-error' :''; ?>">
								<label for="unitNama" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right"> Nama Unit </label>
								<div class="col-xs-12 col-sm-4">
									<span class="block input-icon input-icon-right">
										<input name="unitNama" id="unitNama" class="width-100" type="text" value="<?php echo set_value('unitNama');?>" >	
										<?php echo (form_error('unitNama')) ? '<i class="ace-icon fa fa-times-circle"></i>' :''; ?>
									</span>
								</div>
								<?php echo form_error('unitNama'); ?>
							</div>
						
							<div class="hr hr-18 dotted"></div>
							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-check "></i>
											Simpan
									</button>
									&nbsp; &nbsp; &nbsp;
									<button class="btn btn-sm" type="reset">
										<i class="ace-icon fa fa-undo bigger-110"></i>
										Reset
									</button>
									
									&nbsp; &nbsp; &nbsp;
									<a class="btn btn-sm btn-warning" href="<?php echo site_url($module);?>">
										<i class="ace-icon fa fa-chevron-left bigger-110"></i>
										Kembali
									</a>
								</div>
							</div>
						<?=form_close();?>