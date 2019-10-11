<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>
    <!-- Bootstrap -->
    <link href="./plugins/bootstrap/css/adminlte.min.css" rel="stylesheet">
    <!-- Plugins -->
    <link rel="stylesheet" href="./plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse">
      <div class="wrapper">
        <?  
          $navbar_content = "./pages/dashboard.php";
          $navbar_link = ["Dashboard"=>["navbar-dashboard", "#", true]];
          switch($_SERVER['REQUEST_METHOD']){
            case 'POST': 
              switch($_POST["page"]){
                case 'Course':
                  $navbar_content = "./pages/course.php";
                  $navbar_link = ["CourseName"=>["navbar-course", "#", false]];
              }
              ;
              break;
            default: 
              $navbar_content = "./pages/course.php";
              $navbar_link = ["Dashboard"=>["navbar-dashboard", "#", true]];
          }
        ?>
        <? include("./pages/nav.php"); ?>
        <? include("./pages/sidebar.php"); ?>
        <? include($navbar_content); ?>
        <? include("./pages/footer.php"); ?>
      </div>
    <!-- Plugins -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="./plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- Bootstrap -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./plugins/bootstrap/js/adminlte.min.js"></script>

  </body>
</html>