<?php

/**
 * Created by PhpStorm.
 * User: Creed
 * Date: 8.12.16
 * Time: 13:01
 */
class Bootstrap
{

    private $routes;

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {

        $url = $this->getUri();
        $url = explode('/', $url);

        if (empty($url[0])) {
            require CONTROLLER_DIR . DS . 'IndexController.php';
            $controller = new IndexController();
            $controller->index();
            return false;
        }

        $file = CONTROLLER_DIR . DS .  ucfirst($url[0]) . 'Controller.php';
        if (file_exists($file)) {
            require $file;
        } else {
            $this->error();
            return false;
        }

        $controllerName = ucfirst($url[0]) . 'Controller';
        $controller = new $controllerName;

        // calling methods
        if (isset($url[3])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2],$url[3]);
            } else {
                $this->error();
            }
        }else {
            if (isset($url[2])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2]);
                } else {
                    $this->error();
                }
            } else {
                if (isset($url[1])) {
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();
                    } else {
                        $this->error();
                    }
                } else {
                    $controller->index();
                }
            }
        }
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/  ');
        }
    }

    function error() {
        $controller = new ErrorController();
        $controller->index();
        return false;
    }
}