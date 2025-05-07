<?php
require 'connect.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $email = trim($_POST['email']);
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Kiểm tra nếu mật khẩu mới và xác nhận mật khẩu không khớp
    if ($new_password !== $confirm_password) {
        echo "<p style='color: red;'>New password and confirm password do not match.</p>";
        exit();
    }

    // Lấy thông tin người dùng từ cơ sở dữ liệu dựa trên email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];

        // Kiểm tra mật khẩu cũ
        if (password_verify($old_password, $hashed_password)) {
            // Mã hóa mật khẩu mới
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $update_sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt_update = $mysqli->prepare($update_sql);
            $stmt_update->bind_param("ss", $new_hashed_password, $email);

            if ($stmt_update->execute()) {
                echo "<p style='color: green;'>Password changed successfully!</p>";
            } else {
                echo "<p style='color: red;'>Failed to update password. Please try again later.</p>";
            }
        } else {
            echo "<p style='color: red;'>Old password is incorrect.</p>";
        }
    } else {
        echo "<p style='color: red;'>Email not found.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <title>Forgot Password</title>
    <style> 
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .box-forgot-password {
            margin-top: 20px;
            text-align: center;
        }

        .box-forgot-password a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .box-forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="all-container">
        <div class="box-picture">
            <div class="box-text">
                <h1>Welcome Back!</h1>
                <div class="content">
                    <div class="content-1">Enter personal information into your</div>
                    <div class="content-2">User account</div>
                </div>
                <div class="content-button">
                    <button>Sign up</button>
                </div>
            </div>
        </div>
        <div class="box-login">
            <div class="box-input">
            <h2>Change Password</h2>
            <form method="POST" action="forgotpassword.php">
            <div class="form-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Enter old password" required>
            </div>
            <div class="form-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
            </div>
            <button type="submit" name="change_password" class="btn-primary">Change Password</button>
            </form>
            </div>
            <div class="box-forgot-password">
                <div>
                    <a href="register.php">Register</a>
                </div>
                <div>
                    <a href="../index.php">Home</a>
                </div>
            </div>
           
        </div>
    </div>
</body>
</html>
<script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
<script src="js/main.js"></script>