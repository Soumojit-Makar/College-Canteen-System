<?php
const HOST = "sql209.infinityfree.com";
const USERNAME = "if0_38816580";
const PASSWORD = "Soumojit12";
const DATABASE = "if0_38816580_catering";

$conn = mysqli_connect(HOST, USERNAME, PASSWORD);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS " . DATABASE;
if (!mysqli_query($conn, $sql)) {
    die("Error creating database: " . mysqli_error($conn));
}

mysqli_select_db($conn, DATABASE);
?>
