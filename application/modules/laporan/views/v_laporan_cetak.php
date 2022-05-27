<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php if ($this->session->flashdata('msg_prodi')) {
   $msg = $this->session->flashdata('msg_prodi');
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
      <h4 class="card-title"><strong>Laporan Pelaksanaan Kalibrasi</strong></h4>
   </div>

   <div class="card-body">
      <form class="" method="POST" action="" id="frmFilter">
         <div class="row">
           <label>Nomor Order:</label>
            <div class="col-md-4">  
               <div class="form-group">
                  <select name="filter_permintaan" class="form-control" data-provide="selectpicker">
                     <option value="">-- SEMUA --</option>
                     <?php foreach($permintaan as $data) {?>
                     <option value="<?= $data['id']; ?>" ><?= $data['nomorOrder']; ?></option>
                     <?php } ?>
                  </select>
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
            <th width="5%">No.</th>
            <th>Nomor Order</th>
            <th>Nama Alat Kesehatan</th>
            <th>Nomor Seri</th>
            <th>Merk</th>
            <th>Type/Model</th>
            <th>Lokasi</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Hasil</th>
            <th style="color: blue;">Petugas</th>
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

   var dt = $('#datatables_ajax').DataTable({
      "processing": true,
      "serverSide": true,
      "searching": false,
      "ajax" : {
         "url" : "<?= site_url('laporan/Laporan/datatables_laporan/') ?>",
         "type" : "POST",
         "data" : function(d) {
            //d.order_asesiNama = "sutri";
            $.each(ajaxParams, function(key, value) {
               d[key] = value;
            });
         }
      },
      'drawCallback': function( settings ) {
         $('[data-provide="tooltip"]').tooltip();
      },
      //"dom": "<'row'<'col-md-4 col-sm-12'l<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'i><'col-md-4 col-sm-12'p>>",
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
      'columnDefs': [
         {"visible": true, "targets":[1]},
         {"orderable": false, "searchable": false, "targets": [0]},
         {"orderable": false, "searchable": false, "className":"text-right table-actions", "targets": [5]}
      ]
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