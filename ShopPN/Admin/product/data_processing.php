
<!-- //include('../_dbcon.php');
//$name = $_POST['name'];
//$create = $_POST['create'];
//if (isset($_POST['themsanpham'])) {
 //   $sql_them = " INSERT INTO product (name, description,pri) VALUE('" . $category_name . "','" . $create . "')";
 //   mysqli_query($mysqli, $sql_them);
 //   header('Location:../manage_categories.php?action=category&query=add');
//} elseif (isset($_POST['suadanhmuc'])) {
  //  $sql_update = " UPDATE categories SET category_name='".$category_name."',created_at='".$create."' WHERE category_id='$_GET[categoryid]' ";
  //  mysqli_query($mysqli, $sql_update);
 //   header('Location:../manage_categories.php?action=category&query=add');
//} else {
   // $id = $_GET['categoryid'];
   // $sql_xoa = "DELETE from categories where category_id='" . $id . "'";
  //  mysqli_query($mysqli, $sql_xoa);
    //header('Location:../manage_categories.php?action=category&query=add');
//} -->

<?php
session_start();

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "shop_noithat");

if ($mysqli->connect_errno) {
    echo "Kết nối MySQLi lỗi: " . $mysqli->connect_error;
    exit();
}

// Lấy dữ liệu từ form
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$category_id = $_POST['category_id'];
$image = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];

// Xử lý khi người dùng nhấn nút "Add Product"
if (isset($_POST['themsanpham'])) {
    // Thêm sản phẩm mới vào cơ sở dữ liệu
    $sql_them = "INSERT INTO products (category_id, name, description, price, stock, image) 
                 VALUES ('$category_id', '$name', '$description', '$price', '$stock', '$image')";
    if (mysqli_query($mysqli, $sql_them)) {
        move_uploaded_file($image_tmp, 'upload/' . $image);
        header('Location: ../manage_product.php?action=product&query=add');
    } else {
        echo "Failed to add product.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Kiểm tra nếu thiếu dữ liệu
    if (!$product_id || !$name || !$description || !$price || !$stock) {
        echo "<p style='color: red;'>Product ID or required fields are missing.</p>";
        exit();
    }

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    if (!empty($image)) {
        // Nếu có ảnh mới, cập nhật cả ảnh
        move_uploaded_file($image_tmp, "../uploads/products/" . $image);
        $sql_update = "UPDATE products 
                       SET name = ?, description = ?, price = ?, stock = ?, image = ? 
                       WHERE product_id = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("ssdssi", $name, $description, $price, $stock, $image, $product_id);
    } else {
        // Nếu không có ảnh mới, chỉ cập nhật các trường khác
        $sql_update = "UPDATE products 
                       SET name = ?, description = ?, price = ?, stock = ? 
                       WHERE product_id = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param("ssdsi", $name, $description, $price, $stock, $product_id);
    }

    if ($stmt_update->execute()) {
        echo "<p style='color: green;'>Product updated successfully!</p>";
        header('Location: ../manage_product.php'); // Chuyển hướng về trang quản lý sản phẩm
        exit();
    } else {
        echo "<p style='color: red;'>Failed to update product. Please try again.</p>";
    }}if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
    
        // Lấy thông tin sản phẩm để xóa hình ảnh
        $sql = "SELECT * FROM products WHERE product_id = '$product_id' LIMIT 1";
        $query = mysqli_query($mysqli, $sql);
    
        while ($row = mysqli_fetch_array($query)) {
            // Xóa ảnh sản phẩm
            if (!empty($row['image']) && file_exists('upload/' . $row['image'])) {
                unlink('upload/' . $row['image']);
            }
        }
    
        // Xóa sản phẩm
        $sql_delete = "DELETE FROM products WHERE product_id = '$product_id'";
        mysqli_query($mysqli, $sql_delete);
    
        // Chuyển hướng sau khi xóa
        header('Location:../manage_product.php?action=product&query=add');
        exit();
    } else {
        echo "Không tìm thấy product_id.";
    }
?>
<!-- 
include('../_dbcon.php');
$product_id = $_POST['product_id'];
$category_id = $_POST['category_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
// $quantity = $_POST['quantity'];
$stock = $_POST['stock'];
$image= $_FILES['image']['name'];

//xuly hinh anh


if (isset($_POST['themsanpham'])) {
    //them
    $sql_them = " INSERT INTO products(product_id,category_id,name,description,price,stock,image) VALUE('" . $product_id . "','" . $category_id . "','" . $name . "','" . $description . "','" . $price . "','" . $stock . "','" . $image . "')";
    mysqli_query($mysqli, $sql_them);
    move_uploaded_file($image_tmp,'upload/'.$image);
    header('Location:../manage_product.php?action=product&query=add');
} elseif (isset($_POST['suasanpham'])) {

    if($hinhanh!=''){
           move_uploaded_file($image_tmp,'upload/'.$hinhanh);
           $sql = "SELECT * from products where product_id='$_GET[productid]'  LIMIT 1";

$query = mysqli_query($mysqli,$sql);
   while($row = mysqli_fetch_array($query)){
    unlink('upload/'.$row['image']);
   }  
     $sql_update = " UPDATE product SET product_id='" . $product_id . "',category_id='" . $category_id . "',name='" . $name . "',description='" . $description . "',price='" . $price . "',stock='" . $stock . "',image='" . $image . "' WHERE product_id'$_GET[productid]' ";

}else{
    $sql_update = " UPDATE product SET product_id='" . $product_id . "',category_id='" . $category_id . "',name='" . $name . "',description='" . $description . "',price='" . $price . "',stock='" . $stock . "',image='" . $image . "' WHERE product_id'$_GET[productid]' ";
}
    mysqli_query($mysqli, $sql_update);
    header('Location:../manage_product.php?action=product&query=add');
} else {

     $id = $_GET['productid'];
    $sql = "SELECT * from products where product_id= '$product_id' LIMIT 1";
   $query = mysqli_query($mysqli,$sql);
   while($row = mysqli_fetch_array($query)){
    unlink('upload/'.$row['image']);
   }
    $sql_xoa = "DELETE from products where product_id='" . $product_id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../manage_product.php?action=product&query=add');
} -->
