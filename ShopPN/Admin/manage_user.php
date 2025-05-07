<?php
// Kết nối đến cơ sở dữ liệu
require './_dbcon.php'; // Đảm bảo tệp này chứa kết nối cơ sở dữ liệu

// Truy vấn dữ liệu từ bảng users
$query_user = mysqli_query($connect, "SELECT fullname, email, phone, address, role FROM users");

if (!$query_user) {
    die("Query failed: " . mysqli_error($connect));
}
?>

<?php
$sql_user="SELECT * from users ORDER BY user_id DESC";
$query_user= mysqli_query($mysqli,$sql_user);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <title>Shop Nội Thất PN</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <link href="../plugins/components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- ===== Animation CSS ===== -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="css/style.css" rel="stylesheet">
    <!-- ===== Color CSS ===== -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="css/btn.css" rel="stylesheet">
</head>

<body class="mini-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- ===== Top-Navigation ===== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </a>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
                    </li>
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <i class="icon-magnifier"></i>
                            <input type="text" placeholder="Search..." class="form-control">
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
                            <i class="icon-speech"></i>
                            <span class="badge badge-xs badge-danger">6</span>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown">
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <a href="javascript:void(0);">
                                        <div class="user-img">
                                            <img src="../plugins/images/users/logo.jpg" alt="user" class="img-circle">
                                            <span class="profile-status online pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:30 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="user-img">
                                            <img src="../plugins/images/users/2.jpg" alt="user" class="img-circle">
                                            <span class="profile-status busy pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5>
                                            <span class="mail-desc">I've sung a song! See you at</span>
                                            <span class="time">9:10 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="user-img">
                                            <img src="../plugins/images/users/3.jpg" alt="user" class="img-circle"><span class="profile-status away pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5>
                                            <span class="mail-desc">I am a singer!</span>
                                            <span class="time">9:08 AM</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="user-img">
                                            <img src="../plugins/images/users/4.jpg" alt="user" class="img-circle">
                                            <span class="profile-status offline pull-right"></span>
                                        </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5>
                                            <span class="mail-desc">Just see the my admin!</span>
                                            <span class="time">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="text-center" href="javascript:void(0);">
                                    <strong>See all notifications</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light font-20" data-toggle="dropdown" href="javascript:void(0);">
                            <i class="icon-calender"></i>
                            <span class="badge badge-xs badge-danger">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 2</strong>
                                            <span class="pull-right text-muted">20% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 3</strong>
                                            <span class="pull-right text-muted">60% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete (warning)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div>
                                        <p>
                                            <strong>Task 4</strong>
                                            <span class="pull-right text-muted">80% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="javascript:void(0);">
                                    <strong>See All Tasks</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="right-side-toggle">
                        <a class="right-side-toggler waves-effect waves-light b-r-0 font-20" href="javascript:void(0)">
                            <i class="icon-settings"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php include 'sidebar.php'; ?>
        <!-- ===== Left-Sidebar-End ===== -->
        <!-- Page Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                    <div class="white-box">
    <h3 class="box-title m-b-0">Manage User</h3>
    <button class="Btn" style="margin-bottom: 20px; margin-top: 20px;">
        <a href="user/add.php" style="color: white;">Add User</a></button>
    <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
    <div class="table-responsive">
        <table id="example23" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 0;
                while ($row = mysqli_fetch_array($query_user)) {
                    $i++;
                ?>
                 <tr>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['address']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
               
                
                    <td>
                    <a href="user/edit.php?userid=<?php echo $row['user_id']; ?>" class="Btn">Edit</a>
                    </td><td>
                    <a href="./user/data_processing.php?userid=<?php echo $row['user_id']; ?>" class="Btn">Delete</a>
                </td>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- ===== Right-Sidebar ===== -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="icon-close right-side-toggler"></i></span> </div>
                        <div class="r-panel-body">
                            <ul class="hidden-xs">
                                <li><b>Layout Options</b></li>
                                <li>
                                    <div class="checkbox checkbox-danger">
                                        <input id="headcheck" type="checkbox" class="fxhdr">
                                        <label for="headcheck"> Fix Header </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox checkbox-warning">
                                        <input id="sidecheck" type="checkbox" class="fxsdr">
                                        <label for="sidecheck"> Fix Sidebar </label>
                                    </div>
                                </li>
                            </ul>
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme working">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="yellow" class="yellow-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="black" class="black-theme">6</a></li>
                                <li class="db"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="yellow-dark" class="yellow-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="black-dark" class="black-dark-theme">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ===== Right-Sidebar-End ===== -->
            </div>
            <!-- /.container-fluid -->
            <footer class="footer t-a-c">
                Shop Nội Thất PN
            </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="js/sidebarmenu.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.js"></script>
    <script src="../plugins/components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
    $(function() {
        $('#myTable').DataTable();

        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
    <!--Style Switcher -->
    <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
