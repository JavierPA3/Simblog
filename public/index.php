<?php
    require_once "../vendor/autoload.php";
    require_once "../bootstrap.php";
    
    use App\Controllers\AdminController;
use App\Controllers\BlogsController;
    use App\Controllers\IndexController;
    use Aura\Router\RouterContainer as router;
use App\Controllers\UserController;
use App\Controllers\AuthController;


    session_start();

    if (!isset($_SESSION['perfil'])) {
        $_SESSION['user'] = 'Invitado';
        $_SESSION['perfil'] = "Invitado";
    }
    $request = \Laminas\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES
    );

    $router = new Router();
    $rutas = $router->getMap();
    $rutas->get("home", "/", [IndexController::class, "indexAction"]);
    $rutas->get("blogForm", "/blogs", [BlogsController::class, "blogsAction"]);
    $rutas->post("addBlog", "/blogs", [BlogsController::class, "blogsAction", 'auth' => true]);
    $rutas->post("addUser", "/register", [UserController::class, "userAction", 'auth' => true]);
    $rutas->get("formuser", "/register", [UserController::class, "userAction"]);
    $rutas->post("lognUser", "/login", [AuthController::class, "loginAction"]);
    $rutas->get("LoginUserForm", "/login", [AuthController::class, "loginAction"]);
    $rutas->get("admin", "/admin", [AdminController::class, "indexAction", 'auth' => true]);
    $rutas->get("logout", "/logout", [AuthController::class, "logoutAction", 'auth' => true]);
    $rutas->get("about", "/about", [IndexController::class, "aboutAction"]);
    $rutas->get("contactos", "/contactos", [IndexController::class, "contactoAction"]);


    // $router = new Router();
    // $router->add(array(
    //     "name" => "home", // Nombre de la ruta
    //     "path" => "/^\/$/", // Expresión regular con la que extraemos la ruta de la URL
    //     "action" => [IndexController::class, "indexAction"], // Clase y metedo que se ejecuta cuando se busque esa ruta
    //     "auth" => ["invitado", "usuario"]) // Perfiles de autenticación que pueden acceder
    // );

    // $request = $_SERVER['REQUEST_URI']; // Recoje URL
    $route = $router->getMatcher()->match($request);
    
    if (!$route) {
    
        exit(http_response_code(404));
    }

    // var_dump($handlerData);
    // $actionName = $handlerData[1];  
    // $controller = new $handlerData[0];
    // $response = $controller->$actionName($request);

    $handler = $route->handler;
    $needsAuth = $handler['auth'] ?? false;
    if ($_SESSION['perfil'] != "Invitado") {
        $needsAuth = false;
    }
    if ($needsAuth == true && $_SESSION['perfil'] == "Invitado") {
        header("Location: /login");
        exit;
    } 

    $controller = new $handler[0];
    $action = $handler[1];
    $response = $controller->$action($request);
    echo $response->getBody();
    