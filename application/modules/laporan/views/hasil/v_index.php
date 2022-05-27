<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php if ($this->session->flashdata('msg')) {
	$msg = $this->session->flashdata('msg');
?>
<div class="callout callout-<?php echo $msg['type'];?>" role="alert">
<button type="button" class="close" data-dismiss="callout" aria-label="Close">
    <span>×</span>
</button>
<h5><?php echo $msg['title'];?></h5>
<p><?php echo $msg['text'];?></p>
</div>

<?php } ?>
<div class="card box">
    <div class="card-header text-right">
        <h4 class="card-title"><strong>Hasil Penilaian</strong></h4>
        <div class="btn-toolbar">
            <?php if($roleAdd):?>
                <a id="add-btn" class="btn btn-round btn-label btn-bold btn-success" href="<?php echo site_url($module . '/add/') ?>">
                   Penilaian
                    <label><i class="ti-plus"></i></label>
                </a>
            <?php endif;?>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
    <form class="" method="POST" action="" id="frmFilter">
        <div class="row">
            <div class="col-md-6"> 
                
            </div>
            <div class="col-md-6">  
                <select data-provide="selectpicker" class="form-control" id="pemrograman" name="filter_permintaan" data-live-search="true" data-header="Pilih Nomor Order" >
                    <option value="">-- Bahasa Pemrograman --</option>
                    <?php foreach($pemrograman as $pem): ?>
                    <option value="<?= $pem['id'];?>"><?= $pem['nama'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <hr>
        </div>
    </form> 



    <div id="div_result"></div>
</div>
</div>

<!-- Ajax -->
<script type="text/javascript">
$(function() {
    $('#pemrograman').on('change', function(){
    var id = $(this).val();

    $.ajax({
    type:'POST',
    url:"<?php echo site_url($module . '/get_view_ajax/') ?>",
    data: "pemrograman="+id,
    success:function(msg){
        $("#div_result").html(msg);
    },
    error: function(result)
    {
        $("#div_result").html("Error"); 
    },
    fail:(function(status) {
        $("#div_result").html("Fail");
    }),
    beforeSend:function(d){
        $('#div_result').html("<center><strong style='color:red'>Sedang Menghitung...<br><img  src='<?php echo base_url();?>assets/load.gif' /></strong></center>");
    }

    }); 
});

   


});


</script>

