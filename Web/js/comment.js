function comment_list(post, func){
    $.get(
        getRoot() + "/libs/comment.php", 
        {"post": post},
        function(json, status){
            if (json.status == 0){
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}

function comment_send(post, content, author, reply, func){
    let data = {
        "post": post,
        "content": content,
        "author": author
    };
    if (reply > 0) data["reply"] = reply;

    $.post(
        getRoot() + "/libs/comment.php", data,
        function(json, status){
            if (json.status == 0){
                toastr.success("Comment is sent.");
                func(json.data);
            }else toastr.error(json.msg);
        }
    );
}


function comment_delete(id, func){
    $.post(
        getRoot() + "/libs/comment.php", 
        {"id": id},
        function(json, status){
            if (json.status == 0){
                toastr.success("Comment is deleted.");
                func();
            }else toastr.error(json.msg);
        }
    );
}
