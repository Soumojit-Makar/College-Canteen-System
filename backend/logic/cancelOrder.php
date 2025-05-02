<?php
include '../config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['billId']) && is_numeric($_POST['billId'])) {
    $billId = (int)$_POST['billId'];

    $sql = "UPDATE bills 
            SET status = 'CANCELLED', payment_status = 'CANCELLED' 
            WHERE bill_id = $billId AND status = 'PENDING'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing billId']);
}
?>
