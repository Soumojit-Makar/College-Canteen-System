<?php
session_start();
include '../config.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $item_name = $_POST["name"] ?? null;
    $item_price = $_POST["price"] ?? null;
    $item_quantity = $_POST["quantity"] ?? null;
    $item_file = $_FILES['image'] ?? null;
    if ($id === null || trim($id) === '') {
        echo json_encode(["success" => false, "message" => "Id required"]);
        return;
    } else {
        $search = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM `item` WHERE `item_id`=  '$id' ";
    }
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $array = mysqli_fetch_assoc($result);
            if ($item_file === null) {
                $item_image = $array['product_image'];
            } else {

                $uploadDir = '../../views/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $image = $_FILES['image'];
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $item_image = uniqid('product_') . '.' . $ext;
                $targetFile = $uploadDir . $item_image;
                if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
                    echo json_encode(['success' => false, 'message' => ' Image upload failed']);
                    return;
                }
            }
            $sql = "UPDATE `item` SET `item_name`='$item_name',`item_price`='$item_price',`item_quantity`='$item_quantity',`product_image`='$item_image' WHERE `item_id`='$id'";
            $result2=mysqli_query($conn,$sql);
            if ($result2) {
                echo json_encode(["success" => true, "message" => "Item updated successfully"]);
            } else {
                echo json_encode(["success" => false, "message" => " Update failed: " . mysqli_error($conn)]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "No matching items found."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => mysqli_error($conn)]);
    }
}
?>