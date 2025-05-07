<?php
require 'connect.php'; 
session_start();
// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_email'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập
    exit();
}
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Xóa sản phẩm khỏi giỏ hàng
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    // Chuyển hướng về trang giỏ hàng
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="../Css/main.css">
    <link rel="stylesheet" href="../Css/main-moblie.css">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/logo.png">
    <link href="../Admin/css/btn.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .cart-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-checkout {
            width: 100%;
            background-color: #bb9c87;
            color: white;
        }

        .btn-checkout:hover {
            background-color: #bb9c87;
        }

        .btn-danger {
            border-radius: 20px;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php
    include_once 'header.php';
    ?>
    <div class="container mt-5">
        <div class="container">
            <h2>Your Cart</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        foreach ($_SESSION['cart'] as $item) {
                            $total = $item['product_price'] * $item['quantity'];
                            ?>
                            <tr>
                                <td><img src="./image/<?php echo htmlspecialchars($item['product_image']); ?>"
                                        alt="<?php echo htmlspecialchars($item['product_name']); ?>" width="50"></td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>$<?php echo htmlspecialchars($item['product_price']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>$<?php echo $total; ?></td>
                                <td>
                                    <a href="cart.php?action=remove&product_id=<?php echo htmlspecialchars($item['product_id']); ?>"
                                        class="Btn">Remove</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="6">Your cart is empty.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <!-- Nút Checkout -->
            <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                <?php if (isset($_SESSION['user_email'])): ?>
                    <div class="text-right">
                        <a href="checkout.php" class="btn btn-success btn-lg">Checkout</a>
                    </div>
                <?php else: ?>
                    <p style="color: red; text-align: right;">You must <a href="login.php">login</a> to proceed to checkout.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Phần footer -->
    <div class="box-first-footer" style="margin-top: 325px;">
        <div class="contact">
            <h2>CONTACT US</h2>
            <div class="in">
                <div>Add :Ninh Kieu ,Can Tho</div>
                <div>Tell : </div>
                <div>HR Fax: </div>
                <div>sales@pn.com</div>
            </div>
        </div>
        <div class="contact">
            <h2>CATEGOIRES</h2>
            <div class="in">
                <a href="">
                    
                </a>
                <a href="">
                    <div>Tables</div>
                </a>
                <a href="">
                    <div>Seating</div>
                </a>
                <a href="">
                    <div>Desks & office </div>
                </a>
                <a href="">
                    <div>Storage</div>
                </a>
                <a href="">
                    <div>Bed & Bath</div>
                </a>
            </div>
        </div>
        <div class="contact">
            <h2>SERVICES</h2>
            <div class="in">
                <a href="">
                    <div>Sale</div>
                </a>
                <a href="">
                    <div>Quick Ship</div>
                </a>
                <a href="">
                    <div>New Designs</div>
                </a>
                <a href="">
                    <div>Accidental Fabric Protection</div>
                </a>
                <a href="">
                   
                </a>
                <a href="">
                    <div>Gift Cards</div>
                </a>
            </div>
        </div>
        <div class="contact">
            <h2>JOIN US</h2>
            <div class="in">
                <div style="margin-bottom: 25px;">Enter your email below to be the first to know 
                    <br>
                    about new collections and product launches.
                </div>
                <div class="box-email">
                    <input type="text" placeholder="Email adress...">
                    <button type="submit">
                        <i class="fa-solid fa-envelope"></i>
                    </button>
                </div>
                <div class="icon-contact">
                    <ul>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-dribbble"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fa-brands fa-behance"></i>
                            </a>
                        </li>                     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="box-second-footer">
        <div class="first-box">
            <div class="title">
                Shop Nội Thất PN
            </div>
        </div>
        <div class="second-box">
            <div class="box-bank">
                <img src="../Picture/payments-1.png" alt="">
            </div>
        </div>
    </div>
    <!-- End Phần footer -->

    <script>
        $(document).ready(function () {
            function updateTotal() {
                let total = 0;
                $("#cart-items tr").each(function () {
                    let price = parseFloat($(this).find("td:nth-child(2)").text().replace("$", ""));
                    let qty = $(this).find(".quantity").val();
                    let itemTotal = price * qty;
                    $(this).find(".total-price").text("$" + itemTotal.toFixed(2));
                    total += itemTotal;
                });
                $("#cart-total").text("$" + total.toFixed(2));
            }

            $(".quantity").on("change", function () {
                updateTotal();
            });

            $(".remove-item").on("click", function () {
                $(this).closest("tr").remove();
                updateTotal();
            });
        });
    </script>
</body>
</html>