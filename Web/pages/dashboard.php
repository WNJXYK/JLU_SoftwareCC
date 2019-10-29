<!-- Contains Page -->
<div class="content-wrapper">
    <section class="content-header">
    <div class="container-fluid">
        <h1>Dashboard</h1>
    </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="row" id="dashboard-list">
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    function update_dashboard_course(course_data){
        let html_code = "";
        for (let i = 0; i < course_data.length; ++i){
            item = '<div class="col-lg-4 col-12">\
                            <div class="small-box bg-info">\
                                <div class="inner"><h3>' + course_data[i].name+ '</h3><br>' + JSON.parse(course_data[i]['info']).Extra + '</div>\
                                <div class="icon"><i class="fa fa-book"></i></div>\
                                <a href="#" class="small-box-footer" id="dash-course-' + i + '">To Learn <i class="fas fa-arrow-circle-right"></i></a>\
                            </div>\
                        </div>';
            html_code = html_code + item;
        }

        if ($.cookie("User_Type") == "Admin"){
            html_code += '<div class="col-lg-4 col-12">\
                            <div class="small-box bg-danger">\
                                <div class="inner"><h3> Admin Panel </h3><br/><br/></div>\
                                <div class="icon"><i class="fa fa-tools"></i></div>\
                                <a href="./admin/admin.php" class="small-box-footer">To Edit <i class="fas fa-arrow-circle-right"></i></a>\
                            </div>\
                        </div>'
        }

        $("#dashboard-list").html(html_code);

        for (let i = 0; i < course_data.length; ++i) 
            $("#dash-course-" + i).click(function(){ 
                redirect(getRoot() + "/", {"page": "Home", "Course_ID": course_data[i]['id'], "Course_Name": course_data[i]['name']}); 
            });
    }
    $(function(){
        course_list(update_dashboard_course);
    });
    
</script>
