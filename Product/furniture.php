<?php

class furniture extends Product {
    public $height;
    public $width;
    public $length;

    public function __construct($id, $sku, $name, $price, $product_type_id, $height, $width, $length)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
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
        $furniturequery = "INSERT INTO furniture (product_id, height, width, length) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($furniturequery);
        $height = $this->getHeight();
        $lenght = $this->getLength();
        $width = $this->getWidth();
        $stmt->bind_param("iiss", $productId, $height, $width, $lenght);

        $stmt->execute();
    }

/*     public function delete()
    {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();
    
        // Delete from furniture table
        $furnitureQuery = "DELETE FROM furniture WHERE product_id = ?";
        $stmt = $connection->prepare($furnitureQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        parent::delete(); // Call the delete method from the parent class (Product)
    } */



    public function delete()
    {
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();

        // Delete from furniture table
        $furnitureQuery = "DELETE FROM furniture WHERE product_id = ?";
        $stmt = $connection->prepare($furnitureQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        parent::delete(); // Call the delete method from the parent class (Product)
    }
    

    public function display()
    {
        echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
        echo '<input type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<strong>Product Type:</strong> Furniture<br>';
        echo '<strong>Product Name:</strong> ' . $this->getName() . '<br>';
        echo '<strong>SKU:</strong> ' . $this->getSku() . '<br>';
        echo '<strong>Price:</strong> $' . $this->getPrice() . '<br>';
        echo '<strong>Height:</strong> ' . $this->getHeight() . '<br>';
        echo '<strong>Lenght:</strong> ' . $this->getLength() . '<br>';
        echo '<strong>Width:</strong> ' . $this->getWidth() . '<br>';
        echo '</div>';
    }
}