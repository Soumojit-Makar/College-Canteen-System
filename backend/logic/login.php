<?php
session_start();
include '../config.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($phone) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Phone and Password are required."]);
        exit;
    }

    if (!$conn) {
        echo json_encode(["success" => false, "message" => "Database connection failed."]);
        exit;
    }

    $query = "SELECT * FROM `users` WHERE `phone` = '$phone'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if ($password=== $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_phone'] = $user['phone'];
            $_SESSION['user_role'] = $user['role'];
            $expiry = time() + (7 * 24 * 60 * 60);
            setcookie("user_id", $user['user_id'], $expiry, "/");
            setcookie("user_name", $user['name'], $expiry, "/");
            setcookie("user_role", $user['role'], $expiry, "/");

            echo json_encode(
                [
                    "success" => true,
                    "message" => "Login successful!",
                    "user" => [
                        "id" => $user['user_id'],
                        "name" => $user['phone'],
                        "role" => $user['role']
                    ]
                ]
            );
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password. "]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Phone number not registered."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>