<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}?>
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
    <title>Add Product</title>
    <!-- ===== Bootstrap CSS ===== -->
    <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- ===== Plugin CSS ===== -->
    <link href="../css/animate.css" rel="stylesheet">
    <!-- ===== Custom CSS ===== -->
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST" action="data_processing.php" enctype="multipart/form-data">
    <div class="form-group">
        <label for="category_id">Category</label>
        <select class="form-control" id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            <?php
            // Lấy danh sách danh mục từ bảng categories
            $sql_categories = "SELECT * FROM categories";
            $result_categories = mysqli_query($mysqli, $sql_categories);
            while ($category = mysqli_fetch_assoc($result_categories)) {
                echo "<option value='" . htmlspecialchars($category['category_id']) . "'>" . htmlspecialchars($category['category_name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter product description" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter product price" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter product stock" required>
    </div>
    <div class="form-group">
        <label for="image">Product Image</label>
        <input type="file" class="form-control" id="image" name="image" required>
    </div>
    <button type="submit" name="themsanpham" class="btn btn-primary">Add Product</button>
</form>
    </div>
</body>
</html>