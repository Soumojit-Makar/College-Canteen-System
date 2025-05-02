<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'user') {
    header("Location: ../../");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Catering</title>
    <link rel="stylesheet" href="../../css/style.css">

</head>

<body>

    <div id="toast-container"></div>
    <header>
        <?php include_once "../../components/navbar.php"; ?>
    </header>

    <div class="content">
        <div class="container " id="main-content">
            <div id="reportContainer" width="100%">
            </div>
        </div>
    </div>
    <script src="../../js/script.js"></script>
    <script src="../../js/singleUserReport.js"></script>
</body>

</html>