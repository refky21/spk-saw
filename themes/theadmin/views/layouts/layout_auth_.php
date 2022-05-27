<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
      <meta name="keywords" content="login, signin">

      <title><?php echo config_item('app_title') . config_item('title_separator') . $template['title']; ?></title>

    <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
      <link href="<?php echo css_path('core.min.css', '_theme_'); ?>" rel="stylesheet">
      <link href="<?php echo css_path('app.min.css', '_theme_'); ?>" rel="stylesheet">
      <link href="<?php echo css_path('style.css', '_theme_'); ?>" rel="stylesheet">

       <!-- Favicons -->
       <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
       <link rel="icon" href="../assets/img/favicon.png">
   </head>

   <body>


    <div class="row no-gutters min-h-fullscreen bg-white"> 
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(<?php echo image_path('Kampus-4-UAD-FIX.png', '_theme_'); ?>)" data-overlay="5">

        <!-- <div class="row h-100 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
            <img src="../assets/img/logo-light-lg.png" alt="...">
            <br><br><br>
            <h4 class="text-white">The admin is the best admin framework available online.</h4>
            <p class="text-white">Credibly transition sticky users after backward-compatible web services. Compellingly strategize team building interfaces.</p>
            <br><br>
          </div>
        </div> -->

      </div>



      <?php echo $template['body']; ?>
    </div>




    <!-- Scripts -->
    <script src="<?php echo js_path('core.min.js', '_theme_'); ?>"></script>
    <script src="<?php echo js_path('app.min.js', '_theme_'); ?>"></script>
    <script src="<?php echo js_path('script.js', '_theme_'); ?>"></script>

  </body>
</html>

