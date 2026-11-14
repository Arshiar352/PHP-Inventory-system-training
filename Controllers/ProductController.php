<?php


require_once __DIR__ . '/../Config/Database.php';

class ProductController
{

    public function showProducts()
    {
        global $pdo;

        $stmt = $pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/products.php';
    }
}
