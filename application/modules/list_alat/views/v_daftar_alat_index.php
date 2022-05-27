<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php if ($this->session->flashdata('msg')) {
    $msg = $this->session->flashdata('msg');
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
        <h4 class="card-title"><strong>Data Alat</strong></h4>
        <div class="btn-toolbar">
            
        </div> 
    </div>

<div class="card-body" id="tbl-container">
    <form class="" method="POST" action="" id="frmFilter">
        <div class="row">
            <div class="col-md-3">  
            <div class="form-group">
                <label>Nomor Order:</label>
                <input class="form-control" type="text" id="getComplate">
                <input class="form-control" type="hidden" id="filterValue" name="filter_key">
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
            <th>Pelanggan</th>
            <th>Nomor Order</th>
            <th></th>
            </tr>
        </thead>
    </table>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    // Autocomplete
    $( "#getComplate" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?= base_url($module.'/search');?>",
            type: 'post',
            dataType: "json",
            data: {
              search: request.term
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        select: function (event, ui) {
          // Set selection
          $('#getComplate').val(ui.item.label); // display the selected text
          $('#filterValue').val(ui.item.value); // save selected id to input
          return false;
        }
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
            "url" : "<?php echo site_url($module . '/read') ?>",
            "type" : "POST",
            "data" : function(d) {
                $.each(ajaxParams, function(key, value) {
                d[key] = value;
                });
            }
        },
        columnDefs: [
            {
                targets: 1,
                className: 'text-left'
            }
        ],
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

});
</script>