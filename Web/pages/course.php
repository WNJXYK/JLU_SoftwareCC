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
            <div class="col-lg-1 col-3">
                <div class="nav flex-column nav-pills h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Home</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-assignments" role="tab" aria-controls="vert-tabs-assignments" aria-selected="false">Assignments</a>
                <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-syllabus" role="tab" aria-controls="vert-tabs-syllabus" aria-selected="false">Syllabus</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-modules" role="tab" aria-controls="vert-tabs-modules" aria-selected="false">Modules</a>
                <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-discussions" role="tab" aria-controls="vert-tabs-discussions" aria-selected="false">Discussions</a>
                <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-zoom" role="tab" aria-controls="vert-tabs-zoom" aria-selected="false">Zoom</a>
                <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-grades" role="tab" aria-controls="vert-tabs-grades" aria-selected="false">Grades</a>
                </div>
            </div>

            <div class="col-lg-11 col-9">
                <div class="tab-content" id="vert-tabs-tabContent">
                    <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                        <? include("./pages/course/home.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-assignments" role="tabpanel" aria-labelledby="vert-tabs-assignments-tab">
                        <? include("./pages/course/assignments.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-syllabus" role="tabpanel" aria-labelledby="vert-tabs-syllabus-tab">
                        <? include("./pages/course/syllabus.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-modules" role="tabpanel" aria-labelledby="vert-tabs-modules-tab">
                        <? include("./pages/course/modules.php"); ?>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-zoom" role="tabpanel" aria-labelledby="vert-tabs-zoom-tab">
                        <h1 class="ml-auto">Not Support Yet</h1>
                    </div>
                    <div class="tab-pane fade" id="vert-tabs-grades" role="tabpanel" aria-labelledby="vert-tabs-grades-tab">
                        <? include("./pages/course/grades.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>