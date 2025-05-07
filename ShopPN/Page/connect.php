<?php
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");
if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}
?>