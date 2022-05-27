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
        <h4 class="card-title"><strong>Buat Permintaan</strong></h4>
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
                    <select data-provide="selectpicker" id="PlgnId" name="plgnId" data-live-search="true" data-width="40%" data-header="Pilih Pelanggan" readonly >
                        <?php foreach($listPlgn as $plgn): ?>
                        <option <?php echo ($dtPlgn['PelangganId']== $plgn['plgnId']) ? 'selected' : "";?> value="<?= $plgn['plgnId'];?>"><?= $plgn['Pelanggan'];?></option>
                        <?php endforeach;?>
                    </select>
        </div>

        <label class="col-form-label col-sm-2 float_left text-right ">Penanggung Jawab</label>
        <div class="form-control-plaintext col-sm-10 fw-400" id="PlgnPj">:</div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Tanggal Permintaan</label>
        <div class="col-2">
            <input type="text" name="tgl" id="tgl-pmt" class="form-control" data-provide="datepicker" data-date-today-btn="linked" data-date-today-highlight="true" data-date-format="yyyy-mm-dd" value="<?= $dtPlgn['TglAjuan'];?>"  readonly>
            <input type="hidden" id="tgl-pmt-real" name="tgl_pmt_real" value="<?= $dtPlgn['TglAjuan'];?>">
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Rencana Kunjungan</label>
        <div class="col-sm-10 float_left">
            <input type="text" name="tgl" id="tgl-usulan" class="form-control col-md-2" data-provide="datepicker" data-date-today-btn="linked" data-date-today-highlight="true" data-date-format="yyyy-mm-dd" value="<?= $dtPlgn['TglKunjungan'];?>"  readonly>
            <input type="hidden" id="tgl-usulan-real" name="tgl_real" value="<?= $dtPlgn['TglKunjungan'];?>">
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Durasi Pengerjaan</label>
        <div class="col-2">
            <div class="input-group mb-10">
                <div class="input-group-btn">
                    <div class="btn-group">
                    <input type="number" name="durasi_pengerjaan" id="durasi_pengerjaan" class="form-control" value="<?= $dtPlgn['LamaKunjungan'];?>">
                        <span class="input-group-addon" id="basic-addon2"><b>Hari</b></span>
                    </div>
                </div>
            </div>
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right  required">Biaya Kunjungan</label>
        <div class="col-2">
            <input type="text" name="biaya_kunjungan" id="biayaKunjungan" class="form-control" value="<?= intval($dtPlgn['BiayaKunjungan']);?>">
            <div class="invalid-feedback" id="error_tgl"></div>
        </div>
    </div>
    <div class="form-group row">
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
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right">No. HP</label>
        <div class="form-control-plaintext col-sm-10" id="Hp"></div>

        <label class="col-form-label col-sm-2 float_left text-right ">Alamat</label>
        <div class="form-control-plaintext col-sm-10 float_left" id="AlamatPelanggan"></div>
    </div>
    <div class="form-group row">
        <label class="control-label col-sm-2 float_left text-right required">Permintaan Alat</label>
        <div class="col-sm-10 float_left">
            <?php if($roleAlkesAdd):?>
            <button id="cari-btn" type="button" class="btn btn-sm btn-label btn-bold btn-success">Tambah Alat<label><i class="ti-search"></i></label></button>
            <?php endif;?>
            <br>
                <table class="table table-striped table-bordered" cellspacing="0" id="tblBarang" width="100%" style="margin-top: 5px;">
                    <thead >
                        <tr>
                        <th>No.</th>
                        <th>Nama Alkes</th>
                        <th>Jns Diskon</th>
                        <th>Tot Diskon</th>
                        <th>Hrg Permintaan</th>
                        <th>Jumlah Alat</th>
                        <th>Total Harga</th>
                        <th></th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr id="tmplListBarang" style="display: none;">
                                <th scope="row">1</th>
                                <td class="fw-400 kode_nama"></td>
                                <td >
                                    <select name="jnsDiskon" class="form-control" id="jns-diskon">
                                        <option>-- Pilih Jenis --</option>
                                            <option  selected value="persen">Persen</option>
                                            <option value="nominal">Nominal</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="hrg-diskon" pattern="[0-9]*" inputMode="numeric" name="hrg_diskon">
                                </td>
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
                                    <input type="hidden" class="form-control" id="hrg-akhir" name="hrg_up" >
                                    <a id="delBarang" class="btn btn-square btn-danger text-white table-action" ><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <?php foreach($barang as $i => $item) {?>
                            <tr id="barang">
                                <th scope="row"><?php echo $i+1 ?></th>
                                <td class="fw-400 kode_nama"><?php echo $item['NamaAlkes']; ?>
                                <input type="hidden" name="pmtdtAlkesId[]" value="<?= encode($item['alkesId']);?>">
                                </td>
                                <td >
                                    <select name="jnsDiskon[]" <?php echo ($roleAlkesAdd) ? '' : 'readonly';?> class="form-control" id="jns-diskon">
                                        <option>-- Pilih Jenis --</option>
                                            <option <?php echo ($item['JnsDiskon']=='persen') ? 'selected' : '';?> value="persen">Persen</option>
                                            <option <?php echo ($item['JnsDiskon']=='nominal') ? 'selected' : '';?> value="nominal">Nominal</option>
                                    </select>
                                </td>
                                <td>
                                    <input <?php echo ($roleAlkesAdd) ? '' : 'readonly';?> type="text" class="form-control" id="hrg-diskon" pattern="[0-9]*" inputMode="numeric" name="hrg_diskon[]" value="<?php echo intval($item['JmlDiskon']); ?>">
                                    
                                </td>
                                <td>
                                    <input type="text" <?php echo ($roleAlkesAdd) ? '' : 'readonly';?> class="form-control" id="hrg-brg" pattern="[0-9]*" inputMode="numeric" name="harga[]" value="<?php echo intval($item['HargaDasar']); ?>">
                                    <p class="small no-margin mb-10 text-danger fw-500" style="font-style: italic;" id="terbilang-harga"></p>
                                </td>
                                
                                <td>
                                    <input type="number" <?php echo ($roleAlkesAdd) ? '' : 'readonly';?> class="form-control" id="jml-alat" pattern="[0-9]*" inputMode="numeric" name="jml_alat[]" value="<?php echo $item['JmlAlat']; ?>">
                                </td>
                                <!-- <td>
                                    <input type="text" class="form-control" id="lokasi-alat"  name="lokasi_alat[]" value="">
                                </td> -->
                                <td id="total">
                                    <?php echo format_rupiah(intval($item['HargaPmt'])); ?>
                                </td>
                                <td>
                                    <input type="hidden" id="id-brg" name="brg_id[]" value="<?php echo encode($item['alkesId']); ?>">
                                    <input type="hidden" class="form-control" id="hrg-akhir" name="hrg_up[]" value="<?php echo intval($item['HargaPmt']); ?>">
                                    <input type="hidden" class="form-control" id="hrg-akhir" name="jml_alat_lama[]" value="<?php echo intval($item['JmlAlat']); ?>">
                                    <?php if($roleAlkesAdd):?>
                                    <a id="delBarang" class="btn btn-square btn-danger text-white table-action"  ><i class="ti-trash"></i></a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                </table>
        </div>
      </div>
    <div class="form-group row">
        <label class="control-label col-sm-2 float_left text-right required">Alat Kalibrasi</label>
        <div class="col-sm-10 float_left">
            <?php if($roleKalibrasiAdd):?>
            <button id="btnKali" type="button" class="btn btn-sm btn-label btn-bold btn-primary">Cari Alat<label><i class="ti-search"></i></label></button>
            <?php endif;?>
            <br>
                <table class="table table-striped table-bordered" cellspacing="0" id="tblKali" width="100%" style="margin-top: 5px;">
                    <thead >
                        <tr>
                            <th>No.</th>
                            <th>Nama Alat</th>
                            <th>Merek</th>
                            <th>No Seri</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="tmplListKalibrasi" style="display: none;">
                                <th scope="row">1</th>
                                <td class="fw-400 kode_nama"></td>
                                <td class="fw-400 mrk_kali"></td>
                                <td class="fw-400 no_seri"></td>
                                <td>
                                    <input type="hidden" id="kalibrasi-id" name="kalibrasi_id" >
                                    <a id="delAlat" class="btn btn-square btn-danger text-white table-action"  ><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                            <?php foreach($kalibrator as $i => $items) {?>
                            <tr id="kalibrator" >
                                <th scope="row"><?php echo $i+1 ?></th>
                                <td class="fw-400 kode_nama"><?php echo $items['kodeName']; ?></td>
                                <td class="fw-400 mrk_kali"><?php echo $items['alatMerk']; ?></td>
                                <td class="fw-400 no_seri"><?php echo $items['alatNoSeri']; ?></td>
                                <td>
                                    <input type="hidden" name="kalibrasi_id[]" value="<?= encode($items['alatId']);?>">
                                    <?php if($roleKalibrasiAdd):?>
                                    <a id="delAlat" class="btn btn-square btn-danger text-white table-action" ><i class="ti-trash"></i></a>
                                    <?php endif;?>
                                </td>
                            </tr>  
                            <?php } ?>
                        </tbody>
                        
                </table>
        </div>
      </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Catatan</label>
            <div class="col-sm-10 float_left">
                <textarea class="form-control" name="pmtCatatan" id="pmtCatatan" rows="6"><?= $dtPlgn['Catatan'];?></textarea>
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
    // AJax Default Select
        var plgn = $('#PlgnId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url($module . '/ajax_select') ?>",
            data: { PlgnId : plgn},
            dataType: "json",
            success: function (res) {
                var data = res.data;
                $('#PlgnPj').html(": " + data.Contact);
                $('#Hp').html(": " +data.Hp);
                $('#AlamatPelanggan').html(": " +data.AlamatPelanggan);
            }
        });

    // Ajax Button
    $('#tgl-usulan').on('changeDate', function(e) {
        var month   = String(e.date.getMonth() + 1);
        var day     = String(e.date.getDate());
        var date_val= e.date.getFullYear() + '-' + (month.length == 1 ? ('0'+ month) : month) + '-' + (day.length == 1 ? ('0'+ day) : e.date.getDate());
        $('#tgl-usulan-real').val(date_val);
    });

    $('#tgl-pmt').on('changeDate', function(e) {
        var month   = String(e.date.getMonth() + 1);
        var day     = String(e.date.getDate());
        var date_val= e.date.getFullYear() + '-' + (month.length == 1 ? ('0'+ month) : month) + '-' + (day.length == 1 ? ('0'+ day) : e.date.getDate());
        $('#tgl-pmt-real').val(date_val);
    });

    $('#tblBarang').on('keyup', '#jml-alat', function() {
        var jml = $(this).val(),
            diskon = $(this).parents('tr').find('#hrg-diskon').val(), 
            harga = $(this).parents('tr').find('#hrg-brg').val();
        var jmlHarga = jml * harga;
        var hasilDiskon = (diskon/100) * jmlHarga;
        var hasil = jmlHarga - hasilDiskon;
        $(this).parents('tr').find('#total').text(new Intl.NumberFormat('id-ID').format(hasil));
        $(this).parents('tr').find('#hrg-akhir').val(new Intl.NumberFormat('id-ID').format(hasil));
    });

    $('#tblBarang').on('keyup', '#hrg-brg', function() {
        var jml = $(this).parents('tr').find('#jml-alat').val(),
            diskon = $(this).parents('tr').find('#hrg-diskon').val(), 
            harga = $(this).val();
        var jmlHarga = jml * harga;
        var hasilDiskon = (diskon/100) * jmlHarga;
        var hasil = jmlHarga - hasilDiskon;
        $(this).parents('tr').find('#total').text(new Intl.NumberFormat('id-ID').format(hasil));
        $(this).parents('tr').find('#hrg-akhir').val(new Intl.NumberFormat('id-ID').format(hasil));
    });
