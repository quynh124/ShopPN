<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Kiểm tra nếu `order_id` tồn tại trong URL
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    $sql = "SELECT * FROM orders WHERE order_id = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Order not found.";
        exit();
    }
} else {
    echo "Order ID is missing or invalid.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edit Order</h2>
        <form method="POST" action="data_processing.php">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($row['order_id']); ?>">

            <div class="form-group">
                <label for="name"> Name</label>
                <input type="text"  class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email"  class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text"  class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="Credit Card" <?php echo $row['payment_method'] === 'Credit Card' ? 'selected' : ''; ?>>Credit Card</option>
                    <option value="PayPal" <?php echo $row['payment_method'] === 'PayPal' ? 'selected' : ''; ?>>PayPal</option>
                    <option value="Cash on Delivery" <?php echo $row['payment_method'] === 'Cash on Delivery' ? 'selected' : ''; ?>>Cash on Delivery</option>
                </select>
            </div>

            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" value="<?php echo htmlspecialchars($row['total_price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="final_price">Final Price</label>
                <input type="number" step="0.01" class="form-control" id="final_price" name="final_price" value="<?php echo htmlspecialchars($row['final_price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="discount_amount">Discount Amount</label>
                <input type="number" step="0.01" class="form-control" id="discount_amount" name="discount_amount" value="<?php echo htmlspecialchars($row['discount_amount']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Order Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending" <?php echo $row['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Processing" <?php echo $row['status'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="Completed" <?php echo $row['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo $row['status'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <button type="submit" name="update_order" class="btn btn-primary">Update Order</button>
            <a href="../manage_checkout.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>