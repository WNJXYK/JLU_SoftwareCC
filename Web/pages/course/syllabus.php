<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Syllabus</h1>
    </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <?php if (check_user_type("Teacher")){ ?>
                    <button type="submit" class="btn btn-default btn-sm float-right" onclick="edit();">Edit</button>
                    <?php } ?>
                    <h3 class="card-title">Course Syllabus</h3>
                </div>
                <div class="card-body" id="syllabus-content"></div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function update_syllabus(json){
        course_markdown(json.syllabus, function(text){ $("#syllabus-content").html(markdown_render.toHTML(text)); });
    }
    function update_markdown(json){
        newdirect(getRoot() + "/admin/markdown.php", {"Markdown_Edit_ID": json.syllabus });
    }
    function edit(){ course_module($("#Course_ID").val(), update_markdown); }
    $(function(){
        $("#syllabus-content").html(markdown_render.toHTML("**Loading~**"));
        course_module($("#Course_ID").val(), update_syllabus);
    });
</script>