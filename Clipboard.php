<?php
 

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

 

        if ((!is_numeric($price)) || (!is_numeric($quantity))) {
    
             echo 'You can only use numbers.';

        } elseif (($price < 0) || ($quantity < 0)) {

             echo 'Invalid. Number cannot be negative.';

         } else {

               $newProduct = [

                 'name' => $name,
                  'price' => $price,
                 'quantity' => $quantity
                 ];

         echo $name . PHP_EOL;
         echo $price . PHP_EOL;
         echo $quantity . PHP_EOL;
         echo PHP_EOL;
    }
}