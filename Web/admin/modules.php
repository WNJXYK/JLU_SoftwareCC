<?php
	require_once("../libs/_user.php");
	if (!check_user_type("Teacher")){ header("Location: /"); exit; }

	$page_type = "Modify Module"; 
	$navbar_link = [
		"Course"=>["navbar-course", "#", true],
		"Modules"=>["navbar-modules", "#", true],
		"Modify"=>["navbar-modules-modify", "#", true]
	];

	$course_id = 0;
    if ($_SERVER['REQUEST_METHOD'] == 'GET' and isset($_GET["Course_ID"])) $course_id = $_GET["Course_ID"]; 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["Course_ID"])) $course_id = $_POST["Course_ID"]; 
    if ($course_id == 0) { header("Location: /"); exit; }
?>

<!DOCTYPE html>
<html lang="zh-CN">
	<?php include("./header.php")?>
	<body class="hold-transition sidebar-mini sidebar-collapse">
		<div class="wrapper">
			<?php include("../pages/nav.php"); ?>
			<?php include("../pages/sidebar.php"); ?>
			<?php // echo "<input type='hidden' value={$course_id} id='Course_ID'/>"; ?>
			<div class="content-wrapper">
				<section class="content-header">
					<div class="container-fluid">
						<div class="col-12 btn-group" role="group" aria-label="Add Section">
								<button type="button" class="btn btn-default" onclick="addSection(3);">Add Unit</button>
								<button type="button" class="btn btn-default" onclick="addSection(0);">Add Reading</button>
								<button type="button" class="btn btn-default" onclick="addSection(1);">Add Discussion</button>
								<button type="button" class="btn btn-default" onclick="addSection(2);">Add Quiz</button>
								<button type="button" class="btn btn-danger" onclick="updateCourse();">Apply</button>
						</div>
					</div>
				</section>
				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-sm-12">
								<div class="card card-primary">
									<div class="card-header"><h3 class="card-title">Temporary Pool</h3></div>
									<div class="card-body" id="drag-pool" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
									<div class="card-footer">
										Notice: When you apply the modules, all section in Temporary Pool would be deleted.
									</div>
								</div>
							</div>

							<div class="col-lg-9 col-sm-12">
								<div class="card card-success">
									<div class="card-header"><h3 class="card-title">Modules</h3></div>
									<div class="card-body" id="drag-list" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
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
		// 0 Reading
		// 1 Discussion
		// 2 Quiz
		// 3 Unit
		var name_arr = ["Reading", "Discussion", "Quiz", "Unit"];

		var cur_arr = [], pool_arr = [], list_arr = [], pos_arr = [];

		function json2arr(json){
			let ret = [], content = JSON.parse(json.module).Modules;
			for (let i = 0; i < content.length; ++i){
				ret.push({"Type": 3, "Name": content[i].Name, "ID": 0})
           		for (let j = 0; j < content[i].Unit.length; ++j)
					ret.push({"Type": content[i].Unit[j].Type, "Name": content[i].Unit[j].Name, "ID": content[i].Unit[j].ID})   
            }
			cur_arr = ret;
			list_arr = [];
			for (let i = 0; i < cur_arr.length; ++i) list_arr.push(i), pos_arr.push(0);
        }

		function arr2json(){
			let arr = cur_arr;
			let ret = {"Modules" : []}, cur = {};
			if (list_arr.length == 0) { alert("Nothing.."); return null; }
			for (let _ = 0; _ < list_arr.length; ++_){
				let i = list_arr[_];
				if (_ == 0 && arr[i].Type != 3) { alert("Start with unit, please."); return; }
				if (arr[i].Type != 3) cur.Unit.push({"Name": arr[i].Name, "ID": arr[i].ID, "Type": arr[i].Type});
				if (_ == 0 || arr[i].Type == 3){
					if (_ > 0) ret.Modules.push(cur);
					cur = {"Name": arr[i].Name, "Unit" : []};
				}
			}
			ret.Modules.push(cur);
			// console.log(JSON.stringify(ret));
			return JSON.stringify(ret);
		}

		function updateName(){
			for (let i = 0; i < cur_arr.length; ++i)
				if ($('#drag-item-name-' + i).length > 0) 
					cur_arr[i].Name = $('#drag-item-name-' + i).val();
		}

		function update(node, arr){	
			updateName();
			// Update Info
			node.html("");
			for (let i = 0; i < arr.length; ++i){
				let c = arr[i];
				code = '<div class="input-group mb-3" draggable="true" ondragstart="drag(event)" id="drag-item' + c + '">\
							<div class="input-group-prepend"><span class="input-group-text">' + name_arr[cur_arr[c].Type] + '</span></div>\
							<input type="text" class="form-control" placeholder="Name" id="drag-item-name-' + c + '" value="' + cur_arr[c].Name + '">';
				
				if (cur_arr[c].Type != 3) {
					code += '<span class="input-group-append"><button type="button" class="btn ';
					if (cur_arr[c].ID == 0) code += "btn-primary"; else code += "btn-warning";
					code += '" onclick="modify(' + c + ');">';
					if (cur_arr[c].ID == 0) code += "Init"; else code += "Modify";
					code += '</button></span>';
				}
				code += '</div>';
				node.append($(code));
			}
			// Update Pos
			for (let i = 0; i < arr.length; ++i){
				let c = arr[i];
				pos_arr[c] = $("#drag-item" + c).position().top;
			}
		}

		function addSection(type){
			cur_arr.push({"Type": type, "Name": "Noname", "ID": 0});
			pos_arr.push(0);
			pool_arr.push(cur_arr.length - 1);

			// Update
			update($("#drag-pool"), pool_arr);
			update($("#drag-list"), list_arr);
		}
		
		function print(){
			for (let i = 0; i < cur_arr.length; ++i){
				console.log(cur_arr[i].Name + " " + pos_arr[i]);
			}
		}

		function modify(c){
			if (cur_arr[c].Type == 0 || cur_arr[c].Type == 1){
				if (cur_arr[c].ID == 0){
					course_new_markdown($("#Course_ID").val(), function(id){
						cur_arr[c].ID = id;
						update($("#drag-pool"), pool_arr);
						update($("#drag-list"), list_arr); 
						updateCourse();
						newdirect(getRoot() + "/admin/markdown.php", {"Markdown_Edit_ID": cur_arr[c].ID});
					});
				}else{
					update($("#drag-pool"), pool_arr);
					update($("#drag-list"), list_arr); 
					newdirect(getRoot() + "/admin/markdown.php", {"Markdown_Edit_ID": cur_arr[c].ID});
				}
			}
			if (cur_arr[c].Type == 2){
				if (cur_arr[c].ID == 0){
					course_new_quiz($("#Course_ID").val(), function(id){
						cur_arr[c].ID = id;
						update($("#drag-pool"), pool_arr);
						update($("#drag-list"), list_arr); 
						updateCourse();
						newdirect(getRoot() + "/admin/quiz.php", {"Quiz_Edit_ID": cur_arr[c].ID});
					});
				}else{
					update($("#drag-pool"), pool_arr);
					update($("#drag-list"), list_arr);
					newdirect(getRoot() + "/admin/quiz.php", {"Quiz_Edit_ID": cur_arr[c].ID});
				}
			}
		}

		function updateCourse(){
			updateName();
			let content = arr2json();
			if (content == null) return;
			let id = $("#Course_ID").val();
			course_update_module(id, content);
		}

		function init(json){
			json2arr(json);
			update($("#drag-pool"), pool_arr);
			update($("#drag-list"), list_arr);
		}

		$(function(){
			course_module($("#Course_ID").val(), init);
		});
	</script>

	<script type="text/javascript">
		function allowDrop(ev) { ev.preventDefault(); }

		function drag(ev) { ev.dataTransfer.setData("Text", ev.target.id); }

		function moveNode(arr, id, ot){
			id = id.slice(9);
			// Del
			for (let i = 0; i < pool_arr.length; ++i)
				if (pool_arr[i] == id){ pool_arr.splice(i, 1); break; }
			for (let i = 0; i < list_arr.length; ++i)
				if (list_arr[i] == id){ list_arr.splice(i, 1); break; }

			// Add
			let pos = 0;
			for (let i = 0; i < arr.length; ++i)
				if (ot > pos_arr[arr[i]]) pos = i + 1;
			arr.splice(pos, 0, id);
			
			// Update
			update($("#drag-pool"), pool_arr);
			update($("#drag-list"), list_arr);
		}

		function drop(ev) {
			ev.preventDefault();
			var data = ev.dataTransfer.getData("Text");
			if (ev.target.id == "drag-pool") moveNode(pool_arr, data, ev.offsetY);
			if (ev.target.id == "drag-list") moveNode(list_arr, data, ev.offsetY);
		}
	</script>
</html>