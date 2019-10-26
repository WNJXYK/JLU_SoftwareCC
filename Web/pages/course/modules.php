<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Modules</h1>
    </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <?php if (check_user_type("Teacher")){ ?>
            <button type="submit" class="btn btn-default form-control mb-3" onclick="edit();">Edit Modules</button>
            <?php } ?>
            <div class="row" id = "module-content">
                <h2> Loading~ </h2>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function update_module(json){
        let content = JSON.parse(json.module).Modules;
        // Render
        let html_code = "";
        for (let i = 0; i < content.length; ++i){
            html_code += '<div class="card col-12" id="module-unit-' + i + '">\
            <div class="card-header"><h3 class="card-title">' + content[i].Name + '</h3></div>\
            <div class="card-body"><ul>';
            for (let j = 0; j < content[i].Unit.length; ++j){
                html_code += '<li>';
                switch(content[i].Unit[j].Type) {
                    case 0: html_code += '<i class="fa fa-book" aria-hidden="true"></i>'; break;
                    case 1: html_code += '<i class="fa fa-comment" aria-hidden="true"></i>'; break;
                    case 2: html_code += '<i class="fa fa-question" aria-hidden="true"></i>'; break;
                } 
                html_code += '  <a href="#" id="module-item-' + i + '-' + j + '">' + content[i].Unit[j].Name + '<a></li>';
            }
            html_code += '</ul></div></div>';
        }
        $("#module-content").html(html_code);

        // Bind
        for (let i = 0; i < content.length; ++i){
            for (let j = 0; j < content[i].Unit.length; ++j){
                switch(content[i].Unit[j].Type) {
                    case 0: 
                        $("#module-item-" + i + "-" + j).click(function(){
                            if (content[i].Unit[j].ID == 0) alert("This Section has not been finished yet."); else{
                                redirect("/", {"page": "Markdown", "Markdown_ID": content[i].Unit[j].ID,"Markdown_Title": content[i].Unit[j].Name});
                            }
                        });
                        break;
                    case 1: 
                        $("#module-item-" + i + "-" + j).click(function(){
                            if (content[i].Unit[j].ID == 0) alert("This Section has not been finished yet."); else{
                                redirect("/", {"page": "Post", "Markdown_ID": content[i].Unit[j].ID, "Markdown_Title": content[i].Unit[j].Name});
                            }
                        });
                        break;
                    case 2: break;
                } 
            }
        }
    }

    function edit(){ newdirect("/admin/modules.php", {"id": $("#Course_ID").val() }); }

    $(function(){
        course_module($("#Course_ID").val(), update_module);
    });
</script>