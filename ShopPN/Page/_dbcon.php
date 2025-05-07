<?php
$mysqli = new mysqli("localhost","root","","shop_noithat","3306");
if ($mysqli->connect_errno) {
    echo "Kết nối MYSQLi lỗi" . $mysqli->connect_error;
    exit();
  }
  $connect=mysqli_connect("localhost","root","","shop_noithat") or die(mysqli_error($connection))
    or die("Error");
  $getMesg = mysqli_real_escape_string($connect, $_POST['text']);
//checking user query to database query
$check_data = "SELECT replies FROM chatbot WHERE queries LIKE '%$getMesg%'";
$run_query = mysqli_query($connect, $check_data) or die("Error");
// if user query matched to database query we'll show the reply otherwise it go to else statement
if(mysqli_num_rows($run_query) > 0){
    //fetching replay from the database according to the user query
    $fetch_data = mysqli_fetch_assoc($run_query);
    //storing replay to a varible which we'll send to ajax
    $replay = $fetch_data['replies'];
    echo $replay;
}else{
    echo "Sorry can't be able to understand you!";
}

?>