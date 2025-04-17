<?php
include '../config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? '';
$quantity = $_POST['quentity'] ?? '';

if (!$name || !$price || !$quantity || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Setup image upload
$uploadDir = '../../views/images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$image = $_FILES['image'];
$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
$filename = uniqid('product_') . '.' . $ext;
$targetFile = $uploadDir . $filename;

if (move_uploaded_file($image['tmp_name'], $targetFile)) {
    // Convert price and quantity to integers
    $intPrice = (int) $price;
    $intQuantity = (int) $quantity;

    // Insert into database
    $sql = "INSERT INTO `item` (`item_name`, `item_price`, `item_quantity`, `product_image`)
            VALUES ('$name', '$intPrice', '$intQuantity', '$filename')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => '✅ Product added successfully',
            'data' => [
                'name' => $name,
                'price' => $intPrice,
                'quantity' => $intQuantity,
                'image_url' => $targetFile
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => '❌ Failed to insert item into database']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '❌ Image upload failed']);
}
?>
