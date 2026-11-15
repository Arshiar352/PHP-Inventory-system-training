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

        $name = $_GET['name'] ?? '';
        $manufacturer = $_GET['manufacturer'] ?? '';
        $type = $_GET['type'] ?? '';

        $products = $this->searchProducts(
            $name,
            $manufacturer,
            $type
        );
        require_once __DIR__ . '/../Views/products.php';
    }



    public function createProduct()
    {
        global $pdo;

        $errors = [];
        $products = [];
        $editProduct = null;

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

    public function updateProduct()
    {

        global $pdo;

        $errors = [];
        $products = [];
        $editProduct = null;

        $id = $_POST['id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        $quantity = $_POST['quantity'] ?? '';
        $manufacturer = trim($_POST['manufacturer'] ?? '');
        $type = trim($_POST['type'] ?? '');

        if (
            $id === '' || !ctype_digit((string) $id) || (int) $id <= 0
        ) {
            $errors[] = 'Invalid product ID.';
        }

        if ($name === '' || $manufacturer === '' || $type === '') {
            $errors[] = 'All fields required.';
        }

        if (
            $quantity === '' || !ctype_digit((string) $quantity)
        ) {
            $errors[] = 'Number cannot be negative.';
        }

        if (empty($errors)) {
            $editProduct = $this->getProductForEdit($id);

            if ($editProduct === false) {
                $errors[] = 'Product not found.';
            }
        }


        if (empty($errors)) {


            $stmt = $pdo->prepare('UPDATE products 
            SET name = ?,
                 quantity = ?,
                 manufacturer = ?,
                 type = ?
            WHERE id = ?');

            $stmt->execute([
                $name,
                $quantity,
                $manufacturer,
                $type,
                $id
            ]);

            header('Location: /products');
            exit;
        }


        $stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/products.php';
    }




    private function getProductForEdit(string $id)
    {
        global $pdo;

        $stmt = $pdo->prepare(
            'SELECT * FROM products WHERE id = ?'
        );

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function searchProducts(string $name, string $manufacturer, string $type)
    {
        global $pdo;

        $name = '%' . trim($name) . '%';
        $manufacturer = '%' . trim($manufacturer) . '%';
        $type = '%' . trim($type) . '%';

        $stmt = $pdo->prepare(
            'SELECT * FROM products
         WHERE name LIKE :name
         AND manufacturer LIKE :manufacturer
         AND type LIKE :type
         ORDER BY id DESC'
        );

        $stmt->execute([
            'name' => $name,
            'manufacturer' => $manufacturer,
            'type' => $type
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
