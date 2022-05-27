<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="card box">
	<div class="card-header">
		<h4 class="card-title">
		<button class="btn btn-default btn-round" data-provide="tooltip" data-placement="top" title="" data-original-title="Kembali" onclick="history.back();"><i class="fa fa-arrow-left"></i></button>
		Tambah Data Pengguna</h4>
	</div>

	<div class="card-body">
		<?php echo form_open_multipart($module);?>
		<div class="row">

			<!-- <div class="col-md-4">
				<input type="file" name="userfoto" data-provide="dropify">
				<small class="form-text">*Pilih foto pengguna</small>
			</div> -->

			<div class="col-md-8">
				<hr class="d-md-none">

				<div class="form-group">
					<label class="require" for="input-required">Username</label>
					<input type="text" class="form-control"  name="username">
					<?php echo validation_errors(); ?>
				</div>

				<div class="form-group">
					<label class="require" for="input-required">Nama</label>
					<input type="text" class="form-control" name="nama">
					<?php echo validation_errors(); ?>
				</div>

				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" value="" name="email">
				</div>
				<div class="form-group">
					<label class="reuired">No.Hp</label>
					<input type="text" class="form-control" value="" name="no_hp">
				</div>
				<div class="form-group">
					<label class="require" for="input-required">Group Pengguna</label>
					<div class="custom-controls-stacked">
						<?php foreach ($group->result() as $grp) {?>
						<label class="custom-control custom-checkbox">
						<input value="<?=$grp->GroupId;?>" name="group[]" type="checkbox" class="custom-control-input">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description"><?=$grp->GroupName;?></span>
						</label>

						<label class="custom-control custom-radio">
						<input type="radio" value="<?=$grp->GroupId;?>" class="custom-control-input" name="isdefault">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">isDefault?</span>
						</label>
						<br>
						<?php } ?>
					</div>
				</div>

				<div class="form-group">
					<label class="require">Password</label>
			 		<input type="password" class="form-control" value="" name="password_input" placeholder="Atur kata sandi disini">
				</div>
            <div class="form-group">
               <label class="require" for="input-required">Re-Password</label>
               <input type="password" class="form-control" value="" name="password_input_re" placeholder="Masukan ulang kata sandi">
               <?php echo validation_errors(); ?>
            </div>
				<div class="form-group">
					<label>User isActive?</label>
					<div class="custom-controls-stacked">
						<label class="custom-control custom-checkbox">
						<input name="isactive" type="checkbox" checked="checked" class="custom-control-input">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">Active</span>
						</label>
					</div>
				</div>
			</div>

		</div>
		<div class="card-header">
			<h4 class="card-title"></h4>
			<button type="submit" class="btn btn-round btn-label btn-bold btn-primary" >
				Simpan<label><i class="fa fa-save"></i></label></button>
		</div>
   </div>
	</form>
</div>
