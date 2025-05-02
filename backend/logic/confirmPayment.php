<?php
include '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && is_numeric($_POST['userId'])) {
    $userId = (int)$_POST['userId'];

    $sql = "UPDATE bills 
            SET status = 'COMPLETED', payment_status = 'PAID' 
            WHERE user_id = $userId AND status = 'PENDING'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing userId']);
}
?>
