<?php


session_start();


$path = rtrim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');

if ($path === '') {
    $path = '/';
}

$method = $_SERVER['REQUEST_METHOD'];
$protectedRoutes = ['/home', '/products', '/users'];
$isLoggedIn = isset($_SESSION['user_id']);
$guestRoutes = ['/register', '/login', '/'];

if ((!$isLoggedIn) && (in_array($path, $protectedRoutes))) {

    header('Location: /login');
    exit;
} elseif (($isLoggedIn) && (in_array($path, $guestRoutes))) {

    header('Location: /home');
    exit;
}

switch ($path) {
    case '/':
    case '/login':
        require_once __DIR__ . '/Controllers/AuthController.php';

        $auth = new AuthController();

        if ($method === 'GET') {

            $auth->showLoginGet();
        } elseif ($method === 'POST') {

            $auth->loginPost();
        } else {

            http_response_code(405);
            echo 'Method not allowed.';
        }

        break;

    case '/register':
        require_once __DIR__ . '/Controllers/AuthController.php';

        $auth = new AuthController();

        if ($method === 'GET') {

            $auth->showRegisterGet();
        } elseif ($method === 'POST') {

            $auth->registerPost();
        } else {

            http_response_code(405);
            echo 'Method not allowed.';
        }

        break;

    case '/home':
        require_once __DIR__ . '/Controllers/HomeController.php';

        $home = new HomeController();

        if ($method === 'GET') {
            $home->showHome();
        } else {
            http_response_code(405);
            echo 'Method not allowed.';
        }

        break;

    case '/products':
        require_once __DIR__ . '/Controllers/ProductController.php';

        $product = new ProductController();

        if ($method === 'GET') {

            $product->showProductsGet();
        } elseif ($method === 'POST') {

            $action = $_POST['action'] ?? '';

            if ($action === 'create') {

                $product->createProduct();
            } elseif ($action === 'delete') {

                $product->deleteProduct();
            } elseif ($action === 'update') {

                $product->updateProduct();
            } else {

                http_response_code(400);
                echo 'Invalid action.';
            }
        } else {

            http_response_code(405);
            echo 'Method not allowed.';
        }

        break;

    case '/users':
        require_once __DIR__ . '/Controllers/UserController.php';

        $user = new UserController();
        $user->showUsers();
        break;

    case '/logout':
        require_once __DIR__ . '/Controllers/AuthController.php';

        $controller = new AuthController();
        $controller->logout();
        break;


    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
