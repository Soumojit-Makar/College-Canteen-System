<?php
session_start();
include '../config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

$sql = "SELECT * FROM `bills` WHERE `user_id` = '$user_id' ORDER BY `created_at` DESC";
$result = mysqli_query($conn, $sql);

$orderReport = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($bill = mysqli_fetch_assoc($result)) {
        $bill_id = $bill['bill_id'];
        $item_sql = "SELECT `item_name`, `quantity`, `price` FROM `bill_items` WHERE `bill_id` = '$bill_id' ";
        $item_result = mysqli_query($conn, $item_sql);

        $billDetails = [];
        if ($item_result && mysqli_num_rows($item_result) > 0) {
            while ($item = mysqli_fetch_assoc($item_result)) {
                $billDetails[] = [
                    "item" => $item['item_name'],
                    "quantity" => (int)$item['quantity'],
                    "price" => (float)$item['price']
                ];
            }
        }

        $orderReport[] = [
            "billId" => (int)$bill['bill_id'],
            "billDate" => date("Y-m-d", strtotime($bill['created_at'])),
            "billAmount" => (float)$bill['total_amount'],
            "billPaymentStatus" => $bill['payment_status'],
            "billStatus" => $bill['status'],
            "billDetails" => $billDetails
        ];
    }
    echo json_encode($orderReport, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["success" => false, "message" => "No orders found."]);
}
?>
