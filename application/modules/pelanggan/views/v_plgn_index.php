<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php if ($this->session->flashdata('msg_monev')) {
    $msg = $this->session->flashdata('msg_monev');
?>
<div class="alert alert-<?php echo $msg['type'];?> alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
        <i class="fa fa-<?php echo $msg['status'] ? 'check' : 'warning'; ?>"></i> <?php echo $msg['text'];?>
</div>
<?php } ?>
<div class="card">
    <div class="card-header text-right">
        <h4 class="card-title"><strong>Data Pelanggan</strong></h4>
        <div class="btn-toolbar">
            <?php if($roleAdd):?>
                <a id="add-btn" class="btn btn-round btn-label btn-bold btn-primary" href="<?php echo site_url($module . '/add/') ?>">
                    Tambah Pelanggan
                    <label><i class="ti-plus"></i></label>
                </a>
            <?php endif;?>
        </div> 
    </div>

<div class="card-body" id="tbl-container">
    <form class="" method="POST" action="" id="frmFilter">
        <div class="row">
            <div class="col-md-3">  
            <div class="form-group">
                <label>Nama Pelanggan:</label>
                <input class="form-control" type="text" name="filter_key">
            </div>
            </div>
            <div class="col-md-3">  
            <div class="form-group pt-30">
                <button type="submit" class="btn btn-secondary btn-round"><i class="ti-search"></i> Filter</button>
            </div>
            </div> 
        </div>
    </form> 

    <table class="table table-striped table-bordered" cellspacing="0" id="datatables_ajax" width="100%">
        <thead >
            <tr>
            <th width='5%'>No.</th>
            <th>Kategori</th>
            <th>Nama</th>
            <th>Penanggung Jawab</th>
            <th>No Handphone</th>
            <th>Alamat</th>
            <th width='10%'></th>
            </tr>
        </thead>
    </table>
</div>
</div>

<!-- mdl -->
<div class="modal fade" id="modal_form" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Tambah <?php echo $template['title'];?></h4>
        <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span></button>
    </div>
    <form id="form" class="form-horizontal" method="POST" action="<?php echo site_url($module.'/add') ?>">
        <div class="modal-body">
            <div class="form-group">
            <label class="require" for="input-required">Kategori Pelanggan</label>
                <select name="kat_plgn" data-provide="selectpicker" data-live-search="true" title="Pilih Kategori" data-width="100%">
                <?php foreach($listKat as $ka){?>
                    <option value="<?= $ka['id'];?>"><?= $ka['Kategori'];?></option>
                <?php }?>
                </select>
            </div>

            <div class="form-group">
            <label class="require" for="input-required">Nama Pelanggan</label>
            <input type="text" class="form-control"  name="nama">
            <span class="invalid-feedback" id="error_nama"></span>
            </div>

            <div class="form-group">
            <label >Penanggung Jawab</label>
            <input type="text" class="form-control" name="penanggung_jawab">
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>

            <div class="form-group">
            <label >No.Handphone</label>
            <input type="text" class="form-control" name="hp">
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>
            <div class="form-group">
            <label class="require" for="input-required">Propinsi</label>
                <select name="propinsi" id="add_prop" data-provide="selectpicker" data-live-search="true" title="Pilih Propinsi" data-width="100%">
                <?php foreach($listProp as $pro){?>
                    <option value="<?= $pro['id'];?>"><?= $pro['PropNama'];?></option>
                <?php }?>
                </select>
            </div>
            <div class="form-group">
            <label class="require" for="input-required">Kabupaten</label>
                <select id="add_kab" name="kabupaten" class="form-control" >
                </select>
            </div>

            <div class="form-group">
            <label >Alamat</label>
            <textarea class="form-control" name="alamatPlgn"></textarea>
            <span class="invalid-feedback" id="error_keterangan"></span>
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

