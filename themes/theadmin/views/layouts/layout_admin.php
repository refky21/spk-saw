<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="description" content="TheAdmin - Responsive admin and web application ui kit">
    <meta name="keywords" content="admin, dashboard, web app, sass, ui kit, ui framework, bootstrap"> -->

    <title><?php echo config_item('app_title') . config_item('title_separator') . $template['title']; ?></title>

    <!-- Styles -->
    
    <link href="<?php echo css_path('font.css', '_theme_'); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">
    <link href="<?php echo css_path('core.min.css', '_theme_'); ?>" rel="stylesheet">
    <link href="<?php echo css_path('app.min.css', '_theme_'); ?>" rel="stylesheet">
    <link href="<?php echo css_path('style.css', '_theme_'); ?>" rel="stylesheet">

    <?php echo $template['partials']['modules_css']; ?>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="<?php echo image_path('apple-touch-icon.png', '_theme_'); ?>">
    <link rel="icon" href="<?php echo image_path('logo.png', '_theme_'); ?>">
    <style rel="stylesheet" type="text/css">
         #codeigniter_profiler {max-width: 90%; min-width: 35em; position: fixed; bottom: 0; width: auto; display: block; font-family: Monaco,Menlo,Consolas,"Courier New",monospace; margin-left: 260px;}
         #codeigniter_profiler > fieldset {display: none; margin: 0!important; }
         #ci_profiler_menu {margin: 0; background: #DDD;}
         #ci_profiler_menu:after {clear: both; content: ""; display: table;}
         #ci_profiler_menu ul {list-style-type: none; margin: 0; padding: 0; float: left;}
         #ci_profiler_menu ul li {display: block; line-height: 15px; float: left; margin: 0 2px; text-align: center;}
         #ci_profiler_menu ul > li > a {padding: 5px 10px 0; text-transform: uppercase; text-decoration: none; display: block; font-weight: bolder;}
         #ci_profiler_menu ul > li > span {font-size: 11px;}
         #ci_profiler_queries table tr td {color: #252525;}  
         .profiler_default {border-bottom: 4px solid #333333; } .profiler_default a{color: #333333;} 
         .profiler_blue  {border-bottom: 4px solid #0000FF;} .profiler_blue a{ color: #0000FF;}
         .profiler_green {border-bottom: 4px solid #009900; } .profiler_green a {color: #009900;}
         .profiler_magenta {border-bottom: 4px solid #5A0099; } .profiler_magenta a {color: #5A0099;}
         .profiler_brown {border-bottom: 4px solid #990000; } .profiler_brown a {color: #990000;}
      </style>

      <script src="<?php echo js_path('core.min.js', '_theme_'); ?>"></script>
  </head>

  <body>

    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner-dots">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
      </div>
    </div>
 

    <!-- Sidebar -->
    <aside class="sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg ">
      <header class="sidebar-header" style="background-color:#177196;background-image:-moz-linear-gradient(bottom,#177196,#1B8FB2);!important;">
      
      <h3 class="topbar-title" style="color:#fff !important;"><?php echo config_item('app_name') ?></h3>

      </header>

      <nav class="sidebar-navigation">
        <ul class="menu">
         <li class="menu-item">
            <a class="menu-link" href="<?php echo site_url('dashboard/Dashboard/index') ?>">
              <span class="icon fa fa-home"></span>
              <span class="title">Dashboard</span>
            </a>
          </li>
         <li class="menu-category">Menu App</li>

          <?php echo $this->authentication->render_menu('1');?>
        </ul>
      </nav>

    </aside>
    <!-- END Sidebar -->


    <!-- Topbar -->
    <header class="topbar" >
      <div class="topbar-left">
        <span class="topbar-btn sidebar-toggler"><i>&#9776;</i></span>
      </div> 
      <?php if ($this->authentication->is_logged_in()) {?>
      <div class="topbar-right">
        <ul class="topbar-btns">
         <li class="dropdown">
              <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="<?php echo image_path('avatar/1.jpg', '_theme_'); ?>" alt="..."></span>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?php echo site_url('system/Profile/update/'.encode(get_user_id())) ?>"><i class="ti-user"></i> Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>"><i class="ti-power-off"></i> Logout</a>
              </div>
            </li>
        </ul>
      </div>
      <?php } ?>
    </header>
    <!-- END Topbar -->


    <!-- Main container -->
    <main class="main-container">
      <header class="header no-border">
          <div class="header-bar header-title">
           <h4><?php echo $template['title'];?></h4>
            <ol class="breadcrumb breadcrumb-arrow">
               <?php 
               if( !empty( $template['breadcrumbs'] ) ){
                  $total_breadcrumbs = count( $template['breadcrumbs'] );
                  $count_breadcrumbs = 1;
                  foreach($template['breadcrumbs'] as $breadcrumbs){
                     if( $count_breadcrumbs == $total_breadcrumbs ){
                        echo '<li class="breadcrumb-item active">';
                        echo $breadcrumbs['name'];
                     } else {
                        echo '<li class="breadcrumb-item">';
                        echo '<a href="'. site_url($breadcrumbs['uri']) .'" class="text-info">'. $breadcrumbs['name'] .'</a>';
                     }
                     echo '</li>';
                     $count_breadcrumbs++;
                  }
               } else {
               ?>
                  <li class="breadcrumb-item active">
                     <a href="<?php echo site_url(); ?>"><?php echo config_item('app_name'); ?></a>
                  </li>
            <?php } ?>
            </ol>
          </div>
        </header>
      <div class="main-content">
         <?php echo $template['body']; ?>
      </div><!--/.main-content -->


      <!-- Footer -->
      <footer class="site-footer">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center text-md-left">Copyright © <?= date('Y');?> <a href="https://bsi.uad.ac.id">BSI UAD</a>. All rights reserved.</p>
          </div>

          <div class="col-md-6">
            <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
              <li class="nav-item">
                <a class="nav-link" href="../help/articles.html">Documentation</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../help/faq.html">FAQ</a>
              </li>
<!--               <li class="nav-item">
                <a class="nav-link" href="https://themeforest.net/item/theadmin-responsive-bootstrap-4-admin-dashboard-webapp-template/20475359?license=regular&amp;open_purchase_for_item_id=20475359&amp;purchasable=source&amp;ref=thethemeio">Purchase Now</a>
              </li> -->
            </ul>
          </div>
        </div>
      </footer>
      <!-- END Footer -->

    </main>
    <!-- END Main container -->



    <!-- Global quickview -->
    <div id="qv-global" class="quickview" data-url="assets/data/quickview-global.html">
      <div class="spinner-linear">
        <div class="line"></div>
      </div>
    </div>
    <!-- END Global quickview -->




    <!-- Scripts -->
    
    <script src="<?php echo js_path('app.min.js', '_theme_'); ?>"></script>
    <script src="<?php echo js_path('script.js', '_theme_'); ?>"></script>

    <?php echo $template['partials']['modules_js']; ?>
     <script type="text/javascript">
      jQuery(document).ready(function() 
      {  
         var $profiler = $('.profiler_menu'); 
         var fieldset = $('#codeigniter_profiler').find('fieldset');
         $profiler.click(function(e){
            that = $(this).attr('href');
            //$(id_profiler).show();
            $.each(fieldset, function(idx, val){
               if($(this).hasClass('show')) {
                  $(this).removeClass('show');
               }
               $(this).hide();
            });

            if(that != 'collapse_all') {
               $(that).addClass('show').show();
            }
            
         });

      });
      </script>
  </body>
</html>
