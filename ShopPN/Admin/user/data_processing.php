
<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Xử lý khi người dùng nhấn nút "Update User"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $user_id = intval($_POST['userid']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = trim($_POST['role']);

    // Kiểm tra nếu thiếu dữ liệu
    if (!$fullname || !$email || !$phone || !$address || !$role) {
        echo "<p style='color: red;'>Missing required fields.</p>";
        exit();
    }

    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $sql_update = "UPDATE users 
                   SET fullname = ?, email = ?, phone = ?, address = ?, role = ? 
                   WHERE user_id = ?";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $fullname, $email, $phone, $address, $role, $user_id);

    if ($stmt_update->execute()) {
        echo "<p style='color: green;'>User updated successfully!</p>";
        header('Location: ../manage_user.php'); // Chuyển hướng về trang quản lý người dùng
        exit();
    } else {
        echo "<p style='color: red;'>Failed to update user. Please try again.</p>";
    }
}
?>
<?php
include('../_dbcon.php');
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$role = $_POST['role'];
$created_at = date('Y-m-d H:i:s');
if (isset($_POST['themuser'])) {
    $sql_them = " INSERT INTO users (fullname, email, password, phone, address, role , created_at) VALUE(fullname='".$fullname."', email='".$email."',password='".$password."', phone='".$phone."', address='".$address."',role='".$role."', created_at='".$created_at."')";
    mysqli_query($mysqli, $sql_them);
    header('Location:../manage_user.php?action=user&query=add');
} elseif (isset($_POST['suauser'])) {
    $sql_update = " UPDATE users SET fullname='".$fullname."', email='".$email."',password='".$password."', phone='".$phone."', address='".$address."',role='".$role."', created_at='".$created_at."' WHERE user_id='$_GET[userid]' ";
    mysqli_query($mysqli, $sql_update);
    header('Location:../manage_user.php?action=user&query=add');
} else {
    $id = $_GET['userid'];
    $sql_xoa = "DELETE from users where user_id='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../manage_user.php?action=user&query=add');
}
?>