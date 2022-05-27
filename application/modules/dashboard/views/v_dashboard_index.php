<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="main-content">
        <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card card-body bg-danger">
              <div class="flexbox">
                <span class="ti-wallet fs-40"></span>
                <span class="fs-40"><?= $tot_beasiswa;?></span>
              </div>
              <div class="text-right">Total Beasiswa</div>
            </div>
          </div>

         <div class="col-md-6 col-xl-4">
            <div class="card card-body bg-purple">
              <div class="flexbox">
                <span class="fa fa-users fs-40"></span>
                <span class="fs-40 fw-100"><?= $tot_daftar;?></span>
              </div>
              <div class="text-right">Total Pendaftar</div>
            </div>
          </div>
          
          <!-- <div class="col-md-6 col-xl-3">
            <div class="card card-body">
              <div class="flexbox">
                <span class="ti-user text-purple fs-40"></span>
                <span class="fs-40 fw-100">6,568</span>
              </div>
              <div class="text-right">Peserta Lolos</div>
            </div>
          </div> -->
          
          <div class="col-md-6 col-xl-4">
            <div class="card card-body bg-info">
              <div class="flexbox">
                <span class="ti-check fs-40"></span>
                <span class="fs-40"><?= $tot_lulus;?></span>
              </div>
              <div class="text-right">Peserta Lulus</div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <h4 class="card-title"><strong>Statistik</strong> Beasiswa</h4>

          <div class="card-body">
          <form class="" method="POST" action="" id="frmFilter">
          <div class="row">
              <div class="col-md-3">  
                  <div class="form-group">
                    <label>Beasiswa:</label>
                    <select name="filter_beasiswa" class="form-control filter_beasiswa" data-provide="selectpicker">
                     <option value="">-- SEMUA --</option>
                     <?php foreach($beasiswa as $item) {?>
                     <option value="<?php echo $item['id']; ?>" ><?php echo $item['nama']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                </div>
                <div class="col-md-3">  
                  <div class="form-group">
                    <label>Tahun:</label>
                    <select name="filter_tahun" id="filter_tahun" class="form-control filter_tahun" data-provide="selectpicker">
                     <option value="">-- SEMUA --</option>
                     <?php foreach($tahun as $thn) {?>
                     <option value="<?php echo $thn['tahun']; ?>" ><?php echo $thn['tahun']; ?></option>
                     <?php } ?>
                  </select>
                </div>
               </div>
                <!-- <div class="col-md-3">  
                    <div class="form-group">
                      <label>Periode:</label>
                      <select name="filter_periode" id="filter_periode" class="form-control" data-provide="selectpicker">
                        <option value="">-- SEMUA --</option>
                        
                      </select>
                  </div> -->
                </div>
               </div>
               </form>  
            <div class="init-loading grafik" style="height:600px;width:100%;"></div>
          </div>
        </div>
      </div>

<script>
  $(function() {
    var ajaxParams = {};
    var setAjaxParams = function(name, value) {
        ajaxParams[name] = value;
    };

    $('#frmFilter').on('submit', function(e) {
      e.preventDefault();

      var _this = $(this);
      $('input, select', _this).each(function(){
         setAjaxParams($(this).attr('name'), $(this).val());
      });

   });

  });
  var filtering = {}
  $(document).ready(function() {
    filter()
    filter2()
            init()
  });

  function filter() {
      $('.filter_tahun').change(function() {
          filtering['filter_tahun'] = $(this).val();
          init()
      })
  }
  function filter2() {
      $('.filter_beasiswa').change(function() {
          filtering['filter_beasiswa'] = $(this).val();
          init()
      })
  }



  function init(){
    $(".init-loading").html("<i class='fa fa-spin fa-refresh'></i> &nbsp;&nbsp;&nbsp;Memuat Data ...");
    grafik();
  }

  function grafik() {
    $.ajax({
      type: "post",
      url: "<?php echo site_url($module . '/data_grafik') ?>",
      data: filtering,
      dataType: "json",
      success: function(data) {
          barChart(data, "grafik");
      }
    })
  }


  function barChart(data, chartdiv) {
   var chart = am4core.create(chartdiv, am4charts.XYChart);
   chart.data = data;
   // Create axes
   var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
   categoryAxis.dataFields.category = "PeriodeBeasiswa";
   categoryAxis.renderer.grid.template.location = 0;
   categoryAxis.renderer.minGridDistance = 20;
   categoryAxis.renderer.inside = false;
   categoryAxis.start = 0;

   categoryAxis.renderer.grid.template.disabled = true;
   var label = categoryAxis.renderer.labels.template;
   label.wrap = true;
   label.maxWidth = 160;
   label.tooltipText = "{category}";

   categoryAxis.events.on("sizechanged", function(ev) {
     var axis = ev.target;
     var cellWidth = axis.pixelWidth / (axis.endIndex - axis.startIndex);
     if (cellWidth < axis.renderer.labels.template.maxWidth) {
        axis.renderer.labels.template.rotation = -75;
        axis.renderer.labels.template.horizontalCenter = "right";
        axis.renderer.labels.template.verticalCenter = "middle";
     } else {
        axis.renderer.labels.template.rotation = 0;
        axis.renderer.labels.template.horizontalCenter = "middle";
        axis.renderer.labels.template.verticalCenter = "top";
     }
   });

   var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
   valueAxis1.extraMax = 0.3;
   valueAxis1.min = 0;
   var series1 = chart.series.push(new am4charts.ColumnSeries());
   series1.dataFields.valueY = "data";
   series1.dataFields.categoryX = "PeriodeBeasiswa";
   series1.name = "Penerima Beasiswa";
   series1.yAxis = valueAxis1;
   series1.columns.template.tooltipText = "{valueY.value}";
   

   chart.cursor = new am4charts.XYCursor();
   chart.legend = new am4charts.Legend();
   chart.legend.position = "top";
}
</script>



