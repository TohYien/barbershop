<?php
require_once '../connection.php';
session_start();
//GET PRODUCT ID FROM THE URL

$id = $_GET['id'];

$img_query = "SELECT image FROM services WHERE service_id = $id";
$result = mysqli_query($cn, $img_query);
$img_path = mysqli_fetch_assoc($result);


// delete the product
$query = "DELETE FROM services WHERE service_id = $id;";


//also delete the image inside the public folder
//check if image exists
$file_path = "../..".$img_path['image'];
if(file_exists($file_path)) {
    unlink($file_path);
} else {
    echo "File does not exist";
    die();
}


if(!$_SESSION['customers_info']['isAdmin']) {
    echo "Youre not allowed to delete this product";
    echo "<a href='/'>Go back to homepage</a>";
}

mysqli_query($cn, $query);
header("Location: $_SERVER[HTTP_REFERER]");