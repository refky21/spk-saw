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
        <h4 class="card-title"><strong>Penilaian</strong></h4>
        <div class="btn-toolbar">
            
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-times"></i></label>
            </a>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
<form class="" data-provide="validation" data-disable="false" id="frmAdd" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>" >  
    <div class="row">
        <div class="col-lg-12">
                <hr class="d-lg-none">
                <h5>Bahasa Pemrograman</h5>
                <?php
                    foreach($bahasa as $bhs):
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="bahasa" id="inlineRadio<?= $bhs['id'];?>" value="<?= $bhs['id'];?>">
                  <label class="form-check-label" for="inlineRadio<?= $bhs['id'];?>"><?= $bhs['nama'];?></label>
                </div>

                <?php
                endforeach;
                ?>
                <hr>
                <h5>Framework</h5>
                <?php
                    foreach($fw as $bhs):
                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="fw" id="fw<?= $bhs['id'];?>" value="<?= $bhs['id'];?>">
                  <label class="form-check-label" for="fw<?= $bhs['id'];?>"><?= $bhs['nama'];?></label>
                </div>

                <?php
                endforeach;
                ?>
                <hr>
                
                <h3>Data Kriteria</h3>
                 <hr>
                <?php
                    foreach($kriteria as $in => $krt):
                ?>
                <h5><?= $krt['nama_kriteria'];?></h5>
                <input type="hidden" name="kriteriaId[]" value="<?= $krt['id_kriteria'];?>">
                <?php
                    if(!empty($krt['alternatif'])):
                        foreach($krt['alternatif'] as $alt):
                            $rep = explode("-",$alt);
                        $dt = str_replace(" ","",$krt['nama_kriteria']);

                ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="<?= $krt['id_kriteria'];?>" id="<?= $dt;?><?= $rep[0];?>" value="<?= $rep[0];?>">
                  <label class="form-check-label" for="<?= $dt;?><?= $rep[0];?>"><?= $rep[1];?></label>
                </div>
                
                <?php
                        endforeach;
                    endif;
                ?>
  <hr>
                <?php
                endforeach;
                ?>
        </div>
    </div>

    
    <footer class="card-footer text-right">
        <button class="btn btn-primary" type="submit">SIMPAN</button>
    </footer>
</form>
</div>
</div>

<!-- ajax -->

<script>
$(document).ready(function(){
$("#PlgnId").change(function(){
    var group = $('#PlgnId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url($module . '/ajax_select') ?>",
            data: { PlgnId : group},
            dataType: "json",
            success: function (res) {
                var data = res.data;
                $('#PlgnPj').html(": " + data.Contact);
                $('#Hp').html(": " +data.Hp);
                $('#AlamatPelanggan').html(": " +data.AlamatPelanggan);
            }
        });
    });
});
</script>
<script type="text/javascript">
$(function() {
    var table = document.getElementById("tblBarang");
    var rows = table.getElementsByTagName("tr");
    var totalRow = rows.length;

    // if (totalRow == 2) {
    //     $("#tblBarang").hide();
    //     $("#tblBarang").hide();
    // }
    // Ajax Button
    $('#tgl-usulan').on('changeDate', function(e) {
        var month   = String(e.date.getMonth() + 1);
        var day     = String(e.date.getDate());
        var date_val= e.date.getFullYear() + '-' + (month.length == 1 ? ('0'+ month) : month) + '-' + (day.length == 1 ? ('0'+ day) : e.date.getDate());
        $('#tgl-usulan-real').val(date_val);
    });

    $('#tgl-pnw').on('changeDate', function(e) {
        var month   = String(e.date.getMonth() + 1);
        var day     = String(e.date.getDate());
        var date_val= e.date.getFullYear() + '-' + (month.length == 1 ? ('0'+ month) : month) + '-' + (day.length == 1 ? ('0'+ day) : e.date.getDate());
        $('#tgl-pnw-real').val(date_val);
    });

    $('#tblBarang').on('click', '#delBarang', function(e) {
        //console.log('tes');
        e.preventDefault();
        let $nextTR = $(this).parents('tr').nextAll(); console.log( $(this).parents('tr'));
        $.each($nextTR, function(idx, row) {
            var number = $(row).find('[scope="row"]').text();
            $(row).find('[scope="row"]').text(number - 1);
        });
        $(this).parents('#barang').remove();
    });

   

    
    $('#tblBarang').on('keyup', '#jml-alat', function() {
        var jml = $(this).val(),
            harga = $(this).parents('tr').find('#hrg-brg').val(); 
        $(this).parents('tr').find('#total').text(new Intl.NumberFormat('id-ID').format(jml * harga));
    });

    $('#cari-btn').on('click', function(e) {
        e.preventDefault();
        var act_url = '<?php echo site_url('transaksi/Penawaran/detail'); ?>';
        app.modaler({
            title: 'Daftar Alat',
            url: act_url,
            size:'lg',
            footerVisible: false
        });
    });





    var rupiah = document.getElementById("biayaKunjungan");
rupiah.addEventListener("keyup", function(e) {
// tambahkan 'Rp.' pada saat form di ketik
// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
rupiah.value = formatRupiah(this.value, "");
});

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
var number_string = angka.replace(/[^,\d]/g, "").toString(),
split = number_string.split(","),
sisa = split[0].length % 3,
rupiah = split[0].substr(0, sisa),
ribuan = split[0].substr(sisa).match(/\d{3}/gi);

// tambahkan titik jika yang di input sudah menjadi angka ribuan
if (ribuan) {
separator = sisa ? "." : "";
rupiah += separator + ribuan.join(".");
}

rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
}






});
</script>