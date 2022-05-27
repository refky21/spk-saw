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
        <h4 class="card-title"><strong>Edit Invoice</strong></h4>
        <div class="btn-toolbar">
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-close"></i></label>
            </a>
        </div> 
    </div>

    <form class="" data-provide="validation" data-disable="false" id="frmAdd" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">  
            <input type="hidden" name="pmtId" value="<?= $dt['PermintaanId']; ?>">
            
            <div class="card-body" id="tbl-container">
                <div class="form-group row mb-0">   
                    <label class="col-form-label col-xl-2 col-md-3">Permintaan Pelanggan </label>
                    <div class="col-4">
                        <p class="form-control-plaintext fw-400" id="PermintaanPelanggan">: <?= $dt['NamaPelanggan'];?></p>
                    </div>
                </div>
                <div class="divider">Detail Permintaan</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Nomor Order</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="norder">: <?= $dt['NoOrder'];?></p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Permintaan</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tgl">: <?= IndonesianDate($dt['TglPermintaan']);?> </p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Kunjungan</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tglkun">: <?= IndonesianDate($dt['TglKunjungan']);?></p>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-form-label col-xl-4">Tanggal Realisasi</label> 
                            <div class="col-4">
                                <p class="form-control-plaintext fw-400" id="pmt_tglrel">: <?= IndonesianDate($dt['TglRealisasi']);?></p>
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
                <td class="text-left" id="pmt_biayakun">Rp. <?= format_rupiah($dt['BiayaKunjungan']);?></td>
            </tr>
            <tr>
                <td>2</td>
                <td class="left">Permintaan Alat Terverikasi<b> <i id="pmt_tot_alat"> <?= $dt['TotalAlat'];?> Buah</i> x <i id="pmt_htgdtl"> <?= format_rupiah($dt['HargaTotalAlat']);?></i></b></td>
                <?php 
                    $totHar = $dt['TotalAlat'] * $dt['HargaTotalAlat'];
                ?>
                <td class="text-left" id="pmt_totalhrg">Rp. <?= format_rupiah($totHar);?></td>
            </tr>
            <tr>
                <td rowspan="6"></td>
            </tr>
            <tr>
                <td class="left" colspan="1">PPN <i id="pmt_ppn"><?= $dt['PPN'];?>%</i></td>
                <?php
                    $total = intval($dt['BiayaKunjungan']) + intval($totHar);
                    $ppn = $total * $dt['PPN']/100;
                    $totalBayar = $total + $ppn;
                ?>
                <td class="left" id="pmt_hrgppn">Rp. <?= format_rupiah($ppn);?></td>
            </tr>
            <tr>
                <td class="left" colspan="1">Total Tagihan<input type="hidden" id="totnom" name="tot_nominal"></td>
                <input type="hidden" name="total_harus_bayar" value="<?= $totalBayar; ?>">
                <td class="left">Rp. <?= format_rupiah($totalBayar);?></td>
            </tr>
            <tr>
                <td class="left" colspan="1">Nominal Pembayaran Invoice</td>
                <td class="left">Rp. <?= format_rupiah($dt2['JmlTagihan']);?> 
                    <input type="hidden" id="nom" name="nominal_saat_ini" value="<?= intval($dt2['JmlTagihan']); ?>">
                </td>
            </tr>
            <tr>
                <td class="left" colspan="1">Split Tagihan</td>
                <td class="left">
                    <input type="text" id="tot" name="total_tagihan" class="form-control" placeholder="Total Pembagian Tagihan" value="" required>
                    <input type="hidden" id="toti" name="total_tagihans" >
                </td>
            </tr>
            <tr>
                <td class="left" colspan="1">Sisa Tagihan <input type="hidden" id="inputSisa" name="sisa"></td>
                <td class="left" id="pmt_sisa"></td>
            </tr>
            </tbody>
        </table>
                
            
            

        </div>
        <footer class="card-footer text-right">
            <a href="<?php echo site_url($module); ?>" class="btn btn-secondary btn-bold"><i class="fa fa-arrow-left"></i> Batal</a>
            <button class="btn btn-primary btn-bold" id="btns" type="submit"><i class="fa fa-save"></i> SIMPAN</button>
        </footer>
    </form>
</div>

<script type="text/javascript">
$(function() {

    let group = <?= intval($dt2['PermintaanId']); ?>;

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

    $('#tot').on('keyup', function(e) {
        var total = $('#nom').val();
        var inputan = $(this).val().split('.').join('');
        var sisa = total - inputan;
        $('#pmt_sisa').text('Rp. ' + new Intl.NumberFormat('id-ID').format(sisa));
        $('#inputSisa').val(sisa);

    });


    $('#tot').on('change', function(e) {
        var nominal = $('#nom').val();
        var s = $(this).val().split('.').join('');

        var tot = nominal - s;
        if(tot < 0){
            alert("Nominal Melebihi Tagihan Saat Ini : " + new Intl.NumberFormat('id-ID').format(tot));
            $('#btns').prop('disabled', true);
        }else{
            $('#btns').prop('disabled', false);
        }



    });


function removeCommas(str) {
    while (str.search(",") >= 0) {
        str = (str + "").replace('.', '');
    }
    return str;
};

    var rupiah = document.getElementById("tot");
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



