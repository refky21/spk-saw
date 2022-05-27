<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="card box">
	<div class="card-header">
		<h4 class="card-title">
		<button class="btn btn-default btn-round" data-provide="tooltip" data-placement="top" title="" data-original-title="Kembali" onclick="history.back();"><i class="fa fa-arrow-left"></i></button>
		Ubah Data Pengguna</h4>
	</div>

	<div class="card-body">
		<?php echo form_open_multipart($module.'/'.$data_user[0]['UserId']);?>
         <div class="row">
            <div class="col-md-8">
               <hr class="d-md-none">
               <div class="form-group">
                  <label class="require" for="input-required">Username</label>
                  <input type="text" class="form-control" readonly="readonly" value="<?=$data_user[0]['UserName'];?>"  name="username">
                  <?php echo validation_errors(); ?>
               </div>
               <div class="form-group">
                  <label class="require" for="input-required">Nama</label>
                  <input type="text" class="form-control" value="<?=$data_user[0]['UserRealName'];?>" name="nama">
                  <?php echo validation_errors(); ?>
               </div>
               <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" value="<?=$data_user[0]['UserEmail'];?>" name="email">
               </div>
               <div class="form-group">
                  <label class="required">No.Hp</label>
                  <input type="text" class="form-control" value="<?=$data_user[0]['UserHP'];?>" name="no_hp">
               </div>
              
               <div class="form-group">
                  <label class="require" for="input-required">Group Pengguna</label>
                  <div class="custom-controls-stacked">
                     <?php foreach ($group->result() as $grp) {?>
                     <label class="custom-control custom-checkbox">
                     <input value="<?=$grp->GroupId;?>"
                     <?php foreach ($user_group as $ug) {
                        if ($grp->GroupId==$ug->GroupId) {
                           echo 'checked="checked"';
                        }
                     }?>
                     name="group[]" type="checkbox" class="custom-control-input">
                     <span class="custom-control-indicator"></span>
                     <span class="custom-control-description"><?=$grp->GroupName;?></span>
                     </label>
                     <label class="custom-control custom-radio">
                        <input type="radio" value="<?=$grp->GroupId;?>"
                     <?php foreach ($user_group as $ug) {
                        if ($grp->GroupId==$ug->GroupId && $ug->UserGroupIsDefault=='Ya') {
                           echo 'checked="checked"';
                        }
                     }?>
                        class="custom-control-input" name="isdefault">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">isDefault?</span>
                     </label>
                     <br>
                     <?php } ?>
                  </div>
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <p><small>Kosongkan jika tidak ingin memperbarui Password.</small></p>
                  <input type="password" class="form-control" value="" name="password_input" placeholder="Atur kata sandi disini">
               </div>
               <div class="form-group">
                  <label>Re-Password</label>
                  <input type="password" class="form-control" value="" name="password_input_re" placeholder="Ulangi kata sandi.">
               </div>
               <div class="form-group">
                  <label>User isActive?</label>
                  <div class="custom-controls-stacked">
                  <label class="custom-control custom-checkbox">
                     <input name="isactive" type="checkbox" <?php echo ($data_user[0]['UserIsActive'] == '1') ? 'checked="checked"' : '';?> class="custom-control-input">
                     <span class="custom-control-indicator"></span>
                     <span class="custom-control-description">Active</span>
                  </label>
                  </div>
               </div>
               
               <div class="form-group">
                  <div class="form-group text-right">
                     <button class="btn btn-w-md btn-bold btn-round btn-primary" type="submit">UBAH</button>
                  </div>
               </div>
            </div>
         </div>
         </form>
   </div>
</div>