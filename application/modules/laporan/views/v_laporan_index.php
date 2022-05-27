<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
  if ($this->session->flashdata('msg')) {
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
    <h4 class="card-title"><strong>Laporan Pelaksanaan Pengujian</strong></h4>
  </div>

  <div class="card-body" id="tbl-container"></div>

    <div class="row mb-3">
      <div class="col-12">
        <form action="" method="POST" id="frmFilter">
          <div class="row">
            <div class="col-md-1">
              <label for="permintaan" class="col-form-label float-left mt-2">Nomor Order</label>
            </div>
            <div class="col-md-5 form-control-plaintext">
              <select data-provide="selectpicker" class="form-control" id="filter_permintaan" name="filter_permintaan" data-live-search="true" data-header="Pilih Nomor Order" data-width="50%">
                <option value="">-- SEMUA --</option>
                <?php foreach($permintaan as $data) : ?>
                <option value="<?= $data['id']; ?>"><?= $data['nomorOrder']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
        </form>

          <div class="col-md-6">
            <div class="float-right mr-4 mt-2">
              <button id="export" class="btn btn-primary "><i class="fa fa-file-excel-o"></i> Export </button>       
            </div>
          </div>
        </div>
      </div>
    </div>

    <table class="table table-striped table-bordered" id="datatables_ajax" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th width="5%">No.</th>
          <th>Nomor Order</th>
          <th>Nama Alat Kesehatan</th>
          <th>Nomor Seri</th>
          <th>Merk</th>
          <th>Type/Model</th>
          <th width="10%">Lokasi</th>
          <th>Tanggal Pelaksanaan</th>
          <th>Hasil</th>
          <th style="color: blue;" width="15%">Petugas</th>
          <th>No. Sertifikat</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

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
            "url" : "<?= site_url('laporan/Laporan/datatables_laporan/') ?>",
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
        'order': [[ 9, 'asc' ], [ 1, 'asc' ]],
    });
    // Filter
    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        });
    }).draw();

   $('#frmFilter').click(function(e) {
    e.preventDefault();

    var _this = $(this);
    $('input, select', _this).each(function(){
      var i = $(this).val();
      setAjaxParams($(this).attr('name'), $(this).val());
      // console.log(i);
    });

    dt.ajax.reload();
   });

   $('#export').click(function(e) {
      var permintaan = $('#filter_permintaan').val();

      var url = "<?= site_url('laporan/Laporan/export/'); ?>" + permintaan;
      console.log('value:', permintaan, 'url:', url);
      window.open(url, '_blank');
   });
   
});
</script>
