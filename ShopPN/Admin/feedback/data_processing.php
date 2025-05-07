<?php
include('../_dbcon.php');
$category_name = $_POST['category_name'];
$create = $_POST['create'];
if (isset($_POST['themdanhmuc'])) {
    $sql_them = " INSERT INTO categories (category_name, created_at) VALUE('" . $category_name . "','" . $create . "')";
    mysqli_query($mysqli, $sql_them);
    header('Location:../manage_categories.php?action=category&query=add');
} elseif (isset($_POST['suadanhmuc'])) {
    $sql_update = " UPDATE categories SET category_name='".$category_name."',created_at='".$create."' WHERE category_id='$_GET[categoryid]' ";
    mysqli_query($mysqli, $sql_update);
    header('Location:../manage_categories.php?action=category&query=add');
} else {
    $id = $_GET['categoryid'];
    $sql_xoa = "DELETE from categories where category_id='" . $id . "'";
    mysqli_query($mysqli, $sql_xoa);
    header('Location:../manage_categories.php?action=category&query=add');
}
?>