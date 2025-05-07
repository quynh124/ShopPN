<?php
require 'connect.php'; 
session_start();
// Kiểm tra nếu `product_id` được truyền qua URL
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // Truy vấn thông tin sản phẩm
    $sql_get_product = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $mysqli->prepare($sql_get_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu sản phẩm tồn tại
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

// Xử lý thêm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Kiểm tra nếu giỏ hàng chưa tồn tại
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += 1; // Tăng số lượng nếu sản phẩm đã tồn tại
            $product_exists = true;
            break;
        }
    }
    // Nếu sản phẩm chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
    if (!$product_exists) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        ];
    }
    header('Location: cart.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .product-detail img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .product-info {
            flex: 1;
        }

        .product-info h2 {
            margin-bottom: 20px;
        }

        .product-info p {
            margin-bottom: 10px;
        }

        .product-info .price {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .product-info .btn {
            margin-top: 20px;
        }

        .product-description {
            margin-top: 40px;
        }

        .product-description h3 {
            margin-bottom: 20px;
        }

        .product-description p {
            line-height: 1.6;
        }
    </style>
</head>
<body>
<?php 
   include_once 'header.php'; 
   ?>
    <div class="container">
        <h1>Product Detail</h1>
        <div class="product-detail">
            <div class="col-md-6">
                <img src="./image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-info col-md-6">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" required>
            <small>Available stock: <?php echo htmlspecialchars($product['stock']); ?></small>
                <form method="POST" action="">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                </form>
                <button id="share-btn" type="button" class="btn btn-primary">Share</button>
            </div>
        </div>

        <!-- Mô tả chi tiết sản phẩm -->
        <div class="product-description">
            <h3>Product Description</h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
   document.addEventListener('DOMContentLoaded', () => {
    const shareBtn = document.getElementById('share-btn');
    if (navigator.share) {
        shareBtn.addEventListener('click', async () => {
            try {
                await navigator.share({
                    title: 'Sản phẩm này hay lắm!',
                    text: 'Check out this amazing product!',
                    url: 'http://localhost/Funori-main/Page/product_detail.php?product_id=<?php echo $product['product_id']; ?>',
                });
                console.log('Product shared successfully!');
            } catch (err) {
                console.error('Error sharing:', err);
            }
        });
    } else {
        shareBtn.addEventListener('click', () => {
            const shareUrl = 'http://localhost/Funori-main/Page/product_detail.php?product_id=<?php echo $product['product_id']; ?>';
            navigator.clipboard.writeText(shareUrl).then(() => {
                alert('URL copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy URL:', err);
            });
        });
    }
});
</script>
</body>
</html>