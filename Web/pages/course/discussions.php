<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Discussions</h1>
    </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr><th>Name</th><th>From</th></tr>
                        </thead>
                        <tbody id="discussion-content"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function update_module(json){
        let content = JSON.parse(json.module).Modules;
        $("#discussion-content").html("");
        for (let i = 0; i < content.length; ++i){
            for (let j = 0; j < content[i].Unit.length; ++j){
                if (content[i].Unit[j].Type != 1) continue;
                html_code = '<tr><td><a href="#" onclick="discuss(' + content[i].Unit[j].ID + ', \'' + content[i].Unit[j].Name + '\');">' + content[i].Unit[j].Name + '</a></td><td>' + content[i].Name + '</td></tr>';
                $("#discussion-content").append($(html_code));
            }
        }
    }

    function discuss(post, name){
        if (post == 0) alert("This Section has not been finished yet."); else{
            redirect("/", {"page": "Post", "Markdown_ID": post, "Markdown_Title": name});
        }
    }

    $(function(){
        course_module($("#Course_ID").val(), update_module);
    });
</script>