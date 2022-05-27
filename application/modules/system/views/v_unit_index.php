<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script type="text/javascript" class="init">
	jQuery(document).ready(function() { 
		$(document.body).on("click", "#add-btn",function(event){
			window.location.replace("<?php echo site_url($module . '/add');?>");
		});
		
		$('[data-rel=tooltip]').tooltip({container:'body'});
		
		$('#t-unit-kerja').treetable({
			expandable: true,
			initialState: 'expanded'
		});
		$(document.body).on("click", "#delete-btn",function(event){ 
			var title = $(this).attr("data-original-title");
			var link = $(this).attr("href");
			bootbox.confirm({ 
					message: "Apakah anda ingin men-" + title + " ?",
					backdrop:true,
					callback: function(result){
						if(result === true) {
								window.location.replace(link);
							}
					}
			});
			return false;
		});
	} );
</script>
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
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
		<div class="widget-container-col">
			<div class="widget-box widget-color-blue">
				<div class="widget-header ">
					<h5 class="widget-title bigger lighter ">
						<i class="ace-icon fa fa-table"></i>
						<span class="hidden-sm hidden-xs">Daftar Data Unit</span>
						<span class="hidden-md hidden-lg">Data Unit</span>
					</h5>

					<div class="widget-toolbar no-border">
						<button class="btn btn-xs btn-info bigger" data-original-title="Tambah data unit kerja." data-rel="tooltip" data-placement="bottom" id="add-btn">
							<i class="ace-icon fa fa-pencil bigger-120"></i>
							Tambah Data
						</button>
					</div>
				</div>
			</div>
		</div>
			
			<table id="t-unit-kerja" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th>Kode Unit</th>
						<th>Nama Unit</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
						<td colspan="4" class="dataTables_empty">Loading data from server</td>
					</tr> -->
					<?php 
						$no = 1; 
						foreach ( $dt_unit->result_array() as $dt ){
							$unit[$dt['UnitParent']][] = $dt;
						}
						echo createParentTree($unit, 0, 0, $module);
					?>
				</tbody>
			</table>
	</div>
</div>