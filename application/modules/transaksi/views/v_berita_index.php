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
        <h4 class="card-title"><strong>Data Perimintaan</strong></h4>
        <div class="btn-toolbar">
           
        </div> 
    </div>

<div class="card-body" id="tbl-container">
    <form class="" method="POST" action="" id="frmFilter">
        <div class="row">
            <div class="col-md-6"> 
            
            </div>
            <div class="col-md-6">  
                <div class="input-group">
                    <input type="text" name="filter_key" class="form-control" placeholder="Ex : Nama Pelanggan atau Nomor Order">
                    <span class="input-group-append">
                    <button class="btn btn-light" type="submit">Cari!</button>
                    </span>
                </div>
            </div>
            <hr>
        </div>
    </form> 

    <table class="table table-striped table-bordered" cellspacing="0" id="datatables_ajax" width="100%">
        <thead >
            <tr>
            <th width='2%'>No.</th>
            <th>No Order</th>
            <th>Pelanggan</th>
            <th>Penanggung Jawab</th>
            <th>Status Permintaan</th>
            <th>Permintaan Alat</th>
            <th>Permintaan</th>
            <th>Rencana Kunjungan</th>
            <th>Rencana Realisasi</th>
            <th width='13%'><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
    </table>
</div>
</div>


<!-- Ajax -->
<script type="text/javascript">
$(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };

    // Ajax Datatable
    var dt = $('#datatables_ajax').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax" : {
            "url" : "<?php echo site_url($module . '/ajax_datatables/') ?>",
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
    // Filter
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
    // Ajax Button

    $('#datatables_ajax').on('click', '#btnList', function(e) {
        e.preventDefault();
        app.modaler({
            title: 'List Alat Kesehatan',
            url: $(this).attr('data-url'),
            size:'lg',
            footerVisible: false,
            backdrop: false,
            keyboard: false
        });
    });




});


</script>


