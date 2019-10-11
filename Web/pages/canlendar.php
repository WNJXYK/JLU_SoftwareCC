<!-- Contains Page -->
<link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-list/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8     col-12">
                <div id="calendar"></div>
            </div>
            <div class="col-lg-4 col-12">
                <h2>Calendar</h2>
                <div id="clist"></div>
            </div>
        </div>
        
    </section>
</div>

<script src="./plugins/fullcalendar/main.min.js"></script>
<script src="./plugins/fullcalendar-list/main.min.js"></script>
<script src="./plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="./plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="./plugins/fullcalendar-bootstrap/main.min.js"></script>

<script type="text/javascript">

    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear();
    let courseEvent =  [
        { title: 'All Day Event', start: new Date(y, m, d+1), backgroundColor: '#f56954', borderColor: '#f56954'},
        { title: 'Long Event', start: new Date(y, m, d - 5), end: new Date(y, m, d - 2), backgroundColor: '#f39c12', borderColor    : '#f39c12'}
      ];
    function updateCalendar(courseEvent){
        let Calendar = FullCalendar.Calendar;
        let calendarFull = document.getElementById('calendar');
        let calendarList = document.getElementById('clist');
        let calendarF = new Calendar(calendarFull, {
        plugins: [ 'bootstrap', 'dayGrid', 'timeGrid'],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth, timeGridWeek, timeGridDay'
        },
        events: courseEvent, 
        });
        let calendarL = new Calendar(calendarList, {
            plugins: [ 'bootstrap', 'list'],
            header: { left  : '', center: '', right : '' },
            defaultView: 'listWeek',
            events: courseEvent, 
            height: "parent"
        });
        calendarF.render();
        calendarL.render();
    }
    updateCalendar(courseEvent);
</script>