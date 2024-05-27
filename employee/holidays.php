<?php 
session_start();
error_reporting(0);
include_once('../includes/config.php');

if(strlen($_SESSION['userlogin']) == 0){
    header('location:../login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fullcalendar/lib/main.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
	
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    
    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
    
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">
    
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="../assets/css/select1.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/calendarjs/1.1.0/calendar.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }
        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
        .fc-event-time {
            display: none;
        }
        .fc-direction-ltr .fc-daygrid-event.fc-event-end, .fc-direction-rtl .fc-daygrid-event.fc-event-start {
            background: #00c5fb;
            color:#fff;
        }

        .fc-next-button {
            margin-left: 4px!important;
        }
    </style>
</head>

<body >
   <!-- Main Wrapper -->
   <div class="main-wrapper">
		
        <!-- Header -->
        <?php include_once("../includes/header_employee.php");?>

        <!-- /Header -->
        
        <!-- Sidebar -->
        <?php include_once("../includes/sidebar_employee.php");?>
        <!-- /Sidebar -->
        
        <!-- Page Wrapper -->
        <div class="page-wrapper">
        
            <!-- Page Content -->
            <div class="content container-fluid">
            
                <!-- Page Header -->
                
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Lịch nghỉ</h3>
                           
                        </div>
                        
                    </div>
                    <div class="row">
                       <div class="col-lg-12">
                        <div class="card mb-0">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                        </div>
                       </div>
                        
                    </div>
                </div>
               
               
            </div>
            <!-- /Page Content -->
        
   
            
        </div>
        <!-- /Page Wrapper -->
        
    </div>
    <!-- /Main Wrapper -->

    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
           <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">

                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Chi tiết ngày nghỉ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Tên ngày nghỉ</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                         
                            <dt class="text-muted">Ngày nghỉ</dt>
                            <dd id="start" class=""></dd>
                    
                        </dl>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
        </div>
    </div>

<?php 
setlocale(LC_TIME, 'vi_VN');
$stmt = $dbh->query("SELECT id, name, holiday_date FROM `holidays`");
$sched_res = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row['sdate'] = strftime("%A, %d %B %Y %H:%M:%S", strtotime($row['holiday_date']));
    $sched_res[$row['id']] = $row;
}
?>

</body>

<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/plugins/fullcalendar/lib/main.min.js"></script>
<!-- Bootstrap Core JS -->
<!-- Slimscroll JS -->
<script src="../assets/js/jquery.slimscroll.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/vi.min.js"></script>
<!-- Custom JS -->
<script src="../assets/js/app.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var scheds = <?php echo json_encode($sched_res); ?>;
    var events = [];
    if (!!scheds) {
        Object.keys(scheds).map(k => {
            var row = scheds[k];
            var startDate = new Date(row.holiday_date);
            events.push({ id: row.id, title: row.name, start: startDate });
        });
    }

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,list'
        },
        selectable: true,
        themeSystem: 'bootstrap',
        events: events,
        editable: true,
        eventClick: function(info) {
            var _details = $('#event-details-modal');
            var id = info.event.id;
            if (!!scheds[id]) {
                _details.find('#title').text(info.event.title);
                _details.find('#start').text(moment(info.event.start).locale('vi').format('dddd, DD MMMM YYYY')); 
                _details.modal('show');
            } else {
                alert("Event is undefined");
            }
        },
        locale: 'vi', // Thiết lập ngôn ngữ là tiếng Việt
        buttonText: {
            today: "Hôm nay",
            month: "Tháng",
            week: "Tuần",
            day: "Ngày",
            list: "Danh sách"
        }
    });
    calendar.render();
});
</script>


</html>