
<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Xử lý khi người dùng nhấn nút "Update Order"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order'])) {
    $order_id = intval($_POST['order_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $payment_method = trim($_POST['payment_method']);
    $total_price = floatval($_POST['total_price']);
    $final_price = floatval($_POST['final_price']);
    $discount_amount = floatval($_POST['discount_amount']);
    $status = trim($_POST['status']);

    // Kiểm tra nếu thiếu dữ liệu
    if (!$name || !$email || !$address ||!$payment_method || !$total_price || !$final_price || !$discount_amount || !$status) {
        echo "<p style='color: red;'>Missing required fields.</p>";
        exit();
    }

    // Cập nhật thông tin đơn hàng trong cơ sở dữ liệu
    $sql_update = "UPDATE orders 
                   SET name = ?, email = ?, address = ?, payment_method = ?, total_price = ?, final_price = ?, discount_amount = ?, status = ? 
                   WHERE order_id = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param(
        "ssssddssi", // Chuỗi kiểu dữ liệu: s = string, d = double, i = integer
        $name,
        $email,
        $address,
        $payment_method,
        $total_price,
        $final_price,
        $discount_amount,
        $status,
        $order_id
    );

    if ($stmt_update->execute()) {
        echo "<p style='color: green;'>Order updated successfully!</p>";
        header('Location: ../manage_checkout.php'); // Chuyển hướng về trang quản lý đơn hàng
        exit();
    } else {
        echo "<p style='color: red;'>Failed to update order. Please try again.</p>";
    }
}
?><?php
include('../_dbcon.php');
$name = $_POST['name'];

if (isset($_POST['themorder'])) {
    $sql_them = " INSERT INTO orders (name,email, status, address, payment_method,total_price, final_price, discount_amount, order_date, created_at ) VALUE(name='".$name."',email='".$email."',status='".$status."',address='".$address."',payment_method='".$payment_method."',total_price='".$total_price."',final_price='".$final_price."',discount_amount='".$discount_amount."')";
    mysqli_query($mysqli, $sql_them);
    header('Location:../manage_checkout.php?action=orders&query=add');
} elseif (isset($_POST['suaorder'])) {
    $sql_update = " UPDATE orders SET name='".$name."',email='".$email."',status='".$status."',address='".$address."',payment_method='".$payment_method."',total_price='".$total_price."',final_price='".$final_price."',discount_amount='".$discount_amount."' WHERE order_id='$_GET[orderid]' ";
    mysqli_query($mysqli, $sql_update);
    header('Location:../manage_checkout.php?action=order&query=add');
} else {
    $id = $_GET['orderid'];
    $sql_xoa = "DELETE from orders where order_id='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../manage_checkout.php?action=order&query=add');
}
?>