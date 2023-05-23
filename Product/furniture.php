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

    public function save() {

        $database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');

        $connection = $database->getConnection();

        //insert into product table
        $query = "INSERT INTO product (sku, name, price, product_type_id) VALUES ('$this->sku', '$this->name', '$this->price', $this->product_type_id)";
        $connection->query($query);

        //Get the last inserted product id
        $productId = $connection->insert_id;

        //insert into book table
        $furniturequery = "INSERT INTO furniture (product_id, height, width, length) VALUES ('$productId', '$this->height', '$this->width', '$this->length')";
        $connection->query($furniturequery);
    }
}