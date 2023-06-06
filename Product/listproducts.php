<?php

include './database.php';
include 'product.php';
include 'book.php';
include 'dvd.php';
include 'furniture.php';

class ListProducts {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    //retrieve products from database
    public function getProducts() {
        $connection = $this->database->getConnection();
    
        //select all prodcut data from database
        $query = "SELECT p.*, b.weight, d.size, f.height, f.width, f.length
                  FROM product p
                  LEFT JOIN book b ON p.id = b.product_id
                  LEFT JOIN dvd d ON p.id = d.product_id
                  LEFT JOIN furniture f ON p.id = f.product_id";
    
        $result = $connection->query($query);
    
        $products = array();
    
        while ($row = $result->fetch_assoc()) {
            $products[] = $this->createProductFromRow($row);
        }
    
        return $products;
    }
    
    //using ternary operators create product display based on the product type
    private function createProductFromRow($row) {
        $productType = $this->getProductTypeById($row['product_type_id']);
    
        return $productType === 'dvd'
            ? $this->createDVDFromRow($row)
            : ($productType === 'furniture'
                ? $this->createFurnitureFromRow($row)
                : ($productType === 'book'
                    ? $this->createBookFromRow($row)
                    : throw new Exception('Invalid product type: ' . $productType)));
    }
    
    
    
    
    //retrieves a name of a product type from database for createProductFromRow()
    private function getProductTypeById($productTypeId) {
        $connection = $this->database->getConnection();
    
        $query = "SELECT name FROM product_type WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $productTypeId);
        $stmt->execute();
    
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            throw new Exception('Product type not found');
        }
    
        $row = $result->fetch_assoc();
    
        return $row['name'];
    }
    
    
    
    //creates product type specific objects
    private function createBookFromRow($row) {
        return new Book(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type_id'],
            $row['weight']
        );
    }

    private function createDVDFromRow($row) {
        return new DVD(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type_id'],
            $row['size']
        );
    }

    private function createFurnitureFromRow($row) {
        return new Furniture(
            $row['id'],
            $row['sku'],
            $row['name'],
            $row['price'],
            $row['product_type_id'],
            $row['height'],
            $row['width'],
            $row['length']
        );
    }
}
