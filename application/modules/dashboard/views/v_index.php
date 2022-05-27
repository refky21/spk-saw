<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!--
<div class="page-header">
	<h1>
		Beranda
	</h1>
</div> 

 /.page-header -->
<div class="row">
	<div class="col-xs-12">
		<div class="row">
		<?php
			if(!is_null($message)){
		?>
			<div class="alert alert-<?php echo $message['status'];?>">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>
				<strong>
					<i class="ace-icon fa fa-check"></i>
					Informasi!!
				</strong>
				<?php echo $message['text'];?>
				<br />
			</div>
		<?php
			}
		?>
		
		</div><!-- /.row -->


		
	</div>
</div>

<div class="row">
		<div class="col-md-6 col-lg-4">
            <div class="card p-30 pt-50 text-center box">
              <div>
                <a class="avatar avatar-xxl status-success mb-3" href="#">
                  <img src="<?php echo image_path('logo.png', '_theme_'); ?>" alt="...">
                </a>
              </div>
              <h5><a href="#"><?=$this->config->item('app_name'); ?></a></h5>
              <p><small class="fs-13"><?=$this->config->item('app_title'); ?></small></p>
              <div class="gap-items fs-16">
                <div class="gap-items fs-16">
                <a class="text-facebook" href="#"><i class="fa fa-facebook"></i></a>
                <a class="text-dribbble" href="#"><i class="fa fa-dribbble"></i></a>
                <a class="text-google" href="#"><i class="fa fa-google"></i></a>
                <a class="text-twitter" href="#"><i class="fa fa-twitter"></i></a>
              </div>
              </div>
            </div>
        </div>

		<div class="col-md-8">
			
                <div class="card box">
					<div class="card-header">
						<div class="card-title">
							<h4 class="card-title">Informasi</h4>
						</div>
					</div>
						<div class="card-body">
							<center>
								<img class="img-fluid" src="<?php echo image_path('Alamat.png', '_theme_'); ?>" alt="...">
							</center>
		</div>
                </div>
            </div>
</div>
		

            
