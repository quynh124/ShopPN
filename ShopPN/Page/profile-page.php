<?php
require 'connect.php'; 
session_start();
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
    exit();
}
$email = $_SESSION['user_email'];
$sql_user = "SELECT * FROM users WHERE email = ?";
$stmt_user = $mysqli->prepare($sql_user);
$stmt_user->bind_param("s", $email);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
// Lấy danh sách đơn hàng từ bảng orders dựa trên email
$sql_orders = "SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC";
$stmt_orders = $mysqli->prepare($sql_orders);
$stmt_orders->bind_param("s", $email);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
// Xử lý khi người dùng nhấn nút "Save Changes"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_changes'])) {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $update_sql = "UPDATE users SET fullname = ?, phone = ?, address = ? WHERE email = ?";
    $update_stmt = $mysqli->prepare($update_sql);
    $update_stmt->bind_param("ssss", $fullname, $phone, $address, $email);

    if ($update_stmt->execute()) {
        $success_message = "Profile updated successfully.";
        // Cập nhật thông tin trong biến $user
        $user['fullname'] = $fullname;
        $user['phone'] = $phone;
        $user['address'] = $address;
    } else {
        $error_message = "Failed to update profile. Please try again.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .profile-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-container .form-group {
            margin-bottom: 15px;
        }

        .profile-container .form-group label {
            font-weight: bold;
        }

        .profile-container .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .profile-container .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .profile-container .btn:hover {
            background-color: #0056b3;
        }
        .orders-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .orders-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php 
   include_once 'header.php'; 
   ?>
    <div class="profile-container">
        <h2>Your Profile</h2>
        <?php if (isset($success_message)): ?>
            <p class="message success"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <p class="message error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password"  id="password" value="<?php echo str_repeat('*', strlen($user['password'])); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text"  name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <button type="submit" name="save_changes" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
<div class="orders-container">
    <h3>Your Orders</h3>
    <?php if ($result_orders->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Total Price</th>
                    <th>Final Price</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result_orders->fetch_assoc()): ?>
                    <tr>
                        
                        <td>$<?php echo htmlspecialchars($order['total_price']); ?></td>
                        <td>$<?php echo htmlspecialchars($order['final_price']); ?></td>
                        <td>$<?php echo htmlspecialchars($order['discount_amount']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have not placed any orders yet.</p>
    <?php endif; ?>
</div>
    <?php include 'footer.php'; ?>
</body>
</html>