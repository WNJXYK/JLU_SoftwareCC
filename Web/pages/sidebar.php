<!-- Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
    <img src="/imgs/Logo.png" class="brand-image img-circle elevation-3" style="opacity: .8" alt="Canvas Logo" >
    <span class="brand-text font-weight-light">Canvas</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar User -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="/imgs/Header.png" class="img-circle elevation-2" alt="User Header"></div>
        <div class="info"><a href="#" class="d-block ctext-username">User Name</a></div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="#" class="nav-link active" id="nav-dashboard"><i class="nav-icon fa fa-tachometer-alt" aria-hidden="true"></i><p>Dashboard</p></a>
        </li>
        <!-- Course -->
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fa fa-book" aria-hidden="true"></i>
            <p>Course <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview" id="nav-course-list"></ul>
        </li>
        <!-- Calendar -->
        <li class="nav-item">
            <a href="#" class="nav-link" id="nav-calendar"><i class="nav-icon fa fa-calendar" aria-hidden="true"></i><p>Calendar</p></a>
            </li>
        <!-- Inbox -->
        <li class="nav-item">
            <a href="#" class="nav-link" id="nav-inbox"><i class="nav-icon fa fa-inbox" aria-hidden="true"></i><p>Inbox</p></a>
            </li>
        <!-- Help -->
        <li class="nav-item">
            <a href="#" class="nav-link"><i class="nav-icon fa fa-question-circle" aria-hidden="true"></i><p>Help</p></a>
            </li>
        <!-- Contact -->
        <li class="nav-item">
            <a href="#" class="nav-link" id="nav-contact"><i class="nav-icon fa fa-star" aria-hidden="true"></i><p>Contact</p></a>
            </li>
        </ul>
    </nav>
    </div>
</aside>

<script type="text/javascript">
    function update_sidebar_course(course_data){
        let html_code = "";
        for (let i = 0; i < course_data.length; ++i){
            item = '<li class="nav-item">\
                    <a href="#" class="nav-link" id="nav-course-' + i + '"><i class="far fa-circle nav-icon text-info" aria-hidden="true"></i><p>' + course_data[i]['name']+ '</p></a>\
                    </li>';
            html_code = html_code + item;
        }
        $("#nav-course-list").html(html_code);
        for (let i = 0; i < course_data.length; ++i) 
            $("#nav-course-" + i).click(function(){ 
                redirect("/", {"page": "Home", "Course_ID": course_data[i]['id'], "Course_Name": course_data[i]['name']}); 
            });
    }

    $(function(){
        course_list(update_sidebar_course);
        $("#nav-dashboard").click(function(){ redirect("/", {}); });
        $("#nav-calendar").click(function(){ redirect("/", {"page": "Calendar"}); });
        $("#nav-inbox").click(function(){ redirect("/", {"page": "Inbox"}); });
    });

    /*
    $("#nav-inbox").click(function(){ redirect("index.php", {}); });
    $("#nav-contact").click(function(){ redirect("index.php", {}); });
    */
</script>