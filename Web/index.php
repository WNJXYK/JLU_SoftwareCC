<?php
  // Check User Validation
  require_once("./libs/_user.php");
  if (!check_user_token()){ header("Location: ./login.php"); exit; }

  // Built-in Navigation
  $page_type = "Dashboard"; 
  $page_content = "./pages/dashboard.php"; // 页面内容
  $navbar_link = ["Dashboard"=>["navbar-dashboard", "Dashboard", true]]; // 导航栏地址
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
    case "Markdown":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Modules"=>["navbar-modules", "Modules", false],
        "Markdown"=>["navbar-markdown", "#", true]
      ];
      break;
    case "Quiz":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Modules"=>["navbar-modules", "Modules", false],
        "Quiz"=>["navbar-quiz", "#", true]
      ];
      break;
    case "Assign":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Assignments"=>["navbar-assignments", "Assignments", false],
        "Quiz"=>["navbar-quiz", "#", true]
      ];
      break;
    case "Post":
      $page_content = "./pages/course.php";
      $navbar_link = [
        "Course"=>["navbar-course", "Home", false],
        "Discussions"=>["navbar-discussions", "Discussions", false],
        "Markdown"=>["navbar-post", "#", true]
      ];
      break;
    case "File":
      $page_content = "./pages/file.php";
      $navbar_link = [
        "File"=>["navbar-file", "#", true]
      ];
      break;
    default: die("Wrong Parameters."); break;
  }

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <?php include("./pages/header.php")?>
  <body class="hold-transition sidebar-mini sidebar-collapse">
      <div class="wrapper">
        <?php include("./pages/nav.php"); ?>
        <?php include("./pages/sidebar.php"); ?>
        <?php include($page_content); ?>
        <?php include("./pages/footer.php"); ?>
      </div>
  </body>
</html>