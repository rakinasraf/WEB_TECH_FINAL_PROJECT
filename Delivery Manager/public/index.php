<?php

session_start();

require_once "../config/config.php";

require_once "../core/Database.php";
require_once "../core/Controller.php";
require_once "../core/Model.php";

require_once "../routes/web.php";

/* =====================================
GET URL
===================================== */

$url = isset($_GET['url'])
    ? rtrim($_GET['url'], '/')
    : '';

/* =====================================
CHECK ROUTE EXISTS
===================================== */

if(array_key_exists($url, $routes))
{
    $controllerName = $routes[$url]['controller'];
    $methodName = $routes[$url]['method'];

    require_once "../app/controllers/" .
        $controllerName . ".php";

    $controller = new $controllerName();

    if(method_exists($controller, $methodName))
    {
        $controller->$methodName();
    }
    else
    {
        die("Method Not Found");
    }
}
else
{
    die("404 Page Not Found");
}

?>