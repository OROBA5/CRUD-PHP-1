<?php

include './Product/listproducts.php';

//create database connection
$database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');

$connection = $database->getConnection();

//retrieve products
$listProducts = new ListProducts($database);

?>
<head>
    <title>Add a product</title>
    <link rel="stylesheet" type="text/css" href="./index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery library -->
    <script src="index.js"></script>
</head>
<div>
    <div class="navbar">
    <h1> Product list</h1>
    <div class="inner-navbar">
    <button><a href="./addProduct">ADD</a></button>
    <form method="POST" action="./Product/deleteProducts.php">
    <button type="submit"><input type="submit"  class="submit-button" value="">MASS DELETE</button>
    </div>
    </div>
    <div class="product-list">
    <?php
        // get products
        $products = $listProducts->getProducts();

        // get products as individual products in a loop
        foreach ($products as $product) {
            $product->display();
        }
        ?>
    </div>
    </form>
</div>
<footer>
    <h3> Scandiweb Test assignment</h3>
  </footer>
