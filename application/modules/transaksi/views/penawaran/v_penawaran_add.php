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
        <h4 class="card-title"><strong>Buat Penawaran</strong></h4>
        <div class="btn-toolbar">
            
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-times"></i></label>
            </a>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
<form class="" data-provide="validation" data-disable="false" id="frmAdd" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>" >  
<div class="px-5">
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Pelanggan</label>
        <div class="form-control-plaintext col-sm-10 fw-400">: 
                    <select data-provide="selectpicker" id="PlgnId" name="plgnId" data-live-search="true" data-width="40%">
                        <option>-- Pilih Pelanggan --</option>
                        <?php foreach($listPlgn as $plgn): ?>
                        <option  value="<?= $plgn['plgnId'];?>"><?= $plgn['Pelanggan'];?></option>
                        <?php endforeach;?>
                    </select>
        </div>

        <label class="col-form-label col-sm-2 float_left text-right ">Penanggung Jawab</label>
        <div class="form-control-plaintext col-sm-10 fw-400" id="PlgnPj">:</div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Rencana Kunjungan</label>
        <div class="col-2">
            <input type="text" name="tgl" id="tgl-usulan" class="form-control" data-provide="datepicker" data-date-today-btn="linked" data-date-today-highlight="true" data-date-format="dd/mm/yyyy" value=""  readonly>
            <input type="hidden" id="tgl-usulan-real" name="tgl_real" value="">
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Tgl Penawaran</label>
        <div class="col-2">
            <input type="text" name="tgl" id="tgl-pnw" class="form-control" data-provide="datepicker" data-date-today-btn="linked" data-date-today-highlight="true" data-date-format="dd/mm/yyyy" value=""  readonly>
            <input type="hidden" id="tgl-pnw-real" name="tgl_pnw_real" value="">
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <!-- <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Biaya Kunjungan</label>
        <div class="col-2">
            <input type="text" name="biaya_kunjungan" id="biayaKunjungan" class="form-control" >
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div> -->
    <!-- <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">PPN</label>
        <div class="col-2">
            <div class="input-group mb-10">
                <div class="input-group-btn">
                    <div class="btn-group">
                    <input type="number" name="ppn" id="ppn" class="form-control" value="<?= $PPN;?>">
                        <span class="input-group-addon" id="basic-addon2"><b>%</b></span>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div> -->
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right">No. HP</label>
        <div class="form-control-plaintext col-sm-10" id="Hp"></div>

        <label class="col-form-label col-sm-2 float_left text-right ">Alamat</label>
        <div class="form-control-plaintext col-sm-10 float_left" id="AlamatPelanggan"></div>
    </div>
    <div class="form-group row">
        <label class="control-label col-sm-2 float_left text-right required">Permintaan Alat</label>
        <div class="col-sm-10 float_left">
            <button id="cari-btn" type="button" class="btn btn-sm btn-label btn-bold btn-success">Tambah Alat<label><i class="ti-search"></i></label></button>
            <br>
                <table class="table table-striped table-bordered" cellspacing="0" id="tblBarang" width="100%" style="margin-top: 5px;">
                    <thead >
                        <tr>
                        <th>No.</th>
                        <th>Nama Alkes</th>
                        <th>Harga Permintaan</th>
                        <th>Jumlah Alat</th>
                        <th>Total Harga</th>
                        <th width='3%'></th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr id="tmplListBarang" style="display: none;">
                                <th scope="row">1</th>
                                <td class="fw-400 kode_nama"></td>
                                
                                <td>
                                    <input type="text" class="form-control" id="hrg-brg" pattern="[0-9]*" inputMode="numeric" name="harga">
                                    <p class="small no-margin mb-10 text-danger fw-500" style="font-style: italic;" id="terbilang-harga"></p>
                                </td>
                                
                                <td>
                                    <input type="number" class="form-control" id="jml-alat" pattern="[0-9]*" inputMode="numeric" name="jml_alat">
                                </td>
                                
                                <td id="total">
                    
                                    <p class="small no-margin mb-10 text-danger fw-500" style="font-style: italic;" id="terbilang-harga"></p>
                                </td>
                                <td>
                                    <input type="hidden" id="id-brg" name="brg_id" >
                                    <a id="delBarang" class="btn btn-square btn-danger text-white table-action"  data-provide="tooltip" title="Hapus Alat"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                </table>
        </div>
      </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Catatan</label>
            <div class="col-sm-10 float_left">
                <textarea class="form-control" name="pmtCatatan" id="pmtCatatan" rows="6"></textarea>
            </div>
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