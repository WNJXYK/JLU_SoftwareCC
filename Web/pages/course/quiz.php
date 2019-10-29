<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <span  class="float-right" id="quiz-state">Refresh</span>
                    <h3 class="card-title" id="quiz-title"></h3>
                </div>
                <div class="card-body" id="quiz-content"></div>
                <div class="card-footer">
                    <div class="input-group">
                        <button type="submit" class="btn btn-primary" onclick="submit()" id="submit">Submit</button>
                    <?php if (check_user_type("Teacher")) {?> 
                        <select class="form-control" id="student-id"></select>
                        <button type="submit" class="btn btn-primary" onclick="reveal()" >Reveal</button>
                    <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    var quiz, extra, uid = 0;

    function submit(){
        if (extra.state == 0) {
            course_submit_answer($("#Quiz_ID").val(), course_render_answer(quiz), function(){
                update();
            });
        }
        if (extra.state == -2 || extra.state == -3) {
            course_submit_score(uid, $("#Quiz_ID").val() ,course_render_score(quiz), function(data){
                console.log(data);
                reveal();
            });
        }
        if (extra.state > 0){
            course_bind_answer(quiz, extra.answer)
            course_bind_score(quiz, extra.score);
        }
    }

    function update_button(){
        if (extra.state == 0) $("#submit").changeButton(1, false, "Submit");
        if (extra.state == -1) $("#submit").changeButton(0, true, "Wait");
        if (extra.state == -2) $("#submit").changeButton(2, false, "Judge");
        if (extra.state == -3) $("#submit").changeButton(3, false, "Rejudge");
        if (extra.state > 0) $("#submit").changeButton(1, false, "View");
        if (extra.state < 0){
            course_quiz_student($("#Quiz_ID").val(), function(data){
                console.log(data);
                $("#student-id").html("");
                for (let i = 0; i < data.length; ++i){
                    $("#student-id").append($('<option>' + data[i] + '</option>'));
                }
            });
        }
    }

    function reveal(){
        course_unlock_quiz_score(quiz);
        uid = $("#student-id").val();
        course_quiz_ex($("#Quiz_ID").val(), $("#student-id").val(), function(json){
            console.log(json);
            $("#quiz-title").html(json.name);
            $("#quiz-state").html(json.extra.msg);
            quiz = JSON.parse(json.content);
            extra = json.extra; 
            try{
                extra.state = parseInt(extra.state);
                extra.answer = JSON.parse(extra.answer);
                extra.score = JSON.parse(extra.score);
            }catch(err){};
            update_button();
            course_bind_answer(quiz, extra.answer)
            course_bind_score(quiz, extra.score);
        });
    }

    function update(){
        course_quiz($("#Quiz_ID").val(), function(json){
            console.log(json);
            $("#quiz-title").html(json.name);
            $("#quiz-state").html(json.extra.msg);
            quiz = JSON.parse(json.content);
            extra = json.extra; 
            try{
                extra.state = parseInt(extra.state);
                extra.answer = JSON.parse(extra.answer);
                extra.score = JSON.parse(extra.score);
            }catch(err){};
            update_button();
            course_render_quiz($("#quiz-content"), quiz);
        });
    }
    $(function(){
        update();
    });
</script>