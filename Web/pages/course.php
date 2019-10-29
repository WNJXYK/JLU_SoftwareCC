<?php
    require_once("./libs/_user.php");
    $course_content = "./pages/course/home.php";
    $course_navstate = [false, false, false, false, false, false];

    // Course 内部页面导航
    switch($page_type){
        case "Home":
            $course_content = "./pages/course/home.php";
            $course_navstate[0] = true;
            break;
        case "Assignments":
            $course_content = "./pages/course/assignments.php";
            $course_navstate[1] = true;
            break;
        case "Syllabus":
            $course_content = "./pages/course/syllabus.php";
            $course_navstate[2] = true;
            break;
        case "Modules":
            $course_content = "./pages/course/modules.php";
            $course_navstate[3] = true;
            break;
        case "Discussions":
            $course_content = "./pages/course/discussions.php";
            $course_navstate[4] = true;
            break;
        case "Grades":
            $course_content = "./pages/course/grades.php";
            $course_navstate[5] = true;
            break;
        case "Markdown":
            $course_content = "./pages/course/markdown.php";
            $course_navstate[3] = true;
            break;
        case "Post":
            $course_content = "./pages/course/post.php";
            $course_navstate[4] = true;
            break;
        case "Quiz":
            $course_content = "./pages/course/quiz.php";
            $course_navstate[3] = true;
            break;
        case "Assign":
            $course_content = "./pages/course/quiz.php";
            $course_navstate[1] = true;
            break;
        default: die("Wrong Parameters."); break;
      }
?>
<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
    </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-1 col-sm-12">
                    <div class="nav flex-column nav-pills h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link <?php if ($course_navstate[0]){?>active<?php } ?>" id="vert-tabs-home-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Home</a>
                        <a class="nav-link <?php if ($course_navstate[1]){?>active<?php } ?>" id="vert-tabs-assignments-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-assignments" aria-selected="false">Assignments</a>
                        <a class="nav-link <?php if ($course_navstate[2]){?>active<?php } ?>" id="vert-tabs-syllabus-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-syllabus" aria-selected="false">Syllabus</a>
                        <a class="nav-link <?php if ($course_navstate[3]){?>active<?php } ?>" id="vert-tabs-modules-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-modules" aria-selected="false">Modules</a>
                        <a class="nav-link <?php if ($course_navstate[4]){?>active<?php } ?>" id="vert-tabs-discussions-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-discussions" aria-selected="false">Discussions</a>
                        <a class="nav-link <?php if ($course_navstate[5]){?>active<?php } ?>" id="vert-tabs-gardes-tab" data-toggle="pill" href="#" role="tab" aria-controls="vert-tabs-grades" aria-selected="false">Grades</a>
                    </div>
                </div>

                <div class="col-lg-11 col-sm-12">
                    <?php include($course_content); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $("#vert-tabs-home-tab").click(function(){ redirect(getRoot() + '/', {"page": "Home" }); });
    $("#vert-tabs-assignments-tab").click(function(){ redirect(getRoot() + '/', {"page": "Assignments" }); });
    $("#vert-tabs-syllabus-tab").click(function(){ redirect(getRoot() + '/', {"page": "Syllabus" }); });
    $("#vert-tabs-modules-tab").click(function(){ redirect(getRoot() + '/', {"page": "Modules" }); });
    $("#vert-tabs-discussions-tab").click(function(){ redirect(getRoot() + '/', {"page": "Discussions" }); });
    $("#vert-tabs-gardes-tab").click(function(){ redirect(getRoot() + '/', {"page": "Grades" }); });
</script>