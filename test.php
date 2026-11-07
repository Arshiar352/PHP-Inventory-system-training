<html>
    <head>
        <title>Add product</title>
    </head>
    <body>
        <form method="POST">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name">

            <label for="price">Price:</label>
            <input type="number" name="price" id="price">

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity">

            <input type="submit" value="Add Product">
        </form>
        <input toggle type="button" value="View Products" onclick="window.location.href='products.json'">

    </body>
</html>


<?php 

if (file_exists('Data/products.json')) {
    $json = file_get_contents('Data/products.json');
    $products = json_decode($json, true);
    if (!is_array($products)) {
        $products = [];
    }
} else {
    $products = [];

}

include 'Functions/product-functions.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ((!isset($_POST["name"])) || (!isset($_POST["price"])) || (!isset($_POST["quantity"]) )) {
   echo "Missing field!"; 

    } elseif (($_POST["name"] === "") || ($_POST["price"] === "") || ($_POST["quantity"] === "")) {
   echo "Missing field!";

    } elseif ((!is_numeric($_POST["price"])) || (!is_numeric($_POST["quantity"]))) {
   echo "Price and Quantity must be numeric values.";

    } elseif (($_POST["price"] < 0) || ($_POST["quantity"] < 0)) {
   echo "Price and Quantity must be non-negative values.";
   
    } else {
        $newProduct = [
            "name" => $_POST["name"],
            "price" => $_POST["price"],
            "quantity" => $_POST["quantity"]
        ];

        $products[] = $newProduct;

        $json = json_encode($products); 
        file_put_contents('Data/products.json', $json);

    echo "Product Name: " . htmlspecialchars($_POST["name"]);
    echo "Product Price: " . htmlspecialchars($_POST["price"]);
    echo "Product Quantity: " . htmlspecialchars($_POST["quantity"]);
 }
}

$productFound = false;

foreach ($products as $index => $product) {
    if ($product["name"] === $_POST["name"]) {
        $products[$index]["quantity"] += $_POST["quantity"];
        $productFound = true;
    }
}


 echo "Total Available Products: " . countAvailableProducts($products) . "<br><br>";

 foreach ($products as $product) {
    if ($product["quantity"] > 0) {
    
    echo "Product Name: " . htmlspecialchars($product["name"]) . "<br>";
    echo "Product Price: " . htmlspecialchars($product["price"]) . "<br>";
    echo "Product Quantity: " . htmlspecialchars($product["quantity"]) . "<br>";
    echo "<br>";
 }
 }



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

?>

<?php

session_start();

$_SESSION['user_id'] = 5;

if (isset($_SESSION['user_id'])) {

echo 'welcome';
} else {

echo 'Please log in first!';
}