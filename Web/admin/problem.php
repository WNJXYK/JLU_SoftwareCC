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
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["Problem_Edit_ID"])) $problem_id = $_GET["Problem_Edit_ID"]; 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["Problem_Edit_ID"])) $problem_id = $_POST["Problem_Edit_ID"]; 
    if ($problem_id == 0) { header("Location: /"); exit; }
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

                                            <div class="form-group">
                                                <label for="Answer">Answer (Multiple-choice Problem Only)</label>
                                                <input type="number" class="form-control" id="problem-answer" placeholder="Enter 0, 1, 2, ..." oninput="update(4)">
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
            var problem = {"ID": 0, "Statement": "Please Choose From A, B, C, D.", "Score": 1,  "Type": 0, "Content": "", "Answer": 0};

            function updateUI(){
                $("#problem-statement").val(problem.Statement);
                $("#problem-score").val(problem.Score);
                $("#problem-type").val(problem.Type);
                if (problem.Type != 0){
                    $("#problem-content").attr("disabled", true);
                    $("#problem-answer").attr("disabled", true);
                    $("#problem-content").val("");
                }else{
                    $("#problem-content").removeAttr("disabled");
                    $("#problem-answer").removeAttr("disabled");
                    $("#problem-content").val(problem.Content);
                    $("#problem-answer").val(problem.Answer);
                }
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
                    case 4:
                        problem.Answer = $("#problem-answer").val();
                        break;
                }
                updateUI();
            }
            
            function save(){
                if (!course_check_problem(problem)){
                    alert("Problem's Format is Incorrect.")
                }else{
                    course_update_problem(problem);
                }
            }

            $(function(){
                course_problem($("#Problem_Edit_ID").val(), function(json){
                    problem.ID = json.id;
                    problem.Score = json.score;
                    problem.Statement = json.statement;
                    problem.Type = parseInt(json.type);
                    problem.Content = JSON.parse(json.content);
                    updateUI();
                });
            })
        </script>
    </body>
</html>