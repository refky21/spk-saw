<div class="card-body">
    <form class="" method="POST" action="" id="frmFilterBarang">
            <div class="row">
                <div class="col-md-6">  
                    <div class="form-group">
                        <label>Nama Alat</label>
                        <input class="form-control" type="text" name="filter_search">
                    </div>
                </div>
                <div class="col-md-3">  
                    <div class="form-group pt-30">
                        <button type="submit" class="btn btn-secondary btn-round" id="btnFilter"><i class="ti-search"></i> Cari</button>
                    </div>
                </div> 
            </div>
        </form>
    <table class="table table-striped table-bordered" cellspacing="0"  id="datatables_kalibrasi" width="100%">
        <thead>
            <tr>
                <th width="3%;">No.</th>
                <th>ID</th>
                <th>Nama Alat</th>
                <th>Merek</th>
                <th>Nomor Seri</th>
                <th width="10%;">Aksi</th>
            </tr>
        </thead>
    </table>

<script type="text/javascript">
$(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };  
    
    $dtbrang = $('#datatables_kalibrasi').DataTable({
        "processing": true,
        "serverSide": true,
        "lengthMenu": [[20, 35, 50, -1], [20, 35, 50, "All"]],
        "pageLength": '20',
        "ajax" : {
            "url" : "<?php echo site_url($module . '/datatables_kalibrasi'); ?>",
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
        "createdRow": function (row, data, index) {
            $(row.cells[1]).attr('id', 'kode-nama');
            $(row.cells[2]).attr('id', 'merek-kalibrasi');  
            $(row.cells[3]).attr('id', 'nomor-seri');  
        },
        "dom": "<'row'<'col-md-4 col-sm-12'l<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'i><'col-md-4 col-sm-12'p>>",
        'language' : {
            'search': 'Cari',
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
        'columnDefs': [
            /*{"className": "text-center", "targets": [5, 6]},
            {"className": "text-center table-actions", "targets": [7]},*/
            {"visible": false, "targets":[1]},
            {"className": "table-actions", "targets": [4]},
            {"orderable": false, "targets": '_all'} 
        ]
    });

    $('#frmFilterBarang').on('submit', function(e) {
        var _this = $(this);
        e.preventDefault();
        $('#frmFilter').attr('action', '');
        $('input, select', _this).each(function(){
            setAjaxParams($(this).attr('name'), $(this).val());
        });

        $dtbrang.ajax.reload();
    });


    $('#datatables_kalibrasi').on('click', '#btnPilih', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id'),
            kode = $(this).parents('tr').find('#kode-nama').text(),
            merk = $(this).parents('tr').find('#merk-kalibrasi').text(),
            seri = $(this).parents('tr').find('#nomor-seri').text();

        let $tbody = $('#tblKali').find('tbody');
        var $empty_list = $tbody.find('#empty-list').length;
        if ($empty_list > 0) {
            $tbody.find('#empty-list').remove();
        }

        let $tr = $('#tmplListKalibrasi').clone(true).attr('id', 'kalibrator').removeAttr('style');

        var list = $tbody.find('tr'), counter = (list.length - 1);
    

        //console.log($tr.find('#empty-list'));

        $tr.find('[scope="row"]').text(counter+1);
        $tr.find('.kode_nama').text(kode);
        $tr.find('.mrk_kali').text(merk);
        $tr.find('.no_seri').text(seri);
        $tr.find('#kalibrasi-id').attr('name', 'kalibrasi_id[]').val(id);

        $tr.appendTo($tbody);
        $('#frmAdd').validator('update');
        $('.modal').modal('hide');
    });

});
</script>
</div>
