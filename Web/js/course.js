
function course_list(func){
    $.get(
        getRoot() + "/libs/course.php", 
        {},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_module(id, func){
    $.get(
        getRoot() + "/libs/course.php", 
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_update_module(id, content){
    $.post(
        getRoot() + "/libs/course.php", 
        {"id": id, "module": content},
        function(json, status){
            if (json.status == 0){
                toastr.success('Module is applied.');
            }else toastr.error(json.msg);
        }
    );
}

function course_markdown(id, func){
    $.get(
        getRoot() + "/libs/markdown.php",
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_new_markdown(course, func){
    $.post(
        getRoot() + "/libs/markdown.php",
        {"course": course},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_update_markdown(id, content){
    $.post(
        getRoot() + "/libs/markdown.php",
        {"id": id, "content": content},
        function(json, status){
            if (json.status == 0){
                toastr.success('Markdown is saved.');
            }else toastr.error(json.msg);
        }
    );
}

function course_render_problem(problem){
    html_code = "";
    html_code += '<div class="form-group"><label for="Statement">' + problem.Statement + ' [ ';
    html_code += '<input type="text" id="problem-' + problem.ID + '-score" placeholder="?" size="2" disabled></input>'
    html_code += '/' + problem.Score + ' pts ]</label>';
    switch(problem.Type){
        case 0:
            try{
                json = JSON.parse(problem.Content);
                for (let i = 0; i < json.Problem.length; ++i)
                    html_code += '<div class="form-check"><input class="form-check-input" type="radio" name="problem-' + problem.ID + '" id="problem-' + problem.ID + '-' + i + '"><label class="form-check-label">' + json.Problem[i] + '</label></div>';
                
            }catch(err){
                html_code += '<p>Incorrect Multiple-choice Json<br\>Please in style : {"Problem": ["A", "B", "C", "D"], "Answer": 0}</p>'
            }
            break;
        case 1:
            html_code += '<textarea class="form-control" rows="5" placeholder="Enter Your Answer" id="problem-' + problem.ID + '-text"></textarea>';
            break;
        case 2:
            html_code += '<input type="text" class="form-control" id="problem-' + problem.ID + '-text" placeholder="Enter Your File Url">';
            break;
    }
    
    html_code += "</div>";
    return html_code;
}

function course_unlock_quiz_score(quiz){
    for (let i = 0; i < quiz.Problem.length; ++i){
        course_problem(quiz.Problem[i], function(json){
            let problem =  {"ID": 0, "Statement": "Please Choose From A, B, C, D.", "Score": 1,  "Type": 0, "Content": "" };
            problem.ID = json.id;
            problem.Type = parseInt(json.type);
            if (problem.Type != 0) $('#problem-' + problem.ID + '-score').removeAttr("disabled");
        });
    }
}

function course_render_quiz(preview, quiz){
    // preview = $("#quiz-preview");
    preview.html("");
    for (let i = 0; i < quiz.Problem.length; ++i)
        preview.append('<div id="quiz-view-' + i + '"></div>');
    for (let i = 0; i < quiz.Problem.length; ++i){
        course_problem(quiz.Problem[i], function(json){
            let problem =  {"ID": 0, "Statement": "Please Choose From A, B, C, D.", "Score": 1,  "Type": 0, "Content": "" };
            problem.ID = json.id;
            problem.Score = json.score;
            problem.Statement = json.statement;
            problem.Type = parseInt(json.type);
            problem.Content = JSON.parse(json.content);
            $("#quiz-view-"+i).html(course_render_problem(problem));
        });
    }
}

function course_bind_answer(quiz, answer){
    console.log(answer);
    for (let i = 0; i < quiz.Problem.length; ++i){
        let id = quiz.Problem[i];
        if ($('#problem-' + id + '-text').length > 0){
            $('#problem-' + id + '-text').val(answer[id]);
        }else{
            if (answer[id]!=-1) $("#problem-" + id + "-" +  answer[id]).attr("checked", true);
        }
    }
}

function course_bind_score(quiz, score){
    console.log(score);
    for (let i = 0; i < quiz.Problem.length; ++i){
        let id = quiz.Problem[i];
        $('#problem-' + id + '-score').val(score[id]);
    }
}

function course_submit_answer(id, answer, func){
    $.post(
        getRoot() + "/libs/submit.php",
        {"qid": id, "answer": JSON.stringify(answer)},
        function(json, status){
            if (json.status == 0){
                toastr.success("Answer is updated.");
                func();
            }else toastr.error(json.msg);
        }
    );
}

function course_submit_score(uid, qid, score, func){
    $.post(
        getRoot() + "/libs/submit.php",
        {"qid": qid, "uid":uid, "score": JSON.stringify(score)},
        function(json, status){
            if (json.status == 0){
                toastr.success("Score is updated.");
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_render_score(quiz){
    score = {};
    for (let i = 0; i < quiz.Problem.length; ++i){
        let id = quiz.Problem[i];
        score[id] = $('#problem-' + id + '-score').val();
    }
    console.log(score);
    return score;
}

function course_render_answer(quiz){
    answer = {};
    for (let i = 0; i < quiz.Problem.length; ++i){
        let id = quiz.Problem[i];
        if ($('#problem-' + id + '-text').length > 0){
            answer[id] = $('#problem-' + id + '-text').val();
        }else{
            answer[id] = -1;
            for (let j = 0; j < 100; j++){
                if ($("#problem-" + id + "-" + j).length > 0){
                    if ($("#problem-" + id + "-" + j).prop("checked")){
                        answer[id] = j;
                        break;
                    }
                }else break;
            }
        }
    }
    console.log(answer);
    return answer;
}

function course_check_problem(problem){
    if (problem.Type == 0){
        try{
            json = JSON.parse(problem.Content);
        }catch(err){
            return false;
        }
    }
    return true;
}

function course_problem(id, func){
    $.get(
        getRoot() + "/libs/problem.php",
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_new_problem(quiz, func){
    $.post(
        getRoot() + "/libs/problem.php",
        {"quiz": quiz},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_update_problem(problem){
    $.post(
        getRoot() + "/libs/problem.php",
        {
            "id": problem.ID,
            "score": problem.Score,
            "statement": problem.Statement,
            "type": problem.Type,
            "content": JSON.stringify(problem.Content),
            "answer": problem.Answer
        },
        function(json, status){
            if (json.status == 0){
                toastr.success("Problem is updated.");
            }else toastr.error(json.msg);
        }
    );
}

function course_quiz(id, func){
    $.get(
        getRoot() + "/libs/quiz.php",
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_quiz_ex(id, uid, func){
    $.get(
        getRoot() + "/libs/quiz.php",
        {"id": id, "uid": uid},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_quiz_student(qid, func){
    $.post(
        getRoot() + "/libs/quiz_student.php",
        {"qid": qid},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_new_quiz(course, func){
    $.post(
        getRoot() + "/libs/quiz.php",
        {"course": course},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_update_quiz(id, name, content, flag = true){
    $.post(
        getRoot() + "/libs/quiz.php",
        {
            "id": id,
            "name": name,
            "content": JSON.stringify(content)
        },
        function(json, status){
            if (json.status == 0){
                if (flag) toastr.success("Quiz is updated.");
            }else toastr.error(json.msg);
        }
    );
}

function course_grade(id, func){
    $.post(
        getRoot() + "/libs/grades.php", 
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

$(function(){
    if ($("#navbar-course").length > 0) $("#navbar-course").html($.cookie("Course_Name"));
});