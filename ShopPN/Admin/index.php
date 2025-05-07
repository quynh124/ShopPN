<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Truy vấn dữ liệu từ bảng products
$sql = "SELECT name, price FROM products";
$result = $mysqli->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [$row['name'], (float)$row['price']];
    }
}
// Truy vấn số lượng người dùng đăng ký theo từng tháng trong năm hiện tại
$sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS user_count
        FROM users
        WHERE YEAR(created_at) = YEAR(CURDATE())
        GROUP BY MONTH(created_at)";
$result = $mysqli->query($sql);

// Tạo mảng dữ liệu cho Highcharts
$months = array_fill(1, 12, 0); // khởi tạo mảng 12 tháng
while ($row = $result->fetch_assoc()) {
    $months[(int)$row['month']] = (int)$row['user_count'];
}
// Truy vấn số lượng đơn hàng theo từng tháng
$sql = "SELECT MONTH(order_date) AS month, COUNT(*) AS order_count 
        FROM orders 
        WHERE YEAR(order_date) = YEAR(CURDATE()) 
        GROUP BY MONTH(order_date)";
$result = $mysqli->query($sql);

// Chuẩn bị dữ liệu cho biểu đồ
$order_data = array_fill(1, 12, 0); // Khởi tạo mảng 12 tháng với giá trị 0
while ($row = $result->fetch_assoc()) {
    $order_data[(int)$row['month']] = (int)$row['order_count'];
}
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
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>DashBoard</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ===== Plugin CSS ===== -->
    <link href="../plugins/components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="../plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        // Chuyển dữ liệu PHP sang JavaScript
        var chartData = <?php echo json_encode($data); ?>;

        // Vẽ biểu đồ
        google.charts.load('current', {
            packages: ['corechart']
        });
        google.charts.setOnLoadCallback(function() {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Product');
            dataTable.addColumn('number', 'Price');
            dataTable.addRows(chartData);

            var options = {
                title: 'Product Prices',
                width: 600,
                height: 400,
                pieHole: 0.4, // Tạo biểu đồ dạng Donut
                colors: ['#4CAF50', '#FF9800', '#2196F3', '#F44336', '#9C27B0']
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
            chart.draw(dataTable, options);
        });
    </script>
     <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        .highcharts-figure {
            max-width: 800px;
            margin: 1em auto;
        }
    </style>

</head>

<body class="mini-sidebar">
    <!-- ===== Main-Wrapper ===== -->
    <div id="wrapper">
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <!-- ===== Top-Navigation ===== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <a class="navbar-toggle font-20 hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="fa fa-bars"></i>
                </a>
                
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="logout.php" class="sidebartoggler font-20 waves-effect waves-light"><i class="icon-arrow-left-circle"></i></a>
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
                                            <img src="./image/user/image.png" alt="user" class="img-circle">
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
        <!-- ===== Top-Navigation-End ===== -->
        <!-- ===== Left-Sidebar ===== -->
        <?php include 'sidebar.php'; ?>
        <!-- ===== Left-Sidebar-End ===== -->
        <!-- ===== Page-Content ===== -->
        <div class="page-wrapper">
        <div class="row m-0">
    <!-- Tổng số đơn đặt hàng -->
    <div class="col-md-3 col-sm-6 info-box">
        <div class="media">
            <div class="media-left">
                <span class="icoleaf bg-primary text-white"><i class="mdi mdi-cart-outline"></i></span>
            </div>
            <div class="media-body">
                <?php
                // Truy vấn tổng số đơn đặt hàng
                $sql_total_orders = "SELECT COUNT(*) AS total_orders FROM orders";
                $result_total_orders = $mysqli->query($sql_total_orders);
                $total_orders = $result_total_orders->fetch_assoc()['total_orders'];
                ?>
                <h3 class="info-count text-blue"><?php echo $total_orders; ?></h3>
                <p class="info-text font-12">Total Orders</p>
                <span class="hr-line"></span>
                <p class="info-ot font-15">All Orders<span class="label label-rounded label-success"><?php echo $total_orders; ?></span></p>
            </div>
        </div>
    </div>

    <!-- Tổng số tiền -->
    <div class="col-md-3 col-sm-6 info-box">
        <div class="media">
            <div class="media-left">
                <span class="icoleaf bg-primary text-white"><i class="mdi mdi-cash-multiple"></i></span>
            </div>
            <div class="media-body">
                <?php
                // Truy vấn tổng số tiền
                $sql_total_earnings = "SELECT SUM(total_price) AS total_earnings FROM orders";
                $result_total_earnings = $mysqli->query($sql_total_earnings);
                $total_earnings = $result_total_earnings->fetch_assoc()['total_earnings'];
                ?>
                <h3 class="info-count text-blue">&#36;<?php echo number_format($total_earnings, 2); ?></h3>
                <p class="info-text font-12">Total Earnings</p>
                <span class="hr-line"></span>
                <p class="info-ot font-15">Earnings<span class="label label-rounded label-success">&#36;<?php echo number_format($total_earnings, 2); ?></span></p>
            </div>
        </div>
    </div>

    <!-- Tổng số người dùng -->
    <div class="col-md-3 col-sm-6 info-box">
        <div class="media">
            <div class="media-left">
                <span class="icoleaf bg-primary text-white"><i class="mdi mdi-account-multiple"></i></span>
            </div>
            <div class="media-body">
                <?php
                // Truy vấn tổng số người dùng
                $sql_total_users = "SELECT COUNT(*) AS total_users FROM users";
                $result_total_users = $mysqli->query($sql_total_users);
                $total_users = $result_total_users->fetch_assoc()['total_users'];
                ?>
                <h3 class="info-count text-blue"><?php echo $total_users; ?></h3>
                <p class="info-text font-12">Total Users</p>
                <span class="hr-line"></span>
                <p class="info-ot font-15">Users<span class="label label-rounded label-success"><?php echo $total_users; ?></span></p>
            </div>
        </div>
    </div>

    <!-- Tổng số đơn hàng được hoàn thành -->
    <div class="col-md-3 col-sm-6 info-box">
        <div class="media">
            <div class="media-left">
                <span class="icoleaf bg-primary text-white"><i class="mdi mdi-checkbox-marked-circle-outline"></i></span>
            </div>
            <div class="media-body">
                <?php
                // Truy vấn tổng số đơn hàng được hoàn thành
                $sql_completed_orders = "SELECT COUNT(*) AS completed_orders FROM orders WHERE status = 'Completed'";
                $result_completed_orders = $mysqli->query($sql_completed_orders);
                $completed_orders = $result_completed_orders->fetch_assoc()['completed_orders'];
                ?>
                <h3 class="info-count text-blue"><?php echo $completed_orders; ?></h3>
                <p class="info-text font-12">Completed Orders</p>
                <span class="hr-line"></span>
                <p class="info-ot font-15">Completed<span class="label label-rounded label-success"><?php echo $completed_orders; ?></span></p>
            </div>
        </div>
    </div>
</div>
            <!-- ===== Page-Container ===== -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="white-box stat-widget">
                        <figure class="highcharts-figure">
    <div id="userChart"></div>
</figure>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="white-box">
                            <h4 class="box-title">Chart Product</h4>
                            <div id="piechart_div" style="width: 600px; height: 400px; margin: 0 auto;"></div>

                        </div>
                    </div>
                </div>
                <div class="row">
                <div id="orderChart" style="width: 100%; height: 400px;"></div>
                        
                    </div>
                   
                </div>
     
                    <div class="col-md-12">
                      
                    </div>
                </div> 
               
                </div>
               
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
                
            </div>
            
            <footer class="footer t-a-c">
            Shop Nội Thất PN
            </footer>
        </div>
       
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            Highcharts.chart('orderChart', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Monthly Orders in <?php echo date("Y"); ?>'
                },
                xAxis: {
                    categories: months,
                    title: {
                        text: 'Month'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Orders'
                    }
                },
                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '{point.y} orders'
                },
                series: [{
                    name: 'Orders',
                    data: <?php echo json_encode(array_values($order_data)); ?>,
                    color: '#007bff'
                }]
            });
        });
    </script>
    <script>
    Highcharts.chart('userChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Number of monthly registered users (<?php echo date("Y"); ?>)'
        },
        xAxis: {
            categories: [
                'Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Month 6',
                'Month 7', 'Month 8', 'Month 9', 'Month 10', 'Month 11', 'Month 12'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Number of registrations'
            }
        },
        tooltip: {
            shared: true,
            useHTML: true,
            headerFormat: '<b>{point.key}</b><table>',
            pointFormat: '<tr><td style="padding:0">Register: </td>' +
                '<td style="padding:0"><b>{point.y} user</b></td></tr>',
            footerFormat: '</table>',
            valueDecimals: 0
        },
        series: [{
            name: 'User',
            data: <?php echo json_encode(array_values($months), JSON_NUMERIC_CHECK); ?>
        }]
    });
</script>
    <!-- ===== jQuery ===== -->
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
    <!-- ===== Bootstrap JavaScript ===== -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ===== Slimscroll JavaScript ===== -->
    <script src="js/jquery.slimscroll.js"></script>
    <!-- ===== Wave Effects JavaScript ===== -->
    <script src="js/waves.js"></script>
    <!-- ===== Menu Plugin JavaScript ===== -->
    <script src="js/sidebarmenu.js"></script>
    <!-- ===== Custom JavaScript ===== -->
    <script src="js/custom.js"></script>
    <!-- ===== Plugin JS ===== -->
    <script src="../plugins/components/chartist-js/dist/chartist.min.js"></script>
    <script src="../plugins/components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../plugins/components/sparkline/jquery.sparkline.min.js"></script>
    <script src="../plugins/components/sparkline/jquery.charts-sparkline.js"></script>
    <script src="../plugins/components/knob/jquery.knob.js"></script>
    <script src="../plugins/components/easypiechart/dist/jquery.easypiechart.min.js"></script>
    <script src="js/db1.js"></script>
    <!-- ===== Style Switcher JS ===== -->
    <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
