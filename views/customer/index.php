<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Railway Catering</title>
  <link rel="stylesheet" href="../css/style.css">

</head>

<body>

  <div id="toast-container"></div>
  <header >
       <?php include_once "../components/navbar.php"; ?>

    </header>

  <div class="content">
    <div class="container " id="main-content">
      <h2>Welcome to Railway Catering</h2>
      <p>Enjoy a delightful dining experience on your journey with our delicious meals and snacks. Sit back, relax, and
        let us serve you with care and quality!

      </p>
      <button onclick="showOrderMenu()">Add Order</button>
    </div>

    <div class="container hidden" id="order-menu-form">
      <div>
        <h1>Available Items</h1>
        <hr>
      </div>

      <div class="search-row">
      <input type="text" style="width: 100%;" id="searchInput" placeholder="Search item..." oninput="searchItems()" />

      </div>

      <div id="item-list"></div>

      <div class="footer">
        <div>
          Total Items: <span id="totalItems">0</span>
        </div>
        <div>
          Total Amount: ₹<span id="totalAmount">0</span>
        </div>
      </div>
      <div class="button-containers">
        <button onclick="checkout()" style="width: 100%; margin-top: 10px;">Buy</button>
        <button onclick="goBack()" class="back-button">Back</button>
      </div>
    </div>
    <div class="container hidden" id="billing-container">
      <div>
        <h1>Billing</h1>
        <hr>
      </div>
      <div id="order-item-list"></div>
      <div class="footer">
        <div>
          Total Items: <span id="billing-totalItems">0</span>
        </div>
        <div>
          Total Amount: ₹<span id="billing-totalAmount">0</span>
        </div>
      </div>
      <div>
        <select name="payment-method" id="payment-method">
          <option value="" selected disabled>Select payment method</option>
          <option value="online"> Online</option>
          <option value="cash"> Cash </option>
        </select>
        <div class="button-containers">
          <button type="submit"> Buy</button>
          <button type="reset" onclick="goBack()"> Cancel</button>
        </div>

      </div>



    </div>
    <script src="../js/script.js"></script>
    <script src="../js/user.js"></script>
</body>

</html>