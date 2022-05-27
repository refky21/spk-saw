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
        <h4 class="card-title"><strong>Pembayaran Invoice</strong></h4>
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
                    <label class="col-form-label col-xl-2 col-md-3">Invoice Pelanggan </label>
                    <div class="col-4">
                        <select name="invoice_id" id="spk" class="form-control" data-provide="selectpicker" title="Pilih" data-live-search="true">
                            <?php foreach($listInvoice as $inv) {?>
                                <option value="<?php echo $inv['id'] ?>" 
                                data-tgl="<?php echo IndonesianDate($inv['TanggalInvoice'])?>" 
                                data-pmt="<?php echo $inv['Permintaan']?>" 
                                data-noinvoice="<?php echo $inv['NomorInvoice']?>" 
                                data-tghn="<?php echo $inv['JumlahTagihan']?>" 
                                ><?php echo $inv['NomorInvoice']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label class="col-form-label col-xl-2 col-md-3">Nomor Invoice</label> 
                    <div class="col-4">
                        <p class="form-control-plaintext fw-400" id="invoice">: </p>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label class="col-form-label col-xl-2 col-md-3">Tanggal Invoice</label> 
                    <div class="col-4">
                        <p class="form-control-plaintext fw-400" id="pmt_tgl">: </p>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label class="col-form-label col-xl-2 col-md-3">Total Invoice</label> 
                    <div class="col-4">
                        <input type="hidden" id="totnom">
                        <p class="form-control-plaintext fw-400" id="tghn">: </p>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-form-label col-xl-2 col-md-3 required">Nominal Pembayaran</label>
                    <div class="col-3">
                        <input type="hidden" id="pmt" name="permintaan_id">
                        <input type="text" id="nom" name="total_pembayaran" class="form-control" autocomplete="off" placeholder="Jumlah Bayar" value="" required>
                        <div class="invalid-feedback" id="error_pic"></div>
                    </div>
                </div>
                
        </div>
        <div class="text-left" style="display:none;" id="text">
                Catatan : Sesuaikan Nominal Pembayaran Invoice dengan Jumlah Bayar
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
        let val = $(this).val();
        if (val != '') {

            $('#invoice').text(': ' + $('option:selected', this).data('noinvoice'));
            $('#pmt_tgl').text(': ' + $('option:selected', this).data('tgl'));
            $('#pmt').val($('option:selected', this).data('pmt'));
            $('#tghn').text(': ' + new Intl.NumberFormat('id-ID').format($('option:selected', this).data('tghn')));
            $('#totnom').val(new Intl.NumberFormat('id-ID').format($('option:selected', this).data('tghn')));
            
        }
    });


    $('#nom').on('change', function(e) {
        var total = $('#totnom').val().split('.').join('');
        var inputan = $(this).val().split('.').join('');

        if(inputan < total){
            alert("Harap Pembayaran Tidak Boleh Kurang dari : " + new Intl.NumberFormat('id-ID').format(total));
            $('#btns').prop('disabled', true);
        }else{
            $('#btns').prop('disabled', false);
        }
        if(inputan > total){
            alert("Pembayaran Anda Lebih Besar Dari  : " + new Intl.NumberFormat('id-ID').format(total));
            $('#btns').prop('disabled', true);
        }else{
            $('#btns').prop('disabled', false);
        }



    });


var rupiah = document.getElementById("nom");
rupiah.addEventListener("keyup", function(e) {
    rupiah.value = formatRupiah(this.value, "");
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



