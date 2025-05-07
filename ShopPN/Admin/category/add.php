
<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Xử lý khi người dùng nhấn nút "Add Category"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);

    // Kiểm tra nếu tên danh mục đã tồn tại
    $check_category_sql = "SELECT * FROM categories WHERE category_name = ?";
    $stmt = $mysqli->prepare($check_category_sql);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color: red;'>Category already exists. Please use a different name.</p>";
    } else {
        // Thêm danh mục mới vào cơ sở dữ liệu
        $insert_sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $mysqli->prepare($insert_sql);
        $stmt->bind_param("s", $category_name);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Category added successfully!</p>";
            header('Location: add.php'); // Chuyển hướng về trang thêm danh mục
            exit();
        } else {
            echo "<p style='color: red;'>Failed to add category. Please try again.</p>";
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
    <title>Add New Item</title>
    
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
                    <a class="navbar-brand" href="index.php">Admin Dashboard</a>
                </div>
            </nav>
        </header>
        
        <!-- Page Content -->
        <div class="container">
        <h2>Add New Category</h2>
        <form method="POST" action="data_processing.php">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
            </div>
            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
            <a href="./index.php" class="btn btn-secondary">Cancel</a>
        </form>
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