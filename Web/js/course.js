function course_list(func){
    $.get(
        "/libs/course.php", 
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
        "/libs/course.php", 
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
        "/libs/course.php", 
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
        "/libs/markdown.php",
        {"id": id},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_new_markdown(func){
    $.post(
        "/libs/markdown.php",
        {},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function course_update_markdown(id, content){
    $.post(
        "/libs/markdown.php",
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
    html_code += '<div class="form-group"><label for="Statement">' + problem.Statement + ' [ ' + problem.Score + ' pts ]</label>';
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
            html_code += '<div class="input-group">\
            <div class="custom-file">\
              <input type="file" class="custom-file-input" id="problem-' + problem.ID + '-file">\
              <label class="custom-file-label" for="File">Choose file</label>\
            </div>\
            <div class="input-group-append">\
              <button class="input-group-text btn-default" id="problem-' + problem.ID + '-upload">Upload</button>\
            </div>\
          </div>';
            break;
    }
    html_code += "</div>";
    return html_code;
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

$(function(){
    if ($("#navbar-course").length > 0) $("#navbar-course").html($.cookie("Course_Name"));
});