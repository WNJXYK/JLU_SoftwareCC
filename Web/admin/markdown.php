<?php
    require_once("../libs/_user.php");
    if (!check_user_type("Teacher")){ header("Location: /"); exit; }

    $page_type = "Markdown"; 
    $navbar_link = [
        "Course"=>["navbar-course", "#", true],
		"Modules"=>["navbar-modules", "#", true],
        "Markdown"=>["navbar-markdown-modify", "#", true]
    ];

    $markdown_id = 0;
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["Markdown_Edit_ID"])) $markdown_id = $_GET["Markdown_Edit_ID"]; 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["Markdown_Edit_ID"])) $markdown_id = $_POST["Markdown_Edit_ID"]; 
    if ($markdown_id == 0) { header("Location: /"); exit; }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <?php include("./header.php")?>
    <body class="hold-transition sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <?php include("../pages/nav.php"); ?>
            <?php include("../pages/sidebar.php"); ?>
            <?php //echo "<input type='hidden' value={$markdown_id} id='Markdown_Edit_ID'/>"; ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <button type="submit" class="btn btn-default float-right" onclick="save();">Save</button>
                        <h3>Edit Markdown</h3>
                    </div>
                   
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
							<div class="col-lg-6 col-sm-12">
								<div class="card card-primary">
									<div class="card-header"><h3 class="card-title">Text</h3></div>
									<div class="card-body">
                                        <textarea id="markdown-input" class="form-control" autoHeight="true" oninput="update()"></textarea>
                                    </div>
									<div class="card-footer"></div>
								</div>
							</div>

							<div class="col-lg-6 col-sm-12">
								<div class="card card-success">
									<div class="card-header"><h3 class="card-title">Preview</h3></div>
									<div class="card-body" id="markdown-preview"></div>
                                    <div class="card-footer"></div>
								</div>
							</div>

						</div>
                    </div>
                </section>
            </div>
            <?php include("../pages/footer.php"); ?>
        </div>
        
        <script>
            var markdownID;
            function update(){$("#markdown-preview").html(markdown_render.toHTML($("#markdown-input").val()));}
            function save(){ course_update_markdown($("#Markdown_Edit_ID").val(), $("#markdown-input").val()); }
            $(function(){ 
                course_markdown($("#Markdown_Edit_ID").val(), function(text){ 
                    $("#markdown-input").val(text); 
                    $('textarea[autoHeight]').autoHeight();
                    update();
                }); 
            });
        </script>
    </body>
</html>