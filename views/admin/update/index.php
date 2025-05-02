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
    <!-- <style href="/views/css/style.css"></style> -->
</head>

<body>

    <div id="toast-container"></div>
    <header>
        <?php include_once "../../components/navbar.php"; ?>

    </header>

    <div class="content ">
        <div class="container   " style="width: auto;" id="main-content">
            <h1>Add and Update Items</h1>
            <hr>
            <button onclick="showAddItemForm()">Add Item</button>
            <div class="search-row">
            <input type="text" style="width: 100%;" id="searchInput" placeholder="Search item..." oninput="searchItems()" />

     
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Image </th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quentity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                </tbody>
            </table>
        </div>
        <div class="container  hidden " id="add-item-content">
            <h1>Add Item</h1>
            <hr>
                <input type="text" name="name" placeholder="Enter Product Name" required id="name" />
                <div style="display: flex; gap: 5px;">
                    <input type="text" name="price" placeholder="Enter Product Price" id="price" required />
                    <input type="text" name="quentity" placeholder="Enter Product Quantity" id="quantity" required />
                </div>
                <input type="file" name="image" accept="image/*" id="imageInput" onchange="previewImage()" required />
                <img src="" width="100%" alt="" id="product-image" />
                <div class="button-containers">
                    <button  onclick="addItem()" id="submit-button-add"> Submit</button>
                    <button type="reset" onclick="showHome()">Clear</button>
                </div>

        </div>
        <div class="container  hidden " id="update-item-content">
            <h1>Update Item</h1>
            <hr>
                <label for="">Product Name</label>                
                <input type="text" id="product-name" name="name" placeholder="Enter Product Name"  />
                <div style="display: flex; gap: 5px; justify-content: center; align-items: center;">
                    <label for="">Price</label>
                    <input type="text" id="product-price" name="price" placeholder="Enter Product Price" />
                    <label for="">Quentity</label>
                    <input type="text" id="product-quentity" name="quentity" placeholder="Enter Product Quentity" />
                </div>
                <input type="file" name="image" accept="image/*" id="imageUpdateInput" onchange="previewImageUpdate()" required />
                <img src="" width="100%" alt="" id="product-update-image" />
                <div class="button-containers" id="update-button">
                    
                </div>
           
        </div>

    </div>


    <script src="../../js/script.js"></script>
    <script src="../../js/update.js"></script>
    <script>
        function previewImage() {
            const file = document.getElementById("imageInput").files[0];
            const preview = document.getElementById("product-image");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
        function previewImageUpdate(){
            const file = document.getElementById("imageUpdateInput").files[0];
            const preview = document.getElementById("product-update-image");

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
</body>

</html>