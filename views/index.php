<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Canteen</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div id="toast-container"></div>
    <header>
        <?php include_once "./components/navbar.php"; ?>

    </header>

    <div class="content">
        <div class="container" id="main-content">
            <h2>Welcome to College Canteen</h2>
            <p>Enjoy fresh, affordable meals on campus, made to keep you energized throughout your day.</p>
            <button onclick="showLogin()" id="btn-login-form">Login</button>
            <button onclick="showSignup()" id="btn-signup-form">Sign Up</button>
        </div>


        <div class="container hidden" id="login-form">
            <h2>Login</h2>
            <input type="text" placeholder="Phone No" id="login-phone" required />
            <input type="password" placeholder="Password" id="login-password" required />
            <button onclick="login()" id="btn-login">Login</button>
            <button onclick="showHome()">Back</button>
        </div>

        <div class="container hidden" id="signup-form">
            <h2>Sign Up</h2>
            <input type="text" placeholder="Full Name" id="fullname" required>
            <input type="number" placeholder="Enter Phone No." id="phone" required>
            <input type="password" placeholder="Password" id="password" required>
            <button onclick="signup()" id="btn-signup">Sign Up</button>
            <button onclick="showHome()">Back</button>
        </div>
    </div>

    <script src="./js/script.js"></script>
    <script src="./js/login.js"></script>
</body>

</html>