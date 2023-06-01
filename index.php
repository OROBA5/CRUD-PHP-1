<?php

include './Product/listproducts.php';

$database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');

$connection = $database->getConnection();

// Step 2: Instantiate the ListProducts class
$listProducts = new ListProducts($database);

?>

<div>
    <button><a href="./addProduct.html">Add</a></button>
    <form method="POST" action="./Product/deleteProducts.php">
    <input type="submit" value="Delete Selected Products">
        <?php
        // Step 3: Get the products
        $products = $listProducts->getProducts();

        // Step 4: Display the products
        foreach ($products as $product) {
            $product->display();
        }
        ?>
    </form>
</div>
