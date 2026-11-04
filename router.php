<?php 

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($path) {

    case '/':
        require_once __DIR__ . '/Controllers/AuthController.php';   

        $auth = new AuthController();
        $auth->showLogin();
        break;


    case '/login':
        require_once __DIR__ . '/Controllers/AuthController.php';   

        $auth = new AuthController();
        $auth->showLogin();
        break;

    case '/register':
        require_once __DIR__ . '/Controllers/AuthController.php';

        $auth = new AuthController();
        $auth->showRegister();
        break;

    case '/home':
        require_once __DIR__ . '/Controllers/HomeController.php';   

        $home = new HomeController();
        $home->showHome();
        break;

    case '/products':
        require_once __DIR__ . '/Controllers/ProductController.php';  


         if ($method === 'GET') {

             $product = new ProductController();
             $product->showProducts();
             break;
         } elseif ($method === 'POST') {

            echo 'Create Product';
            break;
         } else {

            http_response_code(405);
            echo 'Method not allowed.';
            break;
         }
       

    case '/users':
        require_once __DIR__ . '/Controllers/UserController.php';

        $user = new UserController();
        $user->showUsers();
        break;

        

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}

?>