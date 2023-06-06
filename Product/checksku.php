<?php
require '../database.php';

//database connection
$database = new Database('localhost', 'root', '', 'juniordev.liga.lomakina');
$connection = $database->getConnection();

//select product sku from database
$sql = "SELECT sku FROM product";
$result = $connection->query($sql);

//checks if rows are retrieved and if they are fetch skus
if ($result->num_rows > 0) {
    $skus = [];
    while ($row = $result->fetch_assoc()) {
        $skus[] = $row['sku'];
    }
    //encodes the $sku array into json
    echo json_encode($skus);
} else {
    echo "No products found.";
}

//close database connection
$connection->close();
?>
