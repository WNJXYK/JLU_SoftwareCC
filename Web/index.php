<?
  $page_type = "Dashboard"; 
  $page_content = "./pages/dashboard.php"; // 页面内容
  $navbar_link = ["Dashboard"=>["navbar-dashboard", "Dashboard", true]]; // 导航栏地址

  if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["page"])) $page_type = $_GET["page"]; // 获得页面种类 Just For Test
  if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["page"])) $page_type = $_POST["page"]; // 获得页面种类

  // Index 框架内部页面导航
  switch($page_type){
    case "Dashboard": break;
    case "Home":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Home"=>["navbar-home", "#", true]
      ];
      break;
    case "Syllabus":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Syllabus"=>["navbar-syllabus", "#", true]
      ];
      break;
    case "Assignments":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Assignments"=>["navbar-assignments", "#", true]
      ];
      break;
    case "Modules":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Modules"=>["navbar-modules", "#", true]
      ];
      break;
    case "Discussions":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Discussions"=>["navbar-discussions", "#", true]
      ];
      break;
    case "Grades":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Grades"=>["navbar-grades", "#", true]
      ];
      break;
    case "Calendar":
      $page_content = "./pages/canlendar.php";
      $navbar_link = [
        "Course"=>["navbar-calendar", "Calendar", true]
      ];
      break;
    case "Inbox":
      $page_content = "./pages/inbox.php";
      $navbar_link = [
        "Course"=>["navbar-inbox", "Inbox", true]
      ];
      break;
    default: die("Wrong Parameters."); break;
  }

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><? echo $page_type; ?></title>

    <!-- JS -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="./plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="./plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="./plugins/bootstrap/js/theme.min.js"></script>
    <script src="./js/nav.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="./plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <link href="./plugins/bootstrap/css/theme.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition sidebar-mini sidebar-collapse">
      <div class="wrapper">
        <? include("./pages/nav.php"); ?>
        <? include("./pages/sidebar.php"); ?>
        <? include($page_content); ?>
        <? include("./pages/footer.php"); ?>
      </div>
  </body>
</html>