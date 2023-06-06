<?php

require '../database.php';
require './product.php';
require './book.php';
require './dvd.php';
require './furniture.php';

//handle addProducts.html form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // retrieves values from POST and assigns variables
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    //map differences in product type. database uses 1 2 and 3 for product type. ensures differences get saved in database.
    $productTypeIds = [
        'book' => 3,
        'dvd' => 1,
        'furniture' => 2
    ];

    // Check product type and save product based on type to the database. Creates a new instance of subclass product based on the type while using ternary operators for differences in type.
    $product = ($type === "book") ? new Book(null, $sku, $name, $price, $productTypeIds[$type], $_POST['weight']) :
    (($type === "dvd") ? new DVD(null, $sku, $name, $price, $productTypeIds[$type], $_POST['size']) :
    (($type === "furniture") ? new Furniture(null, $sku, $name, $price, $productTypeIds[$type], $_POST['height'], $_POST['width'], $_POST['length']) :
    null));

    // checks if the inserted product belongs to product or subclass of product
    if ($product instanceof Product) {
        $product->save();
        
        // Redirect back to index.php page after saving the product
        header("Location: ../index.php");
    } else {
        echo "Invalid product type!";
    }
}

