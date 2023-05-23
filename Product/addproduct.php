<?php

require '../database.php';
require './product.php';
require './book.php';
require './dvd.php';
require './furniture.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    $productTypeIds = [
        'book' => 3,
        'dvd' => 1,
        'furniture' => 2
    ];

    // Check product type and save product based on type to the database
    $product = ($type === "book") ? new Book(null, $sku, $name, $price, $productTypeIds[$type], $_POST['weight']) :
    (($type === "dvd") ? new DVD(null, $sku, $name, $price, $productTypeIds[$type], $_POST['size']) :
    (($type === "furniture") ? new Furniture(null, $sku, $name, $price, $productTypeIds[$type], $_POST['height'], $_POST['width'], $_POST['length']) :
    null));

    if ($product instanceof Product) {
        $product->save();
        echo ucfirst($type) . " saved successfully!";
    } else {
        echo "Invalid product type!";
    }
}

