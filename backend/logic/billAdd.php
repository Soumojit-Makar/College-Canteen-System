<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data['items']) || !is_array($data['items']) ||
    !isset($data['totalItems']) || !isset($data['totalAmount']) ||
    !isset($data['paymentMethod']) || trim($data['paymentMethod']) === ''
) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated']);
    exit;
}

$userId = (int)$_SESSION['user_id'];
$totalItems = (int)$data['totalItems'];
$totalAmount = (float)$data['totalAmount'];
$paymentMethod = mysqli_real_escape_string($conn, $data['paymentMethod']);
$status = mysqli_real_escape_string($conn, $data['status'] ?? 'PENDING');
$paymentStatus = mysqli_real_escape_string($conn, $data['paymentStatus'] ?? 'PENDING');

mysqli_begin_transaction($conn);

try {
    $billQuery = "INSERT INTO `bills` (`user_id`, `total_items`, `total_amount`, `payment_method`, `status`, `payment_status`, `created_at`)
                  VALUES ($userId, $totalItems, $totalAmount, '$paymentMethod', '$status', '$paymentStatus', NOW())";

    if (!mysqli_query($conn, $billQuery)) {
        throw new Exception("Failed to insert bill: " . mysqli_error($conn));
    }

    $billId = mysqli_insert_id($conn);

    foreach ($data['items'] as $item) {
        $itemId = (int)$item['id'];
        $itemName = mysqli_real_escape_string($conn, $item['name']);
        $quantity = (int)$item['count'];
        $price = (float)$item['price'];
        $totalPrice = (float)$item['totalPrice'];

        $stockQuery = "SELECT `item_quantity` FROM `item` WHERE `item_id` = $itemId FOR UPDATE";
        $stockResult = mysqli_query($conn, $stockQuery);
        if (!$stockResult || mysqli_num_rows($stockResult) === 0) {
            throw new Exception("Item not found or error: " . mysqli_error($conn));
        }

        $stockRow = mysqli_fetch_assoc($stockResult);
        $currentStock = (int)$stockRow['item_quantity'];
        $updatedStock = $currentStock - $quantity;

        if ($updatedStock < 0) {
            throw new Exception("Not enough stock for item ID: $itemId");
        }

        $updateStockQuery = "UPDATE `item` SET `item_quantity` = $updatedStock WHERE `item_id` = $itemId";
        if (!mysqli_query($conn, $updateStockQuery)) {
            throw new Exception("Failed to update stock: " . mysqli_error($conn));
        }

        $itemQuery = "INSERT INTO `bill_items` (`bill_id`, `item_id`, `item_name`, `quantity`, `price`, `total_price`)
                      VALUES ($billId, $itemId, '$itemName', $quantity, $price, $totalPrice)";

        if (!mysqli_query($conn, $itemQuery)) {
            throw new Exception("Failed to insert bill item: " . mysqli_error($conn));
        }
    }

    mysqli_commit($conn);

    echo json_encode([
        'success' => true,
        'message' => 'Billing successfully saved',
        'bill_id' => $billId,
        'user_id' => $userId,
        'status' => $status
    ]);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
