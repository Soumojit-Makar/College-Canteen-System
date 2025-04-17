<?php
$userId = $_SESSION['user_id'] ?? null;
$userName = $_SESSION['user_name'] ?? null;
$userRole = $_SESSION['user_role'] ?? null;
?>

<nav class="menu">
    <button class="menu-btn" id="m" onclick="toggleSidebar()">☰ Menu</button>
    <div class="sidebar hidden" id="sidebar">
        <p><strong>Railway Catering</strong></p>
        <button class="toggle-mode" onclick="toggleDarkMode()">Dark Mode</button>
        <button onclick="toggleOpen()">Close</button>
        <?php
        if ($userId !== null) {
            if ($userRole === "user") {
        ?>

                <a class="menu-btn" href="/Collage-Project/views/customer"> Home </a>
                <button onclick="showOrderMenu()">Add Order</button>
            <?php
            } elseif ($userRole === "admin") {
            ?>

                <a class="menu-btn" href="/Collage-Project/views/admin"> Home </a>
                <a class="menu-btn" href="../update/">Update & Add Item</a>
                <a class="menu-btn" href="../userInfo/">Order Status </a>
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
    <h1><strong>Railway Catering</strong></h1>
</nav>