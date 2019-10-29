<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Inbox</h1>
    </div>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                <h3 class="card-title">Inbox</h3>
               
                </div>
                <div class="card-body p-0">
                <div class="mailbox-controls">
                    <button type="button" class="btn btn-default btn-sm" onclick="newmail()" ><i class="fas fa-file"></i></button>
                    <button type="button" class="btn btn-default btn-sm" onclick="update()"><i class="fas fa-sync-alt"></i></button>
                </div>
                <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                    <thead>
                            <tr><th>Title</th><th>From</th><th>To</th><th>Time</th></tr>
                        </thead>
                    <tbody id="mail-pool">
                    
                    </tbody>
                    </table>
                </div>
                </div>
            </div>
            </div>

        <div class="col-12 col-lg-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <span class="mailbox-read-time float-right" id="mail-time"></span></h6>
                    <h3 class="card-title">Mail Content</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                    <div class="mailbox-read-info" id="mail-info">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Title</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Title" id="mail-title">
                        </div>
                        <hr/>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">From</span>
                            </div>
                            <input type="text" class="form-control" placeholder="From" id="mail-from">
                            <div class="input-group-prepend">
                                <span class="input-group-text">To</span>
                            </div>
                            <input type="text" class="form-control" placeholder="To" id="mail-to">
                        </div>
                    </div>
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message" >
                        <textarea class="form-control" id="mail-content" rows="20"></textarea>
                    </div>
                    <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.card-footer -->
                    <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-default" id="mail-button" onclick="buttonmail()">Reply</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function update(){
        $.get(
            "./libs/mail.php",
            {},
            function(json){
                let list = json.data;
                let node = $("#mail-pool");
                node.html("");
                for (let i = 0; i < list.length; ++i){
                    let row = $("<tr></tr>");
                    row.append($("<td><a href='#' onclick='readmail(" + list[i].id + ")'>" + list[i].title + "</td>"));
                    row.append($("<td>" + list[i].from_user + "</td>"));
                    row.append($("<td>" + list[i].to_user + "</td>"));
                    row.append($("<td>" + list[i].time + "</td>"));
                    node.append(row);
                }
            }
        );
    }

    var reply_id = "", flag = true;
    function readmail(x){
        $.get(
            "./libs/mail.php",
            {"id": x},
            function(json){
                json = json.data;
                $("#mail-content").val(json.content);  
                $("#mail-title").val(json.title);
                $("#mail-from").val(json.from_user);
                $("#mail-to").val(json.to_user);
                $("#mail-time").val(json.time);
                reply_id = json.from_user;
               
            }
        );
        flag = false;
        $("#mail-from").removeAttr("disabled");
        $("#mail-button").changeButton(0, false, '<i class="fas fa-reply"></i> Reply');
    }

    function buttonmail(){
        if (flag == false){
            newmail();
            $("#mail-to").val(reply_id);  
        }else{
            $.post(
            "./libs/mail.php",
            {
                "from": $("#mail-from").val(),
                "to": $("#mail-to").val(),
                "title": $("#mail-title").val(),
                "content": $("#mail-content").val()
            },
            function(json){
                // console.log(json);
                update();
                if (json.data > 0){
                    toastr.success("Mail is sent.");
                }else{
                    toastr.error("Mail is invalid.");
                }
                
            }
        );
        }
    }

    function newmail(){
        $("#mail-content").val("");  
        $("#mail-title").val("");  
        $("#mail-from").val("");  
        $("#mail-from").attr("disabled", true);
        $("#mail-to").val("");  
        $("#mail-time").html("");  
        flag = true;
        $("#mail-button").changeButton(0, false, '<i class="fas fa-reply"></i> Send');
    }

    $(function(){
        update();
        newmail();
    });
</script>