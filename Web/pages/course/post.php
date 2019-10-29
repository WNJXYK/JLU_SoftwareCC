<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <button type="submit" class="btn btn-default btn-sm float-right" onclick="updateMarkdown();">Refresh</button>
                    <h3 class="card-title" id="markdown-title"></h3>
                </div>

                <div class="card-body" id="markdown-content"></div>

                <div class="card-footer" id="send-comment">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <b>Comments</b>
                            <button type="submit" class="btn btn-default btn-sm float-right" onclick="updateComments();">Refresh</button>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="input-group" >
                                <input type="text" placeholder="Type Message ..." class="form-control" id="comment-msg">
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-danger" onclick="clearComment();">Clear</button>
                                    <button type="submit" class="btn btn-primary" onclick="sendComment();" id="send-button">Send</button>
                                </span>
                            </div>
                        </div>
                        <div class="card-comments col-12" id="comments"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function updateMarkdown(){ course_markdown($("#Markdown_ID").val(), function(text){ $("#markdown-content").html(markdown_render.toHTML(text)); }); }
    function updateComments(new_comment = ""){
        comment_list($("#Markdown_ID").val(), function(comments){
            // Update Comments
            $("#comments").html("");

            for (let i = 0; i < comments.length; ++i){
                msg_code = "<hr/>";
                msg_code += '<div class="direct-chat-msg" id="comment-' + comments[i].id + '">'
                msg_code += "Comment #" + comments[i].id + ":";
                msg_code += '<div class="direct-chat-infos clearfix ml-3">';
                msg_code += '<span class="direct-chat-name float-left" id="comment-username-' + comments[i].id + '">' + comments[i].author + '</span>';
                msg_code += '<span class="direct-chat-timestamp float-right">' + comments[i].last + '</span></div>';
                msg_code += '<div class="ml-3"><img class="direct-chat-img" src="./imgs/Header.png" alt="User Header"><div class="direct-chat-text">';
                if (comments[i].reply != null){
                    if (comments[i].reply == 0){
                        msg_code += '> <a href="#comment-' + comments[i].id + '"> Refered comment has been deleted.</a><br/>';
                    }else msg_code += '> <a href="#comment-' + comments[i].reply + '"> Refer to comment #' + comments[i].reply + '</a><br/>';
                }
                msg_code += comments[i].content;
                msg_code += '<span class="float-right"><a href="#send-comment" onclick="replyComment(' + comments[i].id + ');">Reply</a>';
                if ($.cookie("User_ID") == comments[i].author || $.cookie("User_Type") == "Teacher")
                    msg_code += '  <a href="#" onclick="deleteComment(' + comments[i].id + ');">Delete</a>';
                msg_code += '</span><br/></div></div></div>';
                $("#comments").append($(msg_code));
            }

            // Update User Profile
            for (let i = 0; i < comments.length; ++i){
                user_profile(comments[i].author, function(profile){
                    $("#comment-username-" + comments[i].id).html(profile.nickname);
                });
            }
            
            if (new_comment.length > 0) self.location.href = '#comment-' + new_comment; else{
                if (new_comment != "#") self.location.href = "#send-comment";
            }
        });
    }

    var reply_id = 0;
    function replyComment(id){
        reply_id = id;
        $("#send-button").changeButton(2, false, "Reply #" + id);
    }
    
    function clearComment(){
        reply_id = 0;
        $("#comment-msg").val("");
        $("#send-button").changeButton(1, false, "Send");
    }

    function sendComment(){
        if ($("#comment-msg").val().length < 10){
            alert("Your comment is too short. ( < 10 )");
        }else{
            comment_send($("#Markdown_ID").val(), $("#comment-msg").val(), $.cookie("User_ID"), reply_id, function(new_comment){
                updateComments(new_comment);
                clearComment();
            });
        }
    }

    function deleteComment(id){
        comment_delete(id, function(){ updateComments(); })
    }

    $(function(){
        $("#markdown-title").html($("#Markdown_Title").val());
        updateMarkdown();
        updateComments("#");
    });
</script>