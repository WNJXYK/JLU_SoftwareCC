<?php
    require_once("../libs/_user.php");
    if (!check_user_type("Admin")){ header("Location: " . URL_PATH. "/"); exit; }

    $page_type = "Admin"; 
    $navbar_link = [
        "Admin"=>["navbar-admin", "#", true]
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
                        <div class="row">
                            <div class="col-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <button type="submit" class="btn btn-default btn-sm float-right" onclick="importUser();">Import</button>
                                        <h3 class="card-title">Import User</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <textarea rows="20" class="form-control" id="import-content" oninput="previewUser()"></textarea>
                                            </div>
                                            <div class="col-6">
                                                <textarea rows="20" class="form-control" id="import-preview"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Edit Course</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="Name">Course Name</label>
                                            <input type="text" class="form-control" id="course-name" placeholder="Course Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="Info">Course Info Json</label>
                                            <input type="text" class="form-control" id="course-info" placeholder='Course Info -> {"Start":[],"Repeat": 1, "Extra": "Teacher: XXX" }' value='{"Start":[],"Repeat": 1, "Extra": "Teacher: XXX" }'>
                                        </div>
                                        <button type="submit" class="btn btn-default float-right" onclick="addCourse();">New Course</button>
                                    </div>
                                    <div class="card-footer p-0 table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr><th>ID</th><th>Name</th><th>Info</th><th>Ctrl</th></tr>
                                            </thead>
                                            <tbody id="course-content">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include("../pages/footer.php"); ?>
        </div>
        <script type="text/javascript">
            function update_course(list){
                let cont = $("#course-content"); cont.html("");
                for (let i = 0; i < list.length; ++i){
                    cont.append($("<tr><td>" + list[i].id + "</td><td>" + list[i].name + "</td><td>" + list[i].info + "</td><td><a href='#' onclick='deleteCourse(" + list[i].id + ")'>Delete</a></td></tr>"));
                }
            }

            function deleteCourse(x){
                $.post(
                    "../libs/admin.php",
                    {"id": x},
                    function(json){
                        toastr.success("Deleted.");
                        course_list(update_course);
                    }
                )
            }

            function addCourse(){
                $.post(
                    "../libs/admin.php",
                    {
                        "name": $("#course-name").val(),
                        "info": $("#course-info").val()
                    },
                    function(json){
                        toastr.success("Added.");
                        course_list(update_course);
                        $("#course-info").val('{"Start":[],"Repeat": 1, "Extra": "Teacher: XXX" }');
                    }
                )
            }

            function previewUser(){
                let textarea = $("#import-content").val();
                let arr = textarea.split(/[(\r\n)\r\n ]+/);
                let text = "";
                for (let i = 0; i < arr.length; i = i + 4){
                    if (i+3 >= arr.length) break;
                    text += "id:"+arr[i]+" nickname:"+arr[i+1]+" type:"+arr[i+2]+" password:"+arr[i+3]+"\n";
                }
                $("#import-preview").val(text);
            }

            function importUser(){
                let textarea = $("#import-content").val();
                let arr = textarea.split(/[(\r\n)\r\n ]+/);
                for (let i = 0; i < arr.length; i = i + 4){
                    if (i+3 >= arr.length) break;
                    let peo = {"id": arr[i], "nickname": arr[i+1], "type": arr[i+2], "password": arr[i+3]};
                    $.post("../libs/import.php", peo, function(json){
                        if (json.status == 0){
                            toastr.success(peo.id + " Imported");
                        }else toastr.error(peo.id + " Failed");
                    });
                }
            }

            $(function(){
                course_list(update_course);
            });
        </script>
    </body>
</html>