<?php

class Book extends Product {
    public $weight;

    public function __construct($id, $sku, $name, $price, $product_type_id, $weight)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->weight = $weight;
    }
    
    

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function save() {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();
    
        // Insert into product table
        $query = "INSERT INTO product (sku, name, price, product_type_id) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $sku = $this->getSku();
        $name = $this->getName();
        $price = $this->getPrice();
        $productTypeId = $this->getProductTypeId();
        $stmt->bind_param("ssdi", $sku, $name, $price, $productTypeId);
        $stmt->execute();

        // Get the last inserted product id
        $productId = $stmt->insert_id;

        // Insert into dvd table
        $bookquery = "INSERT INTO book (product_id, weight) VALUES (?, ?)";
        $stmt = $connection->prepare($bookquery);
        $weight = $this->getWeight();
        $stmt->bind_param("is", $productId, $weight);
        $stmt->execute();
    }

/*         public function delete()
    {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();

        // Delete from book table
        $bookQuery = "DELETE FROM book WHERE product_id = ?";
        $stmt = $connection->prepare($bookQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        parent::delete(); // Call the delete method from the parent class (Product)
    } */

    public function delete()
    {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();

        // Delete from book table
        $bookQuery = "DELETE FROM book WHERE product_id = ?";
        $stmt = $connection->prepare($bookQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        parent::delete(); // Call the delete method from the parent class (Product)
    }


    public function display()
    {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
        echo '<input type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<strong>Product Type:</strong> Book<br>';
        echo '<strong>Product Name:</strong> ' . $this->getName() . '<br>';
        echo '<strong>SKU:</strong> ' . $this->getSku() . '<br>';
        echo '<strong>Price:</strong> $' . $this->getPrice() . '<br>';
        echo '<strong>Weight:</strong> ' . $this->getWeight() . ' lbs<br>';
        echo '</div>';
    }
}