<?php if($roleAlkesAdd):?>
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
<?php endif;?>
<?php if($roleKalibrasiAdd):?>
    $('#tblKali').on('click', '#delAlat', function(e) {
        e.preventDefault();
        let $nextTR = $(this).parents('tr').nextAll(); console.log( $(this).parents('tr'));
        $.each($nextTR, function(idx, row) {
            var number = $(row).find('[scope="row"]').text();
            $(row).find('[scope="row"]').text(number - 1);
        });
        $(this).parents('#kalibrator').remove();
    });
<?php endif;?>
<?php if($roleAlkesAdd):?>
    $('#cari-btn').on('click', function(e) {
        e.preventDefault();
        var act_url = '<?php echo site_url('permintaan/Permintaan/detail'); ?>';
        app.modaler({
            title: 'Daftar Alat',
            url: act_url,
            size:'lg',
            footerVisible: false
        });
    });
<?php endif;?>
    <?php if($roleKalibrasiAdd):?>
    $('#btnKali').on('click', function(e) {
        e.preventDefault();
        var act_url = '<?php echo site_url('permintaan/Permintaan/alat_kalibrasi'); ?>';
        app.modaler({
            title: 'Daftar Kalibrator',
            url: act_url,
            size:'lg',
            footerVisible: false
        });
    });
    <?php endif;?>


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