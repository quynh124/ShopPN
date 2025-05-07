<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Kiểm tra nếu `product_id` tồn tại trong URL
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $sql = "SELECT * FROM products WHERE product_id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Product ID is missing or invalid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="POST" action="data_processing.php" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <small>Leave blank if you don't want to change the image.</small>
            </div>

            <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
            <a href="../manage_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>