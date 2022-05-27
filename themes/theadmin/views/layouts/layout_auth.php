<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="login, signin">

    <title><?php echo config_item('app_title') . config_item('title_separator') . $template['title']; ?></title>

    <!-- Fonts -->
    <!-- link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet" -->
    <link href="<?php echo css_path('font.css', '_theme_'); ?>" rel="stylesheet">
    <!-- Styles -->
    <link href="<?php echo css_path('core.min.css', '_theme_'); ?>" rel="stylesheet">
      <link href="<?php echo css_path('app.min.css', '_theme_'); ?>" rel="stylesheet">
      <link href="<?php echo css_path('style.css', '_theme_'); ?>" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="../assets/img/apple-touch-icon.png">
    <link rel="icon" href="../assets/img/favicon.png">
  </head>

  <body class="min-h-fullscreen bg-img center-vh p-20 authbg_light" data-overlay="7">

  

    <?php echo $template['body']; ?>


    <!-- Scripts -->
    <script src="<?php echo js_path('core.min.js', '_theme_'); ?>"></script>
    <script src="<?php echo js_path('app.min.js', '_theme_'); ?>"></script>
    <script src="<?php echo js_path('script.js', '_theme_'); ?>"></script>

  </body>
</html>
