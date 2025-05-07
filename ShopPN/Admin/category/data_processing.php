<?php
include('../_dbcon.php');

// Lấy dữ liệu từ form
$category_name = isset($_POST['category_name']) ? trim($_POST['category_name']) : null;

// Thêm danh mục mới
if (isset($_POST['themdanhmuc'])) {
    if ($category_name) {
        $sql_them = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $mysqli->prepare($sql_them);
        $stmt->bind_param("s", $category_name);
        $stmt->execute();
        header('Location: ../manage_categories.php?action=category&query=add');
    } else {
        echo "Category name is required.";
    }
}

// Sửa danh mục
elseif (isset($_POST['suadanhmuc'])) {
    $category_id = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : null;

    if ($category_id && $category_name) {
        $sql_update = "UPDATE categories SET category_name = ? WHERE category_id = ?";
        $stmt = $mysqli->prepare($sql_update);
        $stmt->bind_param("si", $category_name, $category_id);
        $stmt->execute();
        header('Location: ../manage_categories.php?action=category&query=edit');
    } else {
        echo "Category ID or name is missing.";
    }
}

// Xóa danh mục
elseif (isset($_GET['categoryid']) && isset($_POST['xoadanhmuc'])) {
    $category_id = intval($_GET['categoryid']);

    if ($category_id) {
        $sql_xoa = "DELETE FROM categories WHERE category_id = ?";
        $stmt = $mysqli->prepare($sql_xoa);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        header('Location: ../manage_categories.php?action=category&query=delete');
    } else {
        echo "Category ID is missing.";
    }
} else {
    echo "Invalid action.";
}
?>