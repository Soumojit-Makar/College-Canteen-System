<?php
include '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = "user";

    if (empty($fullname) || empty($phone) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$conn) {
        echo json_encode(["success" => false, "message" => "Database connection failed."]);
        exit;
    }

    $find = "SELECT * FROM `users` WHERE `phone`='$phone'";
    $result = mysqli_query($conn, $find);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["success" => false, "message" => "This Phone Number is already present!"]);
    } else {
        $sql = "INSERT INTO `users` (`name`, `phone`, `password`, `role`) VALUES ('$fullname', '$phone', '$password', '$role')";
        $result2 = mysqli_query($conn, $sql);

        if ($result2) {
            echo json_encode(["success" => true, "message" => "Signed up successfully! Now Login!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Sign up not successful retry !"]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>