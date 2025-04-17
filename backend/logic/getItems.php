<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../config.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $search = $_POST['search'] ?? null;

    if ($search === null || trim($search) === '') {
        $sql = "SELECT * FROM `item`";
    } else {
        $search = mysqli_real_escape_string($conn, $search);
        $sql = "SELECT * FROM `item` WHERE `item_name` LIKE '%$search%' ";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result)) {
            $array = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo json_encode($array);
        } else {
            echo json_encode(["success" => false, "message" => "No matching items found."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
    }
}
?>