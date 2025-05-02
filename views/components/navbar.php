<?php
$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_name'] ?? null;
$userRole = $_SESSION['user_role'] ?? null;
?>

<nav class="menu">
    <button class="menu-btn" id="m" onclick="toggleSidebar()">☰ Menu</button>
    <div class="sidebar hidden" id="sidebar">
        <p><strong>Railway Canteen</strong></p>
        <button class="toggle-mode" onclick="toggleDarkMode()">Dark Mode</button>
        <button onclick="toggleOpen()">Close</button>
        <?php
        if ($userId !== null) {
            if ($userRole === "user") {
        ?>

                <a class="menu-btn" href="/views/customer"  style="width: 90%; "  > Home </a>
                <a class="menu-btn" href="/views/customer/user-order-report/"  style="width: 90%;">Order Report </a>
                <button onclick="showOrderMenu()">Add Order</button>
            <?php
            } elseif ($userRole === "admin") {
            ?>

                <a class="menu-btn" href="/views/admin" style="width: 90%;"> Home </a>
                <a class="menu-btn" href="/views/admin/update/"  style="width: 90%;">Update & Add Item</a>
                <a class="menu-btn" href="/views/admin/userInfo/"  style="width: 90%;">Order Status </a>
            <?php
            }
            ?>
            <button onclick="logout()">Logout</button>
        <?php

        } else {
        ?>
            <button class="menu-btn" onclick="showHome()">Home</button>
            <button class="menu-btn" onclick="showLogin()">Login</button>
            <button class="menu-btn" onclick="showSignup()">Sign Up</button>
        <?php
        }
        ?>

    </div>
    <h1 style="color: blue;"><strong style="color: blue;">College Canteen</strong></h1>
</nav>