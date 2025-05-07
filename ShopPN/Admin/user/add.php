

<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Xử lý khi người dùng nhấn nút "Add User"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = trim($_POST['role']);

    // Kiểm tra nếu email đã tồn tại
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($check_email_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color: red;'>Email already exists. Please use a different email.</p>";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $insert_sql = "INSERT INTO users (fullname, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param("ssssss", $fullname, $email, $password, $phone, $address, $role);

        if ($stmt->execute()) {
            $success_message = "User added successfully!";
        } else {
            $error_message = "Failed to add user. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Admin, Dashboard, Bootstrap">
    <meta name="description" content="Admin Dashboard Template">
    <meta name="author" content="Your Name">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <title>Add User</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    
    <!-- ===== Plugin CSS ===== -->
    <link href="../css/animate.css" rel="stylesheet">
    
    <!-- ===== Custom CSS ===== -->
    <link href="../css/style.css" rel="stylesheet">
    
    <!-- ===== Color CSS ===== -->
    <link href="../css/colors/default.css" id="theme" rel="stylesheet">
</head>
<body>
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- Header -->
        <header>
            <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./index.php">Admin Dashboard</a>
                </div>
            </nav>
        </header>
        
        <!-- Page Content -->
        <div class="container-fluid">
        <?php if (isset($success_message)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Add User</h3>
                <form method="POST" action="">
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter full name" required>
                    </div>
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                    </div>
                    
                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>
                    </div>
                    
                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required>
                    </div>
                    
                    <!-- Role -->
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
                    <a href="../index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- Footer -->
        <footer class="footer text-center">
        </footer>
    </div>
    
    <!-- ===== JavaScript ===== -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../js/custom.js"></script>
</body>
</html>