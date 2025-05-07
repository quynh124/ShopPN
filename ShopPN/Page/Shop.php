<?php
require 'connect.php'; 
session_start();
// ====== Thêm vào giỏ hàng =======
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += 1;
            $product_exists = true;
            break;
        }
    }
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

// Số sản phẩm trên mỗi trang
$products_per_page = 12;
// Xác định trang hiện tại
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($current_page < 1) {
    $current_page = 1;
}
// Tính toán OFFSET
$offset = ($current_page - 1) * $products_per_page;

// Truy vấn tổng số sản phẩm
$total_products_query = "SELECT COUNT(*) AS total FROM products";
$total_products_result = $mysqli->query($total_products_query);
$total_products_row = $total_products_result->fetch_assoc();
$total_products = $total_products_row['total'];

// Tính tổng số trang
$total_pages = ceil($total_products / $products_per_page);

// Truy vấn sản phẩm cho trang hiện tại
$sql = "SELECT * FROM products LIMIT ? OFFSET ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $products_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Nếu có từ khóa tìm kiếm
if (!empty($search)) {
    $search_term = '%' . $search . '%';

    $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ? LIMIT ?, ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssii", $search_term, $search_term, $offset, $products_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    // Đếm tổng sản phẩm cho tìm kiếm
    $count_stmt = $mysqli->prepare("SELECT COUNT(*) AS total FROM products WHERE name LIKE ? OR description LIKE ?");
    $count_stmt->bind_param("ss", $search_term, $search_term);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_row = $count_result->fetch_assoc();
    $total_products = $total_row['total'];
} else {
    // Không tìm kiếm, lấy toàn bộ
    $stmt = $mysqli->prepare("SELECT * FROM products LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $products_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_products_query = "SELECT COUNT(*) AS total FROM products";
    $total_products_result = $mysqli->query($total_products_query);
    $total_products_row = $total_products_result->fetch_assoc();
    $total_products = $total_products_row['total'];
}

$total_pages = ceil($total_products / $products_per_page);

$sql_categories = "
    SELECT category_id, 
           (SELECT name FROM categories WHERE categories.category_id = products.category_id) as category_name,
           COUNT(*) as price
    FROM products
    GROUP BY category_id";
$result_categories = mysqli_query($mysqli, $sql_categories);

// Lấy giá trị giới hạn giá từ URL hoặc đặt mặc định là 1000
$price_limit = isset($_GET['price_range']) ? (int) $_GET['price_range'] : 1000;

// Truy vấn sản phẩm dựa trên giới hạn giá
$sql = "SELECT * FROM products WHERE price <= $price_limit";
$result = mysqli_query($mysqli, $sql);
$price_limit = isset($_GET['price_range']) ? (int) $_GET['price_range'] : 1000;
$sql = "SELECT * FROM products WHERE price <= $price_limit";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Css/search.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .pic-product-1 img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-card h4 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .product-card .btn {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 25px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .product-card .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .product-card .btn-primary:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .product-card .btn[disabled] {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-md-3 {
            flex: 0 0 23%;
            max-width: 23%;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .col-md-3 {
                flex: 0 0 48%;
                max-width: 48%;
            }
        }

        @media (max-width: 576px) {
            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
            pointer-events: none;
        }

        .pagination a.disabled {
            color: #ccc;
            pointer-events: none;
            border-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="content">
            <div class="box-menu-mobile">
                <button>
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
            <nav class="box-menu">
                <ul class="all-list-menu">
                    <li>
                        <a href="../index.php" class="hover-a">Home</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="Shop.php" class="hover-a">Shop</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="about.php" class="hover-a">About Us</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="blog.php" class="hover-a">Blog</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="contact.php" class="hover-a">Contact</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="profile-page.php" class="hover-a">Profile</a>
                    </li>
                    <li class="padding-list-menu">
                        <a href="chatbot.php" class="hover-a">ChatBot</a>
                    </li>
                </ul>
            </nav>
            <div class="box-logo">
                <div class="logo">
                    <a href="../index.php">
                        <img src="../plugins/images/logo.png" alt="" style="width: 150px;height: 100px;">
                    </a>
                </div>
            </div>
            <div class="box-icon">
                <div class="box-search">
                    <form method="GET" action="Shop.php" class="search-form">
                        <button type="submit" class="search__button">
                            <div class="search__icon">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                        </button>
                        <input type="text" name="search" id="searchInput" class="search__input" placeholder="Search...">
                        <button type="button" onclick="startVoiceSearch()" class="mic__button">
                            <div class="mic__icon">
                                🎤
                            </div>
                        </button>
                    </form>
                </div>
                <a href="login.php" class="box-user" style="padding-top: 10px;">
                    <i class="fa-regular fa-user user"></i>
                    <?php if (isset($_SESSION['user_email'])): ?>
                        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</p>
                        <a href="logout.php" class="btn btn-danger" style="height: 40px;">Logout</a>
                    <?php else: ?>
                        <p><a href="login.php" class="btn btn-primar y">Login</a></p>
                    <?php endif; ?>
                </a>

                <a href="" class="box-heart" style="padding-top: 10px;">
                    <i class="fa-regular fa-heart heart"></i>
                </a>
                <a href="cart.php" class="box-cart" style="padding-top: 10px;">
                    <i class="fa-solid fa-cart-shopping cart"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="box-shop">
        <div class="box-sidebar">
            <div class="first-sidebar">
                <div class="title-sidebar">Categories</div>
                <?php while ($row = mysqli_fetch_assoc($result_categories)) { ?>
                    <div class="in-sidebar">
                        <div class="name">
                            <a href="Shop.php?category_id=<?php echo $row['category_id']; ?>">
                                <?php echo htmlspecialchars($row['category_name']); ?>
                            </a>
                        </div>
                        <div class="box-number"><?php echo $row['price']; ?></div>
                    </div>
                <?php } ?>
            </div>
            <div class="box-price">
                <h3>Filter by Price</h3>
                <form method="GET" action="Shop.php">
                    <label for="price_range">Price Range:</label>
                    <input type="range" id="price_range" name="price_range" min="0" max="1000" step="10"
                        value="<?php echo isset($_GET['price_range']) ? $_GET['price_range'] : 500; ?>"
                        oninput="updatePriceDisplay(this.value)">
                    <div class="box-range">
                        Selected Price: <span
                            id="price_display">$<?php echo isset($_GET['price_range']) ? $_GET['price_range'] : 500; ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="box-color">
                <div class="title-box-color">Color</div>
                <div class="list-color">
                    <ul>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: black;"></div>
                                <span class="name-color">Black</span>
                            </div>
                            <div class="text-number">2</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #445162;"></div>
                                <span class="name-color">Blue</span>
                            </div>
                            <div class="text-number">2</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #4B4E43;"></div>
                                <span class="name-color">Green</span>
                            </div>
                            <div class="text-number">1</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #E7DDD1;"></div>
                                <span class="name-color">Highnoon</span>
                            </div>
                            <div class="text-number">1</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #EF5050;"></div>
                                <span class="name-color">Red</span>
                            </div>
                            <div class="text-number">1</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #F9C9BF;"></div>
                                <span class="name-color">Rose</span>
                            </div>
                            <div class="text-number">1</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #DCA489;"></div>
                                <span class="name-color">Sunrise</span>
                            </div>
                            <div class="text-number">1</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #fff; border: 1px solid gray;"></div>
                                <span class="name-color">White</span>
                            </div>
                            <div class="text-number">4</div>
                        </li>
                        <li>
                            <div class="color-name">
                                <div class="in-color" style="background-color: #C69A02;"></div>
                                <span class="name-color">Yellow</span>
                            </div>
                            <div class="text-number">2</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-feature-product">
                <div class="text-feature-product">Feature Product</div>
                <div>
                    <div class="box-product-in">
                        <div class="picture-product-in">
                            <a href="">
                                <img src="../Picture/Shop/products-10-7.jpg" alt="">
                            </a>
                        </div>
                        <div class="box-in-content">
                            <div class="box-star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="title-feature-product">
                                Theo Round Dining Table
                            </div>
                            <div class="price-feature-prod">
                                <del>$80.00</del>
                                <span>$50.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-product-in">
                        <div class="picture-product-in">
                            <a href="">
                                <img src="../Picture/Shop/products-4.jpg" alt="">
                            </a>
                        </div>
                        <div class="box-in-content">
                            <div class="box-star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="title-feature-product">
                                Egg Dining Table
                            </div>
                            <div class="price-feature-prod">
                                <del>$150.00</del>
                                <span>$100.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-product-in" style="border: none;">
                        <div class="picture-product-in">
                            <a href="">
                                <img src="../Picture/Shop/products-16-6.jpg" alt="">
                            </a>
                        </div>
                        <div class="box-in-content">
                            <div class="box-star">
                                <i style="color: rgb(219, 218, 218);" class="fa-solid fa-star"></i>
                                <i style="color: rgb(219, 218, 218);" class="fa-solid fa-star"></i>
                                <i style="color: rgb(219, 218, 218);" class="fa-solid fa-star"></i>
                                <i style="color: rgb(219, 218, 218);" class="fa-solid fa-star"></i>
                                <i style="color: rgb(219, 218, 218);" class="fa-solid fa-star"></i>
                            </div>
                            <div class="title-feature-product">
                                T12 Dining Table - Black
                            </div>
                            <div class="price-feature-prod">
                                <del>$500.00</del>
                                <span>$450.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 0px;width: 1500px;padding-left: 300px;height: 1900px;">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="product-card">
                            <div class="pic-product-1">
                                <a href="product_detail.php?product_id=<?php echo $row['product_id']; ?>">
                                    <img src="./image/<?php echo htmlspecialchars($row['image']); ?>"
                                        alt="<?php echo htmlspecialchars($row['name']); ?>">
                                </a>
                            </div>
                            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                            <p>Stock: <?php echo htmlspecialchars($row['stock']); ?></p>
                            <form method="POST" action="Shop.php">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary" <?php echo $row['stock'] <= 0 ? 'disabled' : ''; ?>>
                                    <?php echo $row['stock'] > 0 ? '<i class="fa fa-shopping-cart"></i> Add to Cart' : '<i class="fa fa-times-circle"></i> Out of Stock'; ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>
    </div>

    </div>
    <div class="pagination" style="padding-top: 80px;">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?>">&laquo; Previous</a>
        <?php else: ?>
            <a class="disabled">&laquo; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo $i === $current_page ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo $current_page + 1; ?>">Next &raquo;</a>
        <?php else: ?>
            <a class="disabled">Next &raquo;</a>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        function updatePriceDisplay(value) {
            document.getElementById('price_display').textContent = `$${value}`;
        }
    </script>
    <script>
        function startVoiceSearch() {
            if (!('webkitSpeechRecognition' in window)) {
                alert("Trình duyệt không hỗ trợ tìm kiếm bằng giọng nói!");
                return;
            }

            const recognition = new webkitSpeechRecognition();
            recognition.lang = "vi-VN";
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.start();

            recognition.onresult = function (event) {
                const voiceResult = event.results[0][0].transcript;
                document.getElementById("searchInput").value = voiceResult;
                document.querySelector("form.search-form").submit();
            };

            recognition.onerror = function (event) {
                console.error("Lỗi khi nhận diện giọng nói: ", event.error);
            };
        }
    </script>
    <script>
        function updatePriceDisplay(val) {
            document.getElementById('price_display').innerText = '$' + val;
        }
    </script>
</body>
</html>