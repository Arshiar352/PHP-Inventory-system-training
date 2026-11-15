<?php

require_once __DIR__ . '/../Config/Database.php';

class ProductController
{

    public function showProductsGet()
    {
        global $pdo;

        $errors = [];
        $products = [];
        $editProduct = null;

        if (isset($_GET['edit'])) {

            $editId = $_GET['edit'];

            if (
                filter_var($editId, FILTER_VALIDATE_INT) === false ||
                (int) $editId <= 0
            ) {
                $errors[] = 'Invalid product ID.';
            } else {
                $editProduct = $this->getProductForEdit($editId);

                if ($editProduct === false) {
                    $errors[] = 'Product not found.';
                }
            }
        }

        $stmt = $pdo->query(
            'SELECT * FROM products ORDER BY id DESC'
        );

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/products.php';
    }



    public function showProductsPost()
    {
        global $pdo;

        $errors = [];
        $products = [];

        $name = trim($_POST['name'] ?? '');
        $quantity = $_POST['quantity'] ?? '';
        $manufacturer = trim($_POST['manufacturer'] ?? '');
        $type = trim($_POST['type'] ?? '');


        if ($name === '' || $manufacturer === '' || $type === '') {
            $errors[] = 'All fields required.';
        }

        if (
            $quantity === '' || !ctype_digit((string) $quantity)
        ) {
            $errors[] = 'Number cannot be negative.';
        }

        if (empty($errors)) {

            $stmt = $pdo->prepare(
                'INSERT INTO products (name, quantity, manufacturer, type)
                     VALUES (:name, :quantity, :manufacturer, :type)'
            );

            $stmt->execute([
                'name' => $name,
                'quantity' => $quantity,
                'manufacturer' => $manufacturer,
                'type' => $type
            ]);

            header('Location: /products');
            exit;
        }

        $stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/products.php';
    }

    public function deleteProduct()
    {

        global $pdo;

        $errors = [];


        $id = $_POST['id'] ?? '';

        if (filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id <= 0) {


            $errors[] = 'Id is not valid.';
        }

        if (empty($errors)) {

            $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
            $stmt->execute([$id]);

            if ($stmt->rowCount() === 0) {
                $errors[] = 'No product has been deleted.';
            }

            header('Location: /products');
            exit;
        }
    }

    public function updateProduct() {}

    public function createProduct() {}

    private function getProductForEdit($id)
    {
        global $pdo;

        $stmt = $pdo->prepare(
            'SELECT * FROM products WHERE id = ?'
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
