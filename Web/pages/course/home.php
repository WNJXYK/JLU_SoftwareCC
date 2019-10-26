<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Home</h1>
    </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <?php if (check_user_type("Teacher")){ ?>
                    <button type="submit" class="btn btn-default btn-sm float-right" onclick="edit();">Edit</button>
                    <?php } ?>
                    <h3 class="card-title">Recent Announcement</h3>
                </div>
                <div class="card-body" id="home-content"></div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function update_home(json){
        course_markdown(json.home, function(text){ $("#home-content").html(markdown_render.toHTML(text)); });
    }
    function update_markdown(json){
        newdirect("/admin/markdown.php", {"id": json.home});
    }
    function edit(){ course_module($("#Course_ID").val(), update_markdown); }
    $(function(){
        $("#home-content").html(markdown_render.toHTML("**Loading~**"));
        course_module($("#Course_ID").val(), update_home);
    });
</script>