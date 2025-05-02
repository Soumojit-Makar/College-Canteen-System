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
    <title>College Canteen</title>
    <link rel="stylesheet" href="../../css/style.css">
    
</head>

<body>

    <div id="toast-container"></div>
    <header >
       <?php include_once "../../components/navbar.php"; ?>

    </header>

    <div class="content ">
        <div class="container   " style="width: auto;" id="main-content">
            <h1>Students Order Status</h1>
            <hr>
            <div class="search-row">
                <input type="text" placeholder="search">
                <button>🔍</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Phone Number</th>
                        <th>Total Items</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                </tbody>
            </table>
        </div>
        <div class="container  hidden " style="width: auto;" id="student-bill-content">
            <h1>Student Bill </h1>
            <hr>
            <div style="margin:0px ;">
                <p style="margin:0px ;"> Student Name: <span id="bill-name"></span> </p>
                <p style="margin-bottom:0px ;">Phone No: <span id="bill-phone"></span> </p>
            </div>
            <table style="margin-top: 0px;">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th >Item Quentity</th>
                        <th>Item Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="user-bill-table">
                </tbody>
            </table>
            <div style="display: flex; justify-content: space-between; "> 
                <p>Total Amount: <span id="total-amount"></span> </p>
                <p>Total Quentity: <span id="total-quentity"></span> </p>
            </div>
            <div id="bill-buttons" class="button-containers" style="width: 100%;"></div>

        </div>
        
    </div>


    <script src="../../js/script.js"></script>
    <script src="../../js/userInfo.js"></script>
</body>

</html>