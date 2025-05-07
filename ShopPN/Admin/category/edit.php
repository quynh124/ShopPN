<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Kiểm tra nếu `categoryid` tồn tại trong URL
if (isset($_GET['categoryid']) && is_numeric($_GET['categoryid'])) {
    $category_id = intval($_GET['categoryid']);
    $sql = "SELECT * FROM categories WHERE category_id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "Category not found.";
        exit();
    }
} else {
    echo "Category ID is missing or invalid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Category</h2>
        <form method="POST" action="data_processing.php?categoryid=<?php echo htmlspecialchars($category['category_id']); ?>">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
            </div>
            <button type="submit" name="suadanhmuc" class="btn btn-primary">Update Category</button>
            <a href="../manage_categories.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>