<?php

class dvd extends Product {
    public $size;

    public function __construct($id, $sku, $name, $price, $product_type_id, $size)
    {
        parent::__construct($id, $sku, $name, $price, $product_type_id);
        $this->size = $size;
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
        $dvdquery = "INSERT INTO dvd (product_id, size) VALUES ('$productId', '$this->size')";
        $connection->query($dvdquery);
    }
}