<?php
include '../database.php';
include 'product.php';
include 'book.php';
include 'dvd.php';
include 'furniture.php';

$database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
$connection = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if any products are selected for deletion
    if (isset($_POST['selected_products'])) {
        $selectedProducts = $_POST['selected_products'];

        foreach ($selectedProducts as $productId) {
            // Get the product type ID
            $query = "SELECT product_type_id FROM product WHERE id = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                throw new Exception('Product not found');
            }

            $row = $result->fetch_assoc();
            $productTypeId = $row['product_type_id'];

            // Delete the product based on its type using ternary operators
            $product = ($productTypeId === '1')
                ? new Book($productId, '', '', 0, 0, 0)
                : (($productTypeId === '2')
                    ? new DVD($productId, '', '', 0, 0, 0)
                    : (($productTypeId === '3')
                        ? new Furniture($productId, '', '', 0, 0, 0, 0, 0)
                        : throw new Exception('Invalid product type: ' . $productTypeId)));

            // Delete the product
            $product->deleteSpecificRow();
            $product->delete();
        }
    }

    // Redirect back to the listProducts.php page after deletion
    header("Location: listProducts.php");
    exit();
}
