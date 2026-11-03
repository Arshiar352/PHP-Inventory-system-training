<?php 

   include 'Data/Products.php'; 

function countAvailableProducts($products) {
    $count = 0;
    foreach ($products as $product) {
        if ($product["quantity"] > 0) {
            $count++;
        }
    }
    return $count;
}

function getProductStatus($product) {
    if ($product["quantity"] > 0) {
        return "In Stock";
    } else {
        return "Out of Stock";
    }
} 

?>