<?php

//DVD subclass for product, deeper code documentation in book class
class DVD extends Product {
    // declare dvd specific field
    public $size;

    //declares constructor for the dvd class
    public function __construct($id, $sku, $name, $price, $product_type_id, $size)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->size = $size;
    }
    
    //setters and getters for the class specific fields
    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    //utilises save funcion for saving new product
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

    //utilises delete funcion for deleting a product
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

    //utilises display funcionality for a product
    public function display()
    {
        echo '<div class="product">';
        echo '<input class="delete-checkbox" type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<p><strong>Product Type:</strong>  DVD </p>';
        echo '<p><strong>Product Name:</strong> ' . $this->getName() . ' </p>';
        echo '<p><strong>SKU:</strong> ' . $this->getSku() . '</p> ';
        echo '<p><strong>Price:</strong> ' . $this->getPrice() . ' $ </p> ';
        echo '<p><strong>Duration:</strong> ' . $this->getSize() . ' minutes</p>';
        echo '</div>';
    }
}
