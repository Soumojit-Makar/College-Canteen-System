<?php
header('Content-Type: application/json');
include '../config.php'; 

$today = date('Y-m-d');
$monthStart = date('Y-m-01');
$yearStart = date('Y-01-01');

$dayTotal = 0;
$monthTotal = 0;
$yearTotal = 0;

// Daily total
$dayQuery = "SELECT COUNT(*) AS total FROM bills WHERE DATE(created_at) = '$today'";
$result = mysqli_query($conn, $dayQuery);
if ($row = mysqli_fetch_assoc($result)) {
    $dayTotal = (int)$row['total'];
}

// Monthly total
$monthQuery = "SELECT COUNT(*) AS total FROM bills WHERE created_at >= '$monthStart'";
$result = mysqli_query($conn, $monthQuery);
if ($row = mysqli_fetch_assoc($result)) {
    $monthTotal = (int)$row['total'];
}

// Yearly total
$yearQuery = "SELECT COUNT(*) AS total FROM bills WHERE created_at >= '$yearStart'";
$result = mysqli_query($conn, $yearQuery);
if ($row = mysqli_fetch_assoc($result)) {
    $yearTotal = (int)$row['total'];
}

echo json_encode([
    'day' => $dayTotal,
    'month' => $monthTotal,
    'year' => $yearTotal
]);
?>
