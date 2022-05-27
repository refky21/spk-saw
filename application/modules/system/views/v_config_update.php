<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<h3 class="header smaller lighter blue">
	<span class="hidden-sm hidden-xs"> Ubah Pengaturan "<?php echo $data_config->ConfigName;?>"</span>
	<span class="hidden-md hidden-lg"> Ubah "<?php echo $data_config->ConfigName;?>"</span>
</h3>


					
						<?php echo form_open($this->uri->uri_string(),  'class="form-horizontal" id="message-form" role="form"'); ?>
						<?php
							if($this->session->flashdata('message_form')){
								$msg = $this->session->flashdata('message_form');
								
						?>
									<div class="alert alert-<?php echo $msg['status'];?>">
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
							
							<div class="form-group <?php echo (form_error('ConfigValue')) ? 'has-error' :''; ?>">
								<label for="ConfigValue" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Value</label>
								
								<div class="col-xs-12 col-sm-5">
									<span class="block input-icon input-icon-right">
										<textarea name="ConfigValue" class="form-control" id="form-field-8" placeholder="Text SMS"><?php echo (isset($_POST['ConfigValue'])) ? set_value('ConfigValue') : $data_config->ConfigValue;?></textarea>
										<?php echo (form_error('ConfigValue')) ? '<i class="ace-icon fa fa-times-circle"></i>' :''; ?>
									</span>
								</div>
								<?php echo form_error('ConfigValue'); ?>
							</div>
							
							<div class="clearfix form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-info">
										<i class="ace-icon fa fa-check bigger-110"></i> Simpan
									</button>
									&nbsp; &nbsp; &nbsp;
									<a class="btn btn-warning" href="<?php echo site_url($module);?>">
										<i class="ace-icon fa fa-chevron-left bigger-110"></i>
										Kembali
									</a>
								</div>
							</div>
							
						<?php echo form_close();?>