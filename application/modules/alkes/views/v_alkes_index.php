<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="card">
    <div class="card-header text-right">
        <h4 class="card-title"><strong>Data Barang</strong></h4>
        <div class="btn-toolbar">
            <?php if($roleAdd):?>
            <a id="add-btn" class="btn btn-round btn-label btn-bold btn-primary" href="<?php echo site_url($module . '/add/') ?>">
                Tambah Barang
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
                <label>Nama Barang:</label>
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
            <th width='1%'>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Dasar</th>
            <th>Keterangan</th>
            <th>Status</th>
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
            <label class="require" for="input-required">Kode Barang</label>
            <input type="text" class="form-control"  name="alkesKodeBarang">
            <span class="invalid-feedback" id="error_kodbar"></span>
            </div>

            <div class="form-group">
            <label class="require">Nama Barang</label>
            <input type="text" class="form-control" name="alkesNamaBarang">
            <span class="invalid-feedback" id="error_nambar"></span>
            </div>

            <div class="form-group">
            <label class="require">Harga Dasar</label>
            <input type="text" class="form-control" id="hargadasar" name="alkesHargaDasar">
            <span class="invalid-feedback" id="error_hardas"></span>
            </div>

            <div class="form-group">
            <label >Keterangan</label>
            <textarea class="form-control" name="alkesKeterangan"></textarea>
            <span class="invalid-feedback" id="error_keterangan"></span>
            </div>

            <div class="form-group">
                <label for="select">Status</label>
                <select class="form-control" name="alkesIsAktif">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
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


<script type="text/javascript">
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
        // Add Function
    $('#add-btn').on('click', function(e) {
        e.preventDefault();
            $('#form')[0].reset();
            $('#form').find('input').removeClass('is-invalid');
            $('#form').find('.invalid-feedback').empty();

            $('.modal-title').text('Tambah Barang');
            $('#modal_form').modal('show');
        dt.ajax.reload();
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
    // End Function Add
    // ------- Filter --------------------- //
    $('#frmFilter').on('submit', function(e) {
        e.preventDefault();
        var _this = $(this);
        $('input, select', _this).each(function(){
            setAjaxParams($(this).attr('name'), $(this).val());
        });

        dt.ajax.reload();
    });


    // ----------------- Edit -----------------//
    var modalEdit = function(opt) {
        opt = opt || {};
        app.modaler({
            title: 'Ubah Data Barang',
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
                        app.toast(result.text);
                            dt.ajax.reload();
                        } else {
                            $.each(result.error, function(i, log) {
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

    // --------------- Delete ----------------//
    // modal delete data
    var modalDelete = function(opt) {
        app.modaler({
            html: '<p>Apakah Anda yakin ingin menghapus data ini? <br>Data yang dihapus tidak dapat dikembalikan lagi.',
            title: '<i class="fa fa-warning"></i> Hapus Data Barang',
            cancelVisible: true, cancelText: 'Tidak', cancelClass:'btn btn-secondary',
            confirmText:'Ya', confirmClass:'btn btn-danger',
            onConfirm: opt.callback
        });
    }
    // event btn delete
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

// Form Rupiah
var rupiah = document.getElementById("hargadasar");
rupiah.addEventListener("keyup", function(e) {
rupiah.value = formatRupiah(this.value);
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
return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

</script>