<?php

$products = [
    ["name" => "Monitor", "quantity" => 10],
    ["name" => "Mouse", "quantity" => 5]
];


foreach ($products as &$product) {
    if ($product["name"] === "Mouse") {
        $product["quantity"] += 3;
       
    }
}

unset($product);

?>