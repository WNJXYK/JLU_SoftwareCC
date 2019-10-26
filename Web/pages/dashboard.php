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
                <div class="col-lg-9 col-12">
                    <div class="row" id="dashboard-list">
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-info">
                                <div class="inner"><h3>软件开发</h3><br></div>
                                <div class="icon"><i class="fa fa-book"></i></div>
                                <a href="#" class="small-box-footer">To Learn <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>    
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-info">
                                <div class="inner"><h3>软件开发</h3><br></div>
                                <div class="icon"><i class="fa fa-book"></i></div>
                                <a href="#" class="small-box-footer">To Learn <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> 
                        <div class="col-lg-4 col-12">
                            <div class="small-box bg-info">
                                <div class="inner"><h3>软件开发</h3><br></div>
                                <div class="icon"><i class="fa fa-book"></i></div>
                                <a href="#" class="small-box-footer">To Learn <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i>Todo List</h3>
                        </div>
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list">
                            <li>
                                <span class="text">Design a nice theme</span>
                                <small class="badge badge-success"><i class="far fa-clock"></i> 2 mins</small>
                            </li>
                            </ul>
                        </div>
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
                                <div class="inner"><h3>' + course_data[i]['name']+ '</h3><br></div>\
                                <div class="icon"><i class="fa fa-book"></i></div>\
                                <a href="#" class="small-box-footer" id="dash-course-' + i + '">To Learn <i class="fas fa-arrow-circle-right"></i></a>\
                            </div>\
                        </div>';
            html_code = html_code + item;
        }

        $("#dashboard-list").html(html_code);

        for (let i = 0; i < course_data.length; ++i) 
            $("#dash-course-" + i).click(function(){ 
                redirect("/", {"page": "Home", "Course_ID": course_data[i]['id'], "Course_Name": course_data[i]['name']}); 
            });
    }
    $(function(){
        course_list(update_dashboard_course);
    });
    
</script>
