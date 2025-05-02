<?php
session_start();

if ($_SESSION['user_role'] != 'admin') {
    header("Location: ../../");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Catering</title>
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <div id="toast-container"></div>
    <header>
        <?php include_once "../components/navbar.php"; ?>

    </header>

    <div class="content ">
        <div class="container  " id="main-content">
            <div class="container ">
                <div class="admin">
                    <h1>Painding Order</h1>
                    <button style="width: 40px;" onclick="getOrdersData()" id="panding-orders-count">10</button>
                </div>
            </div>
            <div class="container">
                <div class="admin" style="gap: 20px;">
                    <a href="./update/">Update and Add Item</a>
                    <a href="./userInfo/"> Update User Order Status </a>
                </div>

            </div>
            <div class="container">
                <h1>Total Sell</h1>
                <hr />
                <div class="admin">
                    <h3>Day :</h3>
                    <p id="day-total">Loading...</p>
                </div>
                <hr />
                <div class="admin">
                    <h3>Month :</h3>
                    <p id="month-total">Loading...</p>
                </div>
                <hr />
                <div class="admin">
                    <h3>Year :</h3>
                    <p id="year-total">Loading...</p>
                </div>
            </div>

        </div>
        <div class="container hidden" id="orders">
            <h1>Painding Orders</h1>
            <hr />
            <div id="container">
                <div class="row item-container">
                    <p>Product Name</p>
                    <p> Product Quentity </p>

                </div>
                <hr />
                <div id="order-user">

                </div>
                <div class="button-containers">

                    <button onclick="showHome()" class="back-button">Back</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/script.js"></script>
    <script src="../js/admin.js"></script>
</body>

</html>