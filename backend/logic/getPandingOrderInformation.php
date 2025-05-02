<?php
include '../config.php';
header('Content-Type: application/json');

$sql = "SELECT 
            u.user_id,
            u.name AS userName,
            u.phone AS userPhone,
            b.bill_id,
            b.total_amount,
            b.total_items,
            b.status AS orderStatus,
            bi.item_id AS id,
            bi.item_name AS name,
            bi.quantity AS count,
            bi.price,
            bi.total_price
        FROM users u
        JOIN bills b ON u.user_id = b.user_id
        JOIN bill_items bi ON b.bill_id = bi.bill_id
        WHERE b.status = 'PENDING'
        ORDER BY u.user_id, b.bill_id";

$result = mysqli_query($conn, $sql);
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $userId = $row['user_id'];

    if (!isset($orders[$userId])) {

        $orders[$userId] = [
            'userId' => $userId,
            'userName' => $row['userName'],
            'userPhone' => $row['userPhone'],
            'totalAmount' => 0,
            'totalItem' => 0,
            'orderStatus' => $row['orderStatus'],
            'orderedItems' => []
        ];
    }

    $orders[$userId]['orderedItems'][] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'price' => (float)$row['price'],
        'count' => (int)$row['count'],
        'totalPrice' => (float)$row['total_price'],
        'image' => '/views/images/food.jpg'
    ];

    $orders[$userId]['totalAmount'] += (float)$row['total_price'];
    $orders[$userId]['totalItem'] += (int)$row['count']; 

}

// Send response
echo json_encode(array_values($orders));
?>