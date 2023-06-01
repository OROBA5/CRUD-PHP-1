<?php

class DVD extends Product {
    public $size;

    public function __construct($id, $sku, $name, $price, $product_type_id, $size)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->size = $size;
    }
    

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
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
        $dvdquery = "INSERT INTO dvd (product_id, size) VALUES (?, ?)";
        $stmt = $connection->prepare($dvdquery);
        $size = $this->getSize();
        $stmt->bind_param("is", $productId, $size);
        $stmt->execute();
    }

/*     public function delete()
{
    $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
    $connection = $database->getConnection();
    
        // Delete from dvd table
        $dvdQuery = "DELETE FROM dvd WHERE product_id = ?";
        $stmt = $connection->prepare($dvdQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        parent::delete(); // Call the delete method from the parent class (Product)
} */


    public function delete()
    {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();

        // Delete from dvd table
        $dvdQuery = "DELETE FROM dvd WHERE product_id = ?";
        $stmt = $connection->prepare($dvdQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        parent::delete(); // Call the delete method from the parent class (Product)
    }

    public function display()
    {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
        echo '<input type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<strong>Product Type:</strong> DVD<br>';
        echo '<strong>Product Name:</strong> ' . $this->getName() . '<br>';
        echo '<strong>SKU:</strong> ' . $this->getSku() . '<br>';
        echo '<strong>Price:</strong> $' . $this->getPrice() . '<br>';
        echo '<strong>Duration:</strong> ' . $this->getSize() . ' minutes<br>';
        echo '</div>';
    }
}
