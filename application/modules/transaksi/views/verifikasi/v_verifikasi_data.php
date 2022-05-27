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
        <h4 class="card-title"><strong>Data Pelanggan</strong></h4>
        <div class="btn-toolbar">
            <a class="btn btn-round btn-label btn-bold btn-danger" href="<?php echo site_url($module) ?>">
                Kembali
                <label><i class="fa fa-times"></i></label>
            </a>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
    
    <div class="card-body">
            <form class="card form-type-combine" method="POST" action="" id="frmFilter">
            <div class="col-md-8">
                <div class="form-groups-attached">
                    <div class="row">
                    <div class="form-group col-5">
                        <label>Nama Pelanggan</label>
                        <input class="form-control" type="text" value="<?= $Plgn['NamaPelanggan'];?>" disabled>
                    </div>

                    <div class="form-group col-4">
                        <label>Penanggung Jawab</label>
                        <input class="form-control" type="text" value="<?= $Plgn['PenanggungJawab'];?>" disabled>
                    </div>
                    <div class="form-group col-3">
                        <label>No Telpon</label>
                        <input class="form-control" type="text" value="<?= $Plgn['HpPelanggan'];?>" disabled>
                    </div>
                    </div>

                    <div class="form-group">
                    <label>Alamat</label>
                    <input class="form-control" type="text" value="<?= $Plgn['AlamatPelanggan'];?>" disabled>
                    </div>

                    </div>

                </div>
            </div>
            </form> 
            

            <!-- Bagian Data -->
                <div class="divider">Detail Alat Kesehatan </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <button id="btnVerifikasi" class="btn btn-round btn-label btn-bold btn-success"> Verifikasi <label><i class="fa fa-check"></i></label></button>
                    </div>
                    <div class="col-md-2">
                        <button id="btnAdd" class="btn btn-round btn-label btn-bold btn-primary"> Tambah Alat <label><i class="fa fa-plus"></i></label></button>
                    </div>
                </div>
            <div class="form-group row">
                <div class="col-sm-12 float_left">
                    <table class="table table-striped table-bordered" cellspacing="0" id="datatables_alkes" width="100%" style="margin-top: 5px;">
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
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Status Kalibrasi</th>
                            <th>Status Verifikasi</th>
                            <th></th>
                            </tr>
                        </thead>
                            
                    </table>
                </div>
            </div>
    </div>
</div>

</div>

<!-- Modal Add -->
<div class="modal fade" id="modal_form" tabindex="-1">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Tambah <?php echo $template['title'];?></h4>
            <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span></button>
        </div>
        <form id="form" class="card form-type-combine" method="POST" action="<?php echo site_url($module.'/alat/'.$idx) ?>">
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

<div id="process-waiting" style="position: absolute;bottom: 40%; left: 50%; display: none;">
    <div class="spinner-dots" >
        <span class="dot1"></span> <span class="dot2"></span><span class="dot3"></span>
    </div>
</div>

<!-- Ajax -->
<script type="text/javascript">
$(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };
    $table = $('#datatables_alkes');
    var dt = $table.DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax" : {
            "url" : "<?php echo site_url($module . '/datatables_ajax/alkes/'.$idx) ?>",
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
            {"orderable": false, "searchable": false, "targets": [9]}
        ]
    });
    $('#datatables_alkes').on('click', '#btnProses', function(e) {
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

        $('#btnVerifikasi').on('click', function(e) {
            var selected = $('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked', $table).length;

            if (selected > 0) 
            {
                app.modaler({
                    html: '<p>Apakah Anda yakin ingin proses Verifikasi data yang dipilih ini?',
                    title: '<i class="fa fa-warning"></i> Verifikasi Alat',
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
                        url: "<?php echo site_url('transaksi/Verifikasi/proses/verif') ?>",
                        type: 'POST',
                        data: {'params' : args},
                        dataType: 'json',
                        success: function(result) {
                            $('#process-waiting').fadeOut();
                            alert(result.msg);
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