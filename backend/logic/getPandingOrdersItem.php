<?php
header('Content-Type: application/json');
include '../config.php'; 

$sql = "
    SELECT 
        bi.item_name AS itemName,
        SUM(bi.quantity) AS itemQuantity
    FROM 
        bills b
    INNER JOIN 
        bill_items bi ON b.bill_id = bi.bill_id
    WHERE 
        b.status = 'PENDING'
    GROUP BY 
        bi.item_name
";

$result = mysqli_query($conn, $sql);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'itemName' => $row['itemName'],
        'itemQuantity' => (int)$row['itemQuantity']
    ];
}

echo json_encode($data);
?>
