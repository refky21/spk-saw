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
        <h4 class="card-title"><strong>Daftar Permintaan</strong></h4>
        <div class="btn-toolbar">
            
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-times"></i></label>
            </a>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
<!-- <form class="" data-provide="validation" data-disable="false" id="frmAdd" method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>" >   -->
<div class="px-5">
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Pelanggan</label>
        <div class="form-control-plaintext col-sm-10 fw-400">: <?= $pmt['NamaPelanggan'];?></div>

        <label class="col-form-label col-sm-2 float_left text-right ">Penanggung Jawab</label>
        <div class="form-control-plaintext col-sm-10 fw-400" id="PlgnPj">: <?= $pmt['PenanggungJawab'];?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Rencana Kunjungan</label>
        <div class="form-control-plaintext col-sm-10 fw-400">: <?= IndonesianDate($pmt['TglKunjungan']);?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right ">Durasi Pengerjaan</label>
        <div class="form-control-plaintext col-sm-10 fw-400">: <?= $pmt['LamaKunjungan'];?></div>
    </div>
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right">No. HP</label>
        <div class="form-control-plaintext col-sm-10" id="Hp">: <?= $pmt['plgnHp'];?></div>

        <label class="col-form-label col-sm-2 float_left text-right ">Alamat</label>
        <div class="form-control-plaintext col-sm-10 float_left" id="AlamatPelanggan">: <?= $pmt['Alamat'];?></div>
    </div>
    
    <div class="form-group row">
        <label class="col-form-label col-sm-2 float_left text-right required">Catatan</label>
            <div class="col-sm-10 float_left">
                <?= $pmt['Catatan'];?>
            </div>
    </div>
    
    <div class="divider">Detail Alat Kesehatan </div>
    
        <div class="form-group row">
            <div class="col-md-8">
                <button typr="button" id="btnCetak" class="btn btn-round btn-label btn-bold btn-purple"> Cetak Label <label><i class="fa fa-print"></i></label></button>
            </div>
            <?php if($roleAddProses):?>
            <div class="col-md-2"><button id="btnAdd" class="btn btn-round btn-label btn-bold btn-success"> Tambah Alat <label><i class="fa fa-plus"></i></label></button></div>
            <?php endif;?>
        </div>
    
    <div class="form-group row">
            <div class="col-sm-12 float_left">
                <table class="table table-striped table-bordered" cellspacing="0" id="datatables_proses" width="100%" style="margin-top: 5px;">
                    <thead >
                        <tr>
                        <th width="2%">
                            <input type="checkbox" class="group-checkable">
                        </th>
                        <th>No.</th>
                        <th>Nama Alkes</th>
                        <th>Merk Alkes</th>
                        <th>Tipe Alkes</th>
                        <th>No Seri</th>
                        <th>Lokasi Alat</th>
                        <th>Status Kalibrasi</th>
                        <th></th>
                        </tr>
                    </thead>
                        
                </table>
            </div>
    </div>
</div>

    
    <footer class="card-footer text-right">
        <!-- <button class="btn btn-primary" type="submit">SIMPAN</button> -->
    </footer>
    <!-- </form> -->
