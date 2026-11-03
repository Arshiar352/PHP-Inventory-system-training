<?php
if (file_exists('Data/products.json')) {
    $json = file_get_contents('Data/products.json');
    $products = json_decode($json, true);

} else {
    $products = [];

}

?>