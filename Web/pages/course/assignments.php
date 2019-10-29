
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Assignments</h1>
    </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <?php if (check_user_type("Teacher")){ ?>
                    <button type="submit" class="btn btn-default btn-sm float-left" onclick="add();">New Assignment</button>
                    <button type="submit" class="btn btn-default btn-sm float-right" onclick="edit();">Edit Assignment</button>
                    <?php } ?>
                </div>
                <div class="card-body" id="assignment-content"></div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function update_assignment(json){
        if (json.assignment == 0){
            $("#assignment-content").html("There is no assignment.");
        }else{
            $("#assignment-content").html("Current Assignment is #" + json.assignment + '<hr/>');
            $("#assignment-content").append($('<button type="submit" class="btn btn-default " onclick="assign();">Go To Assignment</button>'));
        }
    }

    function assign(){
        course_module($("#Course_ID").val(), function(json){
            redirect(getRoot() + "/", {"page":"Assign", "Quiz_ID": json.assignment});
        });
    }

    function add(){
        course_module($("#Course_ID").val(), function(json){
            course_new_quiz($("#Course_ID").val(), function(id){
                json.assignment = id;
                newdirect(getRoot() + "/admin/quiz.php", {"Quiz_Edit_ID": json.assignment});
                $.post(
                    getRoot() + "/libs/course.php", 
                    {"id": $("#Course_ID").val(), "assignment": json.assignment},
                    function(json, status){
                        course_module($("#Course_ID").val(), update_assignment);
                    }
                );
            });
        });
        
    }
    function edit(){ 
        course_module($("#Course_ID").val(), function(json){
            newdirect(getRoot() + "/admin/quiz.php", {"Quiz_Edit_ID": json.assignment});
        });
     }

    $(function(){
        $("#home-content").html(markdown_render.toHTML("**Loading~**"));
        course_module($("#Course_ID").val(), update_assignment);
    });
</script>