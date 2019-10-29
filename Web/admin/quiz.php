<?php
	require_once("../libs/_user.php");
	if (!check_user_type("Teacher")){ header("Location: /"); exit; }

	$page_type = "Modify Quiz"; 
	$navbar_link = [
		"Course"=>["navbar-course", "#", true],
		"Modules"=>["navbar-modules", "#", true],
		"Quiz"=>["navbar-quiz-modify", "#", true]
	];

	$quiz_id = 0;
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["Quiz_Edit_ID"])) $quiz_id = $_GET["Quiz_Edit_ID"]; 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["Quiz_Edit_ID"])) $quiz_id = $_POST["Quiz_Edit_ID"]; 
    if ($quiz_id == 0) { header("Location: /"); exit; }
?>

<!DOCTYPE html>
<html lang="zh-CN">
	<?php include("../pages/header.php")?>
	<body class="hold-transition sidebar-mini sidebar-collapse">
		<div class="wrapper">
			<?php include("../pages/nav.php"); ?>
			<?php include("../pages/sidebar.php"); ?>
			<?php //echo "<input type='hidden' value={$course_id} id='Course_ID'/>"; ?>
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="col-12 btn-group" role="group" aria-label="Add Section">
								<button type="button" class="btn btn-default" onclick="addProblem();">Add Problem</button>
								<button type="button" class="btn btn-default" onclick="save();">Apply</button>
						</div>
					</div>
				</section>
				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-sm-12">
								<div class="card card-primary">
									<div class="card-header"><h3 class="card-title">Question Pool</h3></div>
									<div class="card-body" id="drag-list" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <label for="Name">Name</label>
                                            <input type="text" class="form-control" id="quiz-name" placeholder="Enter Task Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="Time">Time</label>
                                            <input type="number" class="form-control" id="quiz-time" placeholder="Enter Task Duration (0 = Inf and in 1 day)" oninput="update()">
                                        </div>
                                    </div>
								</div>
							</div>

							<div class="col-lg-9 col-sm-12">
								<div class="card card-success">
									<div class="card-header"><button type="submit" class="btn btn-default btn-sm float-right" onclick="updateUI();">Refresh</button><h3 class="card-title">Quiz Preview</h3></div>
									<div class="card-body" id="quiz-preview"></div>
                                    <div class="card-footer"></div>
								</div>
							</div>

						</div>
					</div>
				</section>
			</div>
			<?php include("../pages/footer.php"); ?>
		</div>
	</body>

	
	<script type="text/javascript">
        var quiz = {"Problem": [1, 2, 3], "Score": 0, "Time": 20};
        var pos = [];

		function updateUI(){
            // Update Html
            par = $("#drag-list");
			par.html("");
			for (let i = 0; i < quiz.Problem.length; ++i){
				let p = quiz.Problem[i];
                code = '<div class="input-group mb-3" draggable="true" ondragstart="drag(event)" id="drag-item' + p + '">';
                code += '<p class="form-control">Problem ' + p +'</p>';
                code += '<span class="input-group-append">';
                code += '<button type="button" class="btn btn-info" onclick="modifyP(' + p + ');">Modify</button>';
                code += '<button type="button" class="btn btn-danger" onclick="deleteP(' + i + ');">Delete</button>';
				code += '</span></div>';
				par.append($(code));
			}
			
			course_render_quiz($("#quiz-preview"), quiz);
            // Update Pos
            pos = [];
			for (let i = 0; i < quiz.Problem.length; ++i)
                pos.push($("#drag-item" + quiz.Problem[i]).position().top);
            
            // Update Time
            $("#quiz-time").val(quiz.Time);
		}

		function addProblem(){
			course_new_problem($("#Quiz_Edit_ID").val(), function(data){
				quiz.Problem.push(data);
				updateUI();
				save(false);
			});
		}
		

		function update(){
			if ($("#quiz-time").val() < 0 || $("#quiz-time").val() > 24 * 60){
				alert("Quiz Time should in [0, 1440]");
			}else{
				quiz.Time = $("#quiz-time").val();
			}
		}

		function deleteP(c){ quiz.Problem.splice(c, 1); updateUI(); save(false);}
		function modifyP(c){ newdirect(getRoot() + "/admin/problem.php", {"Problem_Edit_ID": c}); }
		function save(flag = true){ course_update_quiz($("#Quiz_Edit_ID").val(), $("#quiz-name").val(), quiz, flag); }

		$(function(){
            course_quiz($("#Quiz_Edit_ID").val(), function(json){
				$("#quiz-name").val(json.name);
				// console.log(json.content);
				quiz = JSON.parse(json.content);
				updateUI();
			});
		});
	</script>

	<script type="text/javascript">
		function allowDrop(ev) { ev.preventDefault(); }

		function drag(ev) { ev.dataTransfer.setData("Text", ev.target.id); }

		function moveNode(id, ot){
			id = id.slice(9);
			for (let i = 0; i < quiz.Problem.length; ++i) if (quiz.Problem[i] == id){  quiz.Problem.splice(i, 1); break; }
			let ins = 0;
			for (let i = 0; i < quiz.Problem.length; ++i) if (ot > pos[i]) ins = i + 1;
            quiz.Problem.splice(ins, 0, id);
			updateUI();
		}

		function drop(ev) {
			ev.preventDefault();
			let data = ev.dataTransfer.getData("Text");
            if (ev.target.id == "drag-list") moveNode(data, ev.offsetY);
		}
	</script>
</html>