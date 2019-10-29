<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Grades</h1>
    </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr><th>ID</th><th>Name</th><th>Score</th><th>Time</th></tr>
                        </thead>
                        <tbody id="grade-content">
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function update_grades(json){
        console.log(json);
        $("#grade-content").html("");
        for (let i = 0; i < json.length; ++i){
            $("#grade-content").append($('<tr><td>' + json[i].uid + '</td><td>' + json[i].name + '</td><td>' + json[i].tot + '</td><td>' + json[i].start + '</td></tr>'));
        }
    }
    
    $(function(){
        $("#home-content").html(markdown_render.toHTML("**Loading~**"));
        course_grade($("#Course_ID").val(), update_grades);
    });
</script>