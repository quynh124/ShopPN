<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");
if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Biểu đồ đăng ký người dùng</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        .highcharts-figure {
            max-width: 800px;
            margin: 1em auto;
        }
    </style>
</head>
<body>

<figure class="highcharts-figure">
    <div id="userChart"></div>
</figure>

<script>
    Highcharts.chart('userChart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Số người dùng đăng ký theo tháng (<?php echo date("Y"); ?>)'
        },
        xAxis: {
            categories: [
                'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số lượng đăng ký'
            }
        },
        tooltip: {
            shared: true,
            useHTML: true,
            headerFormat: '<b>{point.key}</b><table>',
            pointFormat: '<tr><td style="padding:0">Đăng ký: </td>' +
                '<td style="padding:0"><b>{point.y} người</b></td></tr>',
            footerFormat: '</table>',
            valueDecimals: 0
        },
        series: [{
            name: 'Người dùng',
            data: <?php echo json_encode(array_values($months), JSON_NUMERIC_CHECK); ?>
        }]
    });
</script>

</body>
</html>
