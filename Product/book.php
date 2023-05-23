<?php

class Book extends Product {
    public $weight;

    public function __construct($id, $sku, $name, $price, $product_type_id, $weight)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->weight = $weight;
    }

    public function save() {

        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');

        $connection = $database->getConnection();

        //insert into product table
        $query = "INSERT INTO product (sku, name, price, product_type_id) VALUES ('$this->sku', '$this->name', '$this->price', $this->product_type_id)";
        $connection->query($query);

        //Get the last inserted product id
        $productId = $connection->insert_id;

        //insert into book table
        $bookquery = "INSERT INTO book (product_id, weight) VALUES ('$productId', '$this->weight')";
        $connection->query($bookquery);
    }
}