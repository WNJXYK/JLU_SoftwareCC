<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <button type="submit" class="btn btn-default btn-sm float-right" onclick="update();">Refresh</button>
                    <h3 class="card-title" id="markdown-title"></h3>
                </div>
                <div class="card-body" id="markdown-content"></div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function update(){ course_markdown($("#Markdown_ID").val(), function(text){ $("#markdown-content").html(markdown_render.toHTML(text)); }); }
    $(function(){
        $("#markdown-title").html($("#Markdown_Title").val());
        update();
    });
</script>