<?php

//furniture subclass for product, deeper code documentation in book class
class furniture extends Product {
    // declare furniture specific field
    public $height;
    public $width;
    public $length;

    //declares constructor for the furniture class
    public function __construct($id, $sku, $name, $price, $product_type_id, $height, $width, $length)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    
    //setters and getters for the class specific fields
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
        $furniturequery = "INSERT INTO furniture (product_id, height, width, length) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($furniturequery);
        $height = $this->getHeight();
        $lenght = $this->getLength();
        $width = $this->getWidth();
        $stmt->bind_param("iiss", $productId, $height, $width, $lenght);

        $stmt->execute();
    }

    //utilises delete funcion for deleting a product
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
    
    //utilises display funcionality for a product
    public function display()
    {
        echo '<div class="product">';
        echo '<input class="delete-checkbox" type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<p><strong>Product Type:</strong> Furniture</p>';
        echo '<p><strong>Product Name:</strong> ' . $this->getName() . '</p>';
        echo '<p><strong>SKU:</strong> ' . $this->getSku() . '</p>';
        echo '<p><strong>Price:</strong> ' . $this->getPrice() . ' $ </p>';
        echo '<p><strong>Dimentions:</strong> ' . $this->getHeight() . 'x' . $this->getLength() . 'x' . $this->getWidth() . '</p>';
        echo '</div>';
    }
}