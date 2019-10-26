<?php
  $page_type = "Modify Module"; 
  $navbar_link = [
    "Course"=>["navbar-course", "Home", false],
    "Modules"=>["navbar-modules", "Modules", false],
    "Modify"=>["navbar-modules-modify", "#", true]
  ];
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <?php include("../pages/header.php")?>
  <body class="hold-transition sidebar-mini sidebar-collapse">
      <div class="wrapper">
        <?php include("../pages/nav.php"); ?>
        <?php include("../pages/sidebar.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
            
                </div>
            </section>
        </div>
        <?php include("../pages/footer.php"); ?>
      </div>
  </body>
</html>