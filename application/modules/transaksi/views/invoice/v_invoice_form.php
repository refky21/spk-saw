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
        <h4 class="card-title"><strong>Buat Invoice</strong></h4>
        <div class="btn-toolbar">
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-close"></i></label>
            </a>
        </div> 
    </div>

    <form class="" data-provide="validation" data-disable="false" id="frmAdd" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">  
        <div class="card-body" id="tbl-container">
                <div class="form-group row mb-0">   
                    <label class="col-form-label col-xl-2 col-md-3">Permintaan Pelanggan </label>
                    <div class="col-4">
                        <select name="permintaan" id="spk"  class="form-control" data-provide="selectpicker" title="Pilih" data-live-search="true">
                            <?php foreach($permintaan as $pmt) {?>
                                <option value="<?php echo $pmt['PermintaanId'] ?>" 
                                data-tgl="<?php echo IndonesianDate($pmt['TglPermintaan'])?>" 
                                data-tglkun="<?php echo IndonesianDate($pmt['TglKunjungan'])?>" 
                                data-tglrel="<?php echo IndonesianDate($pmt['TglRealisasi'])?>" 
                                data-norder="<?php echo $pmt['NoOrder']?>" 
                                data-ppn="<?php echo $pmt['PPN']; ?>"
                                data-biayakunjungan="<?php echo intval($pmt['BiayaKunjungan']); ?>"
                                data-nmplgn="<?php echo $pmt['NamaPelanggan']; ?>"
                                data-totalat="<?php echo intval($pmt['TotalAlat']); ?>"
                                data-hrgdtl=""
                                ><?php echo $pmt['NoOrder'].' - '. $pmt['NamaPelanggan']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="divider">Detail Permintaan</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Nomor Order</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="norder">: </p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Permintaan</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tgl">: </p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Kunjungan</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tglkun">: </p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Realisasi</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tglrel">: </p>
                            </div>
                        </div>
                    </div>

                <div class="col-md-6">
                    <label class="col-form-label col-xl-4">Teknisi</label>
                    <div class="col-8">
                        <ul id="pmt_tkn"></ul>
                    </div>

                </div>

                </div>
                
            <div class="divider">Biaya Alat</div>
            <table class="table table-sm table-bordered" width="100%">
            <thead>
            <tr>
                <th width="3%">No.</th>
                <th>Detail Biaya</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td class="left">Biaya Kunjungan</td>
                <td class="text-left" id="pmt_biayakun">0</td>
            </tr>
            <tr>
                <td>2</td>
                <td class="left"><b>Dasar Pengenaan Pajak</b> <br>
                    Detail : <br>Jumlah Permintaan Alat Terverikasi <b><i id="pmt_tot_alat"></i></b> <br> 
                    Harga Permintaan Alat Setelah Terverifikasi (PmtDetailAlat * HargaPmtDetail): <strong><i id="pmt_htgdtl"> </i></strong>
                </td>
                <td class="text-left" id="pmt_totalhrg" valign="center"></td>
            </tr>
           
            <tr>
                <td rowspan="6"></td>
            </tr>
            <tr>
                <td class="left" colspan="1">PPN <i id="pmt_ppn"></i></td>
                <td class="left" id="pmt_hrgppn"></td>
            </tr>
            <tr>
                <td class="left" colspan="1">Total Tagihan<input type="hidden" id="totnom" name="tot_nominal"></td>
                <td class="left" id="tot"></td>
            </tr>
            <!-- <tr>
                <td class="left" colspan="1">Uang Muka</td>
                <td class="left"><input type="text" id="dps" name="total_dp" class="form-control" autocomplete="off" placeholder="Uang Muka" value="0" required></td>
            </tr> -->
            <tr>
                <td class="left" colspan="1">Nominal Pembayaran Invoice</td>
                <td class="left"><input type="text" id="nom" name="total_tagihan" class="form-control" autocomplete="off" placeholder="Total Seluruh Tagihan" value="" required></td>
            </tr>
            <tr>
                <td class="left" colspan="1">Sisa Tagihan <input type="hidden" id="inputSisa" name="sisa"></td>
                <td class="left" id="pmt_sisa"></td>
            </tr>
            </tbody>
        </table>
                
                
                
        </div>
        <div class="text-left" style="display:none;" id="text">
                    Catatan : Jika Nominal Yang Dimasukan Kurang dari Total Tagihan, Otomatis Sisa Tagihan Akan Dimasukan Ke Invoice Baru
        </div>
        <footer class="card-footer text-right">
            <a href="<?php echo site_url($module); ?>" class="btn btn-secondary btn-bold"><i class="fa fa-arrow-left"></i> Batal</a>
            <button class="btn btn-primary btn-bold" type="submit" id="btns"><i class="fa fa-save"></i> SIMPAN</button>
        </footer>
    </form>
</div>

<script type="text/javascript">
$(function() {
    $('#spk').on('change', function(e) {

        let group = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url($module . '/ajax_hitung') ?>",
            data: { PmtId : group},
            dataType: "json",
            success: function (res) {
                // var string_html = "";
                var string_html = res.HarBarang;
                // $.each(res, function (key, value) {
                //     string_html = string_html+"<li>"+value.HarBarang+ " | " +value.alat+"</li>";
                // });
                $('#pmt_htgdtl').text('Rp. ' + new Intl.NumberFormat('id-ID').format(string_html));
                $('#spk option:selected').attr('data-hrgdtl',string_html);
                $('#totHar').val(string_html);


                let val = $("#spk option:selected").val();
                if (val != '') {
                    var biayakunjungan = $('#spk option:selected').data('biayakunjungan');
                    var hargaalat = string_html;
                    // alert(biayakunjungan);
                    var totAlat = $('#spk option:selected').data('totalat');
                    var ppn = $('#spk option:selected').data('ppn');
                    let z = hargaalat;

                    var plus = biayakunjungan + z;
                    var hitppn = z*ppn/100;
                    var jml = plus + hitppn;

                    // alert(hitppn);

                    $('#norder').text(': ' + $('#spk option:selected').data('norder'));
                    $('#pmt_tgl').text(': ' + $('#spk option:selected').data('tgl'));
                    $('#pmt_tglkun').text(': ' + $('#spk option:selected').data('tglkun'));
                    $('#pmt_tglrel').text(': ' + $('#spk option:selected').data('tglrel'));
                    $('#pmt_tot_alat').text(': ' + $('#spk option:selected').data('totalat') + ' Buah');
                    // $('#pmt_htgdtl').text('Rp. ' + new Intl.NumberFormat('id-ID').format(hargaalat));
                    $('#pmt_ppn').text(ppn + '%');

                    
                    $('#pmt_totalhrg').text('Rp. ' + new Intl.NumberFormat('id-ID').format(z));
                    $('#pmt_biayakun').text('Rp. ' + new Intl.NumberFormat('id-ID').format(biayakunjungan));
                
                    $('#pmt_hrgppn').text('Rp. ' + new Intl.NumberFormat('id-ID').format(hitppn));
                    $('#spk_verifikator').text('Rp. ' + $('#spk option:selected').data('verifikator'));
                    $('#tot').text('Rp. ' + new Intl.NumberFormat('id-ID').format(jml));
                    $('#totnom').val(new Intl.NumberFormat('id-ID').format(jml));
                }
            }
        });

        $.ajax({
            type: "POST",
            url: "<?php echo site_url($module . '/ajax_select') ?>",
            data: { PmtId : group},
            dataType: "json",
            success: function (res) {
                var string_html = "";
                $.each(res, function (key, value) {
                    console.log(value.NamaTeknisi);
                        string_html = string_html+"<li>"+value.NamaTeknisi+"</li>";
                });
                $('#pmt_tkn').html(string_html);
            }
        });
        
    });


    $('#nom').on('keyup', function(e) {
        var total = $('#totnom').val().split('.').join('');
        // var dp = $('#dps').val().split('.').join('');
        var inputan = $(this).val().split('.').join('');
        // var sisa = total - inputan - dp;
        var sisa = total - inputan;
        $('#pmt_sisa').text('Rp. ' + new Intl.NumberFormat('id-ID').format(sisa));
        $('#inputSisa').val(sisa);

        if(sisa >= 0){
            $('#text').show();
        }else{
            $('#text').hide();
        }

        if(sisa < 0){
            alert("Nominal Melebihi Tagihan Saat Ini : " + new Intl.NumberFormat('id-ID').format(sisa));
            $('#btns').prop('disabled', true);
        }else{
            $('#btns').prop('disabled', false);
        }



    });


var rupiah = document.getElementById("nom");
rupiah.addEventListener("keyup", function(e) {
    rupiah.value = formatRupiah(this.value, "");
});

var dps = document.getElementById("dps");
dps.addEventListener("keyup", function(e) {
    dps.value = formatRupiah(this.value, "");
});



/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
    split = number_string.split(","),
    sisa = split[0].length % 3,
    rupiah = split[0].substr(0, sisa),
    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }
    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
}





});
</script>



