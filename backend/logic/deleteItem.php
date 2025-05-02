<?php
include '../config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$itemId = $_POST['id'] ?? '';

if (!$itemId) {
    echo json_encode(['success' => false, 'message' => 'Item ID is required']);
    exit;
}

$getImageQuery = "SELECT product_image FROM `item` WHERE `item_id` = '$itemId'";
$imageResult = mysqli_query($conn, $getImageQuery);

if ($imageResult && mysqli_num_rows($imageResult) > 0) {
    $row = mysqli_fetch_assoc($imageResult);
    $imageFile = $row['product_image'];
    $imagePath = '../../views/images/' . $imageFile;
    $deleteQuery = "DELETE FROM `item` WHERE `item_id` = '$itemId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        echo json_encode(['success' => true, 'message' => 'Item deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete item from database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Item not found']);
}
?>