<script type="text/javascript">
    // FUnction Prop
    $(document).ready(function(){
        $("#add_prop").change(function(){
            var prop_id = $('#add_prop').val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('pelanggan/Pelanggan/ajax_kabupaten');?>",
                data: { id : prop_id},
                dataType: "json",
                success: function (res) {
                    var string_html = "<option value=''>-- Pilih Kabupaten --</option>";
                    // console.log(res);
                    $.each(res, function (key, value) {
                        string_html = string_html+"<option value='"+value.id+"'>"+value.KabNama+"</option>";
                        console.log(string_html);
                    });
                    $('#add_kab').html(string_html);
                }
            });
        });

    });
$(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };

    var dt = $('#datatables_ajax').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax" : {
            "url" : "<?php echo site_url($module . '/read/') ?>",
            "type" : "POST",
            "data" : function(d) {
                $.each(ajaxParams, function(key, value) {
                d[key] = value;
                });
            }
        },
        'drawCallback': function( settings ) {
            $('[data-provide="tooltip"]').tooltip();
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
        'order': [[ 3, 'asc' ], [ 1, 'asc' ]],
    });

    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

    $('#frmFilter').on('submit', function(e) {
        e.preventDefault();

        var _this = $(this);
        $('input, select', _this).each(function(){
            setAjaxParams($(this).attr('name'), $(this).val());
        });

        dt.ajax.reload();
    });

    $('#add-btn').on('click', function(e) {
        e.preventDefault();
            $('#form')[0].reset();
            $('#form').find('input').removeClass('is-invalid');
            $('#form').find('.invalid-feedback').empty();

            $('.modal-title').text('Tambah Pelanggan');
            $('#modal_form').modal('show');
        // dt.ajax.reload();
    });

    $('#form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(result) {
            if (result.error == 'null') {
            $('#modal_form').modal('hide');
            // notif({type:'success', message:result.msg});
            app.toast(result.text);
            dt.ajax.reload();
            
            } else {
            $.each(result.error, function(i, log) {
                //console.log(i);
                $('[name="'+i+'"]').addClass('is-invalid');
                $('#error_'+i).text(log);
            });
            }            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus + errorThrown);
        }
    });
});
    // modal edit data
    var modalEdit = function(opt) {
        opt = opt || {};
        app.modaler({
            title: 'Ubah Data Pelanggan',
            url: opt.url,
            footerVisible: false,
            onConfirm: opt.callback
        });
    }
    // event btn edit
    $('#datatables_ajax').on('click', '#edit-btn', function() {
        var id = $(this).attr('data-id'),
        module = "<?php echo site_url($module.'/update/') ?>" + id;
        modalEdit({
            url: module,
            callback: function(modal) {
                $frm = modal.find('form');
                $($frm[0]).on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(result) {

                        if (result.error == 'null') {
                            $('#'+modal[0].id).modal('hide');
                            // notif({type:'success', message:result.text});
                        app.toast(result.text);
                            dt.ajax.reload();
                        } else {
                            $.each(result.error, function(i, log) {
                            //console.log(i);
                            $('[name="'+i+'"]').addClass('is-invalid');
                            $('#error_'+i).text(log);
                            });
                        }            
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus + errorThrown);
                    }
                });
                });
            }
        });
    });  

    var modalDelete = function(opt) {
        app.modaler({
            html: '<p>Apakah Anda yakin ingin menghapus data ini? <br>Data yang dihapus tidak dapat dikembalikan lagi.',
            title: '<i class="fa fa-warning"></i> Hapus Pelanggan',
            cancelVisible: true, cancelText: 'Tidak', cancelClass:'btn btn-secondary',
            confirmText:'Ya', confirmClass:'btn btn-danger',
            onConfirm: opt.callback
        });
    }

    $('#datatables_ajax').on('click', '#del-btn', function() {
        var url = "<?php echo site_url($module.'/delete/') ?>" + $(this).attr('data-id');
        modalDelete({
            callback: function(modal) {
                $.get(url, function(result) {
                app.toast(result.text);
                dt.ajax.reload();
                });
            }
        });
    });




});
</script>