</div>
</div>
<?php if($roleAddProses):?>
<div class="modal fade" id="modal_form" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Tambah <?php echo $template['title'];?></h4>
            <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span></button>
        </div>
        <form id="form" class="card form-type-combine" method="POST" action="<?php echo site_url($module.'/add_proses/'.$idx) ?>">
            <input type="hidden" name="id_syarat">
            <div class="modal-body">
        <div class="form-groups-attached">
                <div class="form-group">
                    <label>Nomor Seri</label>
                <input class="form-control" type="text" name="no_seri" value="<?= set_value('no_seri');?>">
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label>Merek</label>
                        <input class="form-control" type="text" name="merk" value="<?= set_value('merk');?>">
                    </div>
                    <div class="form-group col-6">
                        <label>Tipe Alat</label>
                        <input class="form-control" type="text" name="tipe_alat" value="<?= set_value('tipe_alat');?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Lokasi ALat</label>
                    <input class="form-control" type="text" name="lokasi_alat" value="<?= set_value('lokasi_alat');?>">
                </div>

                <div class="row">
                    <div class="form-group col-6">
                        <label>Status Kalibrasi</label><br>
                        <select data-provide="selectpicker" data-width="100%" title="-- Pilih --" name="status">
                            <?php foreach($stKali as $st){ ?>
                                <option value="<?= $st['skId'];?>"><?= $st['skNama'];?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label>Catatan</label>
                        <input class="form-control" type="text" name="catatan" value="<?= (isset($dtPmtAlat['Catatan'])) ? $dtPmtAlat['Catatan'] : '';?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label>Jam Mulai</label><br>
                        <input type="text" class="form-control" value="<?= (isset($dtPmtAlat['JamMulai'])) ? $dtPmtAlat['JamMulai'] : '';?>" name="jam_mulai" data-provide="clockpicker" data-autoclose="true" autocomplete="off">
                    </div>

                    <div class="form-group col-6">
                        <label>Jam Selesai</label>
                        <input class="form-control" type="text" value="<?= (isset($dtPmtAlat['JamSelesai'])) ? $dtPmtAlat['JamSelesai'] : '';?>" name="jam_selesai" data-provide="clockpicker" data-autoclose="true" autocomplete="off">
                    </div>
                </div>
            
                <div class="form-group">
                    <label>Permintaan Alat Tambahan</label>
                    <select data-provide="selectpicker" data-width="100%" title="-- Pilih --" name="alat_tambahan">
                        <?php foreach($Detail as $dt){ ?>
                            <option value="<?= $dt['IdDetail'];?>"><?= $dt['NamaAlkes'];?></option>
                        <?php } ?>
                    </select>
                </div>
                
        </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-bold btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-bold btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    </div>
</div>
<?php endif;?>
<script type="text/javascript">
$(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };
    $table = $('#datatables_proses');
    var dt = $table.DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax" : {
            "url" : "<?php echo site_url($module . '/ajax_datatables/proses/'.$idx) ?>",
            "type" : "POST",
            "data" : function(d) {
                $.each(ajaxParams, function(key, value) {
                d[key] = value;
                });
            }
        },
        'drawCallback': function( settings ) {
            $('[data-provide="tooltip"]').tooltip();
            $('.group-checkable', $table).prop('checked', false);
        },
        'language' : {
            'search': 'Cari',
            'searchPlaceholder':'Username / Name',
            'lengthMenu': "Tampil _MENU_",
            'info': "_START_ - _END_ dari _TOTAL_",
            "paginate": {
                "previous": "Prev",
                "next": "Next",
                "last": "Last",
                "first": "First",
                "page": "Page",
                "pageOf": "of"
            }
        },
        'order': [[ 2, 'asc' ]],
        'columnDefs': [
            {"orderable": false, "searchable": false, "targets": [0, 1]},
        ]
    });

    $('#datatables_proses').on('click', '#btnProses', function(e) {
        e.preventDefault();
        var action = $(this).attr('href');
        app.modaler({
            title: 'Data Alat',
            url: action,
            size:'lg',
            footerVisible: false
        });
    });

    

    $('#btnAdd').on('click', function(e) {
        e.preventDefault();
            $('#form')[0].reset();
            $('#form').find('input').removeClass('is-invalid');
            $('#form').find('.invalid-feedback').empty();

            $('.modal-title').text('Tambah Alat');
            $('#modal_form').modal('show');
        // dt.ajax.reload();
    });

        $('.group-checkable', $table).change(function() {
            var set = $table.find('tbody > tr > td:nth-child(1) input[type="checkbox"]');
            var checked = $(this).prop("checked");
            $(set).each(function() {
                $(this).prop("checked", checked);
            });
        });
        
        $('#btnCetak').on('click', function(e) {
            var selected = $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table).length;

            if (selected > 0) 
            {
                app.modaler({
                    html: '<p>Apakah Anda yakin ingin Cetak data yang dipilih ini?',
                    title: '<i class="fa fa-print"></i> Cetak Label',
                    cancelVisible: true, cancelText: 'Tidak', cancelClass:'btn btn-secondary',
                    confirmText:'Ya', confirmClass:'btn btn-danger',
                    onConfirm: function(modal) {
                    $('#process-waiting').show();
                    //c=$(".spinner-circle-material");if(c.length){var d=c.dataAttr("hide-spped",600);c.fadeOut(d)};
                    var args = [];
                    var $checkbox = $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table);
                    $.each($checkbox, function(i, obj) {
                        var val = $(obj).val();
                        args.push(val);
                    });
                    $.ajax({
                        url: "<?php echo site_url('transaksi/BeritaAcara/print_kartu') ?>",
                        type: 'POST',
                        data: {'params' : args},
                        dataType: 'json',
                        success: function(result) {
                            $('#process-waiting').fadeOut();
                            // alert(result.msg);
                            window.open(
                                result.url,
                                '_blank' // <- This is what makes it open in a new window.
                            );
                            // window.location.href = result.url;
                            // console.log(result);
                            dt.ajax.reload(); 
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus + errorThrown);
                        }
                    });
                    }
                });
            }
        });


    });

</script>