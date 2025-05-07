<?php
if (isset($_POST['sub'])) {
    require '_dbcon.php'; 
    // Lấy dữ liệu từ form
    $getname = trim($_POST['getname']);
    $getemail = trim($_POST['getemail']);
    $getphone = trim($_POST['getphone']);
    $getpass = trim($_POST['getpass']);
    $getaddress = trim($_POST['getaddress']);

    // Kiểm tra xem email đã tồn tại chưa
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $getemail);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $rowcount = mysqli_stmt_num_rows($stmt);

    if ($rowcount > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($getpass, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (fullname, email, phone, password, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $getname, $getemail, $getphone, $hashedPassword, $getaddress);

        if (mysqli_stmt_execute($stmt)) {
            // Chuyển hướng đến trang đăng nhập
            header('Location: login.php');
            exit();
        } else {
            echo "An error occurred while saving your data. Please try again.";
        }
    }

    // Đóng kết nối
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../Css/login.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   
    <style>
        .box-input .box-user {
            position: relative;
            margin-bottom: 20px;
        }

        .box-input .box-user input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .box-input .box-user input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .box-input .box-user i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #888;
            font-size: 18px;
        }

        .box-input .box-user input:hover {
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="all-container">
        <div class="box-picture">
            <div class="box-text">
                <h1>Welcome!</h1>
                <div class="content">
                    <div class="content-1">Create your account to get started</div>
                </div>
                
            </div>
        </div>
        <form method="POST" action="register.php">
            <div class="box-login" style=" padding-bottom: 80px;top: 240px;">
                <h2>Register</h2>
                <div class="box-input">
                    <div class="box-user" >
                        <i class="fa-solid fa-user" style="right: 200px;height: 40px;left: 0px;width: 40px;"></i>
                        <input type="text" name="getname" placeholder="Full Name" required>
                    </div>
                    <div class="box-user">
                        <i class="fa-solid fa-envelope" style="right: 200px;height: 40px;left: 0px;width: 40px;"></i>
                        <input type="email" name="getemail" placeholder="Email" required>
                    </div>
                    <div class="box-user">
                        <i class="fa-solid fa-lock" style="right: 200px;height: 40px;left: 0px;width: 40px;"></i>
                        <input type="password" name="getpass" placeholder="Password" required id="password">
                        <i class="fa-solid fa-eye" id="togglePassword" style="cursor: pointer;margin-left: 10px;left: 289px;width: 45px;padding-top: 0px;border-bottom-width: 5px;padding-bottom: 5px;height: 35px;border-right-width: 5px;right: 10px;"></i>
                    </div>
                    <div class="box-user">
                        <i class="fa-solid fa-phone" style="right: 200px;height: 40px;left: 0px;width: 40px;"></i>
                        <input type="text" name="getphone" placeholder="Phone" required>
                    </div>
                    <div class="box-user">
                        <i class="fa-solid fa-map-marker-alt" style="right: 200px;height: 40px;left: 0px;width: 40px;"></i>
                        <input type="text" name="getaddress" placeholder="Address" required>
                    </div>
                </div>
                <div class="box-forgot-password">
                    <div><a href="login.php">Already have an account? Login</a></div>
                    <div><a href="../index.php">Home</a></div>
                </div>
                <div class="button-login">
                    <button type="submit" name="sub">Register</button>
                </div>
            </div>
        </form>
    </div>

</body>

</html>
<script src="https://kit.fontawesome.com/eda05fcf5c.js" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#password');
    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>