<?php
    require_once("../libs/_user.php");
    if (!check_user_type("Teacher")){ header("Location: /"); exit; }

    $page_type = "Problem"; 
    $navbar_link = [
        "Course"=>["navbar-course", "#", true],
		"Modules"=>["navbar-modules", "#", true],
        "Problem"=>["navbar-problem-modify", "#", true]
    ];

    $problem_id = 0;
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["id"])) $problem_id = $_GET["id"]; 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["id"])) $problem_id = $_POST["id"]; 
    // if ($problem_id == 0) { header("Location: /"); exit; }
?>
<!DOCTYPE html>
<html lang="zh-CN">
    <?php include("../pages/header.php")?>
    <body class="hold-transition sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <?php include("../pages/nav.php"); ?>
            <?php include("../pages/sidebar.php"); ?>
            <?php echo "<input type='hidden' value={$problem_id} id='Problem_ID'/>"; ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <button type="submit" class="btn btn-default float-right" onclick="save();">Save</button>
                        <h3>Edit Problem</h3>
                    </div>
                </section>
                
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
							<div class="col-lg-6 col-sm-12">
                                <div class="card card-primary">
                                    <div class="card-header"><h3 class="card-title">Settings</h3></div>
                                    <div class="card-body">
                                        
                                            <div class="form-group">
                                                <label for="Statement">Statement</label>
                                                <input type="email" class="form-control" id="problem-statement" placeholder="Enter Statement" oninput="update(0)">
                                            </div>

                                            <div class="form-group">
                                                <label for="Max Score">Full Score</label>
                                                <input type="number" class="form-control" id="problem-score" placeholder="Enter Full Score" oninput="update(1)">
                                            </div>

                                            <div class="form-group">
                                                <label for="Type">Type</label>
                                                <select class="custom-select" id="problem-type" oninput="update(2)">
                                                    <option value=0>Choice</option>
                                                    <option value=1>Text</option>
                                                    <option value=2>File</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="Content">Content</label>
                                                <textarea class="form-control" rows="9" placeholder="Enter Problem Content(Multiple-choice Problem Only)" id="problem-content" oninput="update(3)"></textarea>
                                            </div>
                                            
                                    </div>
                                    <div class="card-footer"></div>
								</div>
							</div>

							<div class="col-lg-6 col-sm-12">
								<div class="card card-success">
									<div class="card-header"><h3 class="card-title">Preview</h3></div>
									<div class="card-body" id="problem-preview">
                                    </div>
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
            // var markdownID;
            // function update(){$("#markdown-preview").html(markdown_render.toHTML($("#markdown-input").val()));}
            // function save(){ course_update_markdown($("#Markdown_Edit_ID").val(), $("#markdown-input").val()); }
            // $(function(){ 
            //     course_markdown($("#Markdown_Edit_ID").val(), function(text){ 
            //         $("#markdown-input").val(text); 
            //         $('textarea[autoHeight]').autoHeight();
            //         update();
            //     }); 
            // });
let MC_Pattern = '{\n\
    "Problem": [\n\
        "A",\n\
        "B",\n\
        "C",\n\
        "D"\n\
    ],\n\
    "Answer": 0\n\
}\n';
            var problem = {"ID": 0, "Statement": "Please Choose From A, B, C, D.", "Score": 1, "Type": 0, "Content": MC_Pattern};

            function updateUI(){
                $("#problem-statement").val(problem.Statement);
                $("#problem-score").val(problem.Score);
                $("#problem-type").val(problem.Type);
                if (problem.Type != 0){
                    $("#problem-content").attr("disabled", true);
                    // problem.Content = MC_Pattern;
                    $("#problem-content").val("");
                }else{
                    $("#problem-content").removeAttr("disabled");
                    $("#problem-content").val(problem.Content);
                }
                
            }

            function updatePreview(){
                console.log(problem);
                console.log(course_render_problem(problem));
                $("#problem-preview").html(course_render_problem(problem));
            }

            function update(idx){
                switch(idx){
                    case 0:
                        problem.Statement = $("#problem-statement").val();
                        break;
                    case 1:
                        score = $("#problem-score").val();
                        if (!(1 <= score && score <= 100)){
                            alert("Full Score Must in Range [1, 100].");
                        }else problem.Score = score;
                        break;
                    case 2:
                        problem.Type = parseInt($("#problem-type").val());
                        break;
                    case 3:
                        problem.Content = $("#problem-content").val();
                        break;
                }
                updateUI();
                updatePreview();
            }
            
            function save(){
                if (!course_check_problem(problem)){
                    alert("Problem's Format is Incorrect.")
                }else{

                }
            }

            $(function(){
                updateUI();
                updatePreview();
            })
        </script>
    </body>
</html>