<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'product_crud';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>