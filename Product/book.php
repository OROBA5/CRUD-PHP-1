<?php


//book subclass for product
class Book extends Product {
    // declare book specific field
    public $weight;

    //declares constructor for the book class
    public function __construct($id, $sku, $name, $price, $product_type_id, $weight)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->weight = $weight;
    }
    
    
    //setters and getters for the class specific fields
    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    //utilises save funcion for saving new product
    public function save() {
        //initiate new database
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();
    
        // Insert into product table
        $query = "INSERT INTO product (sku, name, price, product_type_id) VALUES (?, ?, ?, ?)";
        //prepares the SQL statement 
        $stmt = $connection->prepare($query);
        //takes values out of the book object using getters and asigning them to variables
        $sku = $this->getSku();
        $name = $this->getName();
        $price = $this->getPrice();
        $productTypeId = $this->getProductTypeId();
        //binds values from variables to prepared statement. Uses parameter format to specify types of values.
        $stmt->bind_param("ssdi", $sku, $name, $price, $productTypeId);
        //executes prepared statement, inserts values in the product table
        $stmt->execute();

        // Get the last inserted product id
        $productId = $stmt->insert_id;

        // Insert into book table
        $bookquery = "INSERT INTO book (product_id, weight) VALUES (?, ?)";
        $stmt = $connection->prepare($bookquery);
        $weight = $this->getWeight();
        //binds values from variables to prepared statement. Uses parameter format to specify types of values.
        $stmt->bind_param("is", $productId, $weight);
        //executes prepared statement, inserts values in the book table
        $stmt->execute();
    }

    //utilises delete funcion for deleting a product
    public function delete()
    {
        //initiate new database
        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
        $connection = $database->getConnection();

        // Delete from book table
        $bookQuery = "DELETE FROM book WHERE product_id = ?";
        //prepares the SQL statement 
        $stmt = $connection->prepare($bookQuery);
        $productId = $this->getId();
        $stmt->bind_param("i", $productId);
        //executes prepared statement
        $stmt->execute();
        parent::delete(); // Call the delete method from the parent class (Product)
    }

    //utilises display funcionality for a product
    public function display()
    {
        echo '<div class="product">';
        echo '<input class="delete-checkbox" type="checkbox" name="selected_products[]" value="' . $this->getId() . '">';
        echo '<p><strong> Product Type:</strong> Book</p>';
        echo '<p><strong>Product Name:</strong> ' . $this->getName() . '</p>';
        echo '<p><strong>SKU:</strong> ' . $this->getSku() . '</p>';
        echo '<p><strong>Price:</strong> ' . $this->getPrice() . ' $ </p>';
        echo '<p><strong>Weight:</strong> ' . $this->getWeight() . ' KG </p>';
        echo '</div>';
    }
}