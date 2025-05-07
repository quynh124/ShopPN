<?php
require 'connect.php'; 
session_start();

// Kiểm tra nếu giỏ hàng trống
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
  header('Location: cart.php');
  exit();
}

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
  echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
  exit();
}
// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_email'])) {
  header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
  exit();
}

// Lấy thông tin người dùng từ cơ sở dữ liệu
$email = $_SESSION['user_email'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
} else {
  echo "User not found.";
  exit();
}

$discount_percent = 0; // Phần trăm giảm giá mặc định
$total_price = 0; // Tổng giá trị đơn hàng

// Tính tổng giá trị đơn hàng
foreach ($_SESSION['cart'] as $item) {
  $total_price += $item['product_price'] * $item['quantity'];
}

// Xử lý mã giảm giá
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['discount_code'])) {
  $entered_code = strtoupper(trim($_POST['discount_code'])); // Lấy mã giảm giá từ form
  $current_date = date('Y-m-d'); // Ngày hiện tại

  // Truy vấn mã giảm giá từ bảng coupons
  $coupon_query = "SELECT * FROM coupons WHERE code = ? AND expiration_date >= ?";
  $stmt = $mysqli->prepare($coupon_query);
  $stmt->bind_param("ss", $entered_code, $current_date);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $coupon = $result->fetch_assoc();
    $discount_percent = $coupon['discount'];
  } else {
    $error_message = "Invalid or expired discount code.";
  }
}

// Tính tổng giá trị sau khi áp dụng giảm giá
$discount_amount = ($total_price * $discount_percent) / 100;
$final_price = $total_price - $discount_amount;

// Xử lý khi nhấn nút "Place Order"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
     // Lấy user_id từ session
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $payment_method = trim($_POST['payment_method']);
    $total_price = floatval($_POST['total_price']);
    $name = trim($_POST['product_id']);
    $image = trim($_POST['image']);

    // Thêm đơn hàng vào bảng `orders`
    $sql = "INSERT INTO orders ( total_price, product_name, product_image, name, email, address, payment_method) 
            VALUES ( ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("dssssss",  $total_price, $product_name, $product_image, $name, $email, $address, $payment_method);

    if ($stmt->execute()) {
        echo "<p>Order placed successfully!</p>";
        header("Location: thank_you.php");
        exit();
    } else {
        echo "<p style='color: red;'>Failed to place order. Please try again.</p>";
    }
}

// Lưu lại dữ liệu đã nhập vào các trường
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
$payment = isset($_POST['payment']) ? htmlspecialchars($_POST['payment']) : '';
$discount_code = isset($_POST['discount_code']) ? htmlspecialchars($_POST['discount_code']) : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
  <link rel="stylesheet" href="../Css/search.css">
  <style>
    body {
      font-family: Arial;
      font-size: 17px;
      padding: 8px;
    }

    * {
      box-sizing: border-box;
    }

    .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin: 0 -16px;
    }

    .col-25 {
      -ms-flex: 25%;
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%;
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%;
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text] {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: #bb9c87;
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: #bb9c87;
    }

    a {
      color: #2196F3;
    }

    hr {
      border: 1px solid lightgrey;
    }

    span.price {
      float: right;
      color: grey;
    }

    /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
      }

      .col-25 {
        margin-bottom: 20px;
      }
    }
  </style>
  <style>
    .cart-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .cart-item-image {
      width: 50px;
      height: 50px;
      object-fit: cover;
      margin-right: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .cart-item p {
      margin: 0;
      flex-grow: 1;
    }

    .price {
      float: right;
      font-weight: bold;
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
                        <a href="logout.php" class="btn btn-danger" style="height: 40px;width: 76.13334px;">Logout</a>
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
  <div class="container">
    <h2>Checkout</h2>
    <div class="row">
      <div class="col-75">
        <div class="container">
          <form method="POST" action="checkout.php">
          <input type="hidden" name="name" value="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : ''; ?>">
          <input type="hidden" name="image" value="<?php echo isset($product['image']) ? htmlspecialchars($product['image']) : ''; ?>">
            <div class="form-group">
              <label for="fullname">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname"
                value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input style="width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 3px;"
                type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea style="width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 3px;"
                class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>
            <div class="form-group">
              <label for="payment">Payment Method</label>
              <select style="width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 3px;"
                class="form-control" id="payment" name="payment" required>
                <option value="credit_card" <?php echo $payment === 'credit_card' ? 'selected' : ''; ?>>Credit Card
                </option>
                <option value="paypal" <?php echo $payment === 'paypal' ? 'selected' : ''; ?>>PayPal</option>
                <option value="cash_on_delivery" <?php echo $payment === 'cash_on_delivery' ? 'selected' : ''; ?>>Cash on
                  Delivery</option>
              </select>
            </div>
            <div class="form-group">
              <label for="discount_code">Discount Code</label>
              <input type="text" class="form-control" id="discount_code" name="discount_code"
                value="<?php echo $discount_code; ?>" placeholder="Enter discount code">
              <?php if (!empty($error_message)) { ?>
                <small class="text-danger"><?php echo $error_message; ?></small>
              <?php } ?>
            </div>
            <button type="submit" name="apply_discount" class="btn btn-primary btn-lg">Apply Discount</button>
            <button type="submit" name="place_order" class="btn btn-success btn-lg">Place Order</button>
          </form>
        </div>
      </div>
      <div class="col-25">
        <div class="container">
          <h4>Cart <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i>
              <b><?php echo count($_SESSION['cart']); ?></b></span></h4>
          <?php
          foreach ($_SESSION['cart'] as $item) {
            $item_total = $item['product_price'] * $item['quantity'];
            ?>
            <p>
              <a href="#"><?php echo htmlspecialchars($item['product_name']); ?></a>
              <span class="price">$<?php echo number_format($item_total, 2); ?></span>
            </p>
            <?php
          }
          ?>
          <hr>
          <p>Subtotal <span class="price">$<?php echo number_format($total_price, 2); ?></span></p>
          <p>Discount (<?php echo $discount_percent; ?>%) <span
              class="price">-$<?php echo number_format($discount_amount, 2); ?></span></p>
          <hr>
          <p>Total <span class="price" style="color:black"><b>$<?php echo number_format($final_price, 2); ?></b></span>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
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

    recognition.onresult = function(event) {
        const voiceResult = event.results[0][0].transcript;
        document.getElementById("searchInput").value = voiceResult;
        document.querySelector("form.search-form").submit();
    };

    recognition.onerror = function(event) {
        console.error("Lỗi khi nhận diện giọng nói: ", event.error);
    };
}
</script>
</body>

</html>