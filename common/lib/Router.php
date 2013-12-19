<?php

/**
 * FastMVC Core
 *
 * by kyozhou@sina.com
 * at 20130613
 */
class Router {
    
    private $root = null;

    function __construct($appRoot) {
        $this->root = $appRoot;
    }

    function action() {
        $request = array_merge($_GET, $_POST);
        unset($request['c']);
        
        $controllerName = !empty($_GET['c']) ? $_GET['c'] : 'index/index';

        $controllerArray = explode('/', $controllerName);
        $controllerClass = !empty($controllerArray[0]) ? $controllerArray[0] : 'index';
        $this->nameFormat($controllerClass, true);
        $controllerClass = file_exists($this->root . "/controller/C$controllerClass.php") ? 'C' . $controllerClass : 'Index';

        include $this->root . '/controller/' . $controllerClass . '.php';
        $controllerMethod = !empty($controllerArray[1]) ? $controllerArray[1] : 'index';
        $this->nameFormat($controllerMethod, false);
        if (strtolower($controllerClass) === strtolower($controllerMethod) || in_array(strtolower($controllerMethod), array('list', 'print'))) {
            $controllerMethod = "_$controllerMethod";
        }
        $controller = new $controllerClass();
        if (method_exists($controller, $controllerMethod)) {
            $controller->$controllerMethod();
        } else {
            die();
        }
    }

    //index_list -> IndexList
    private function nameFormat(&$name, $isClass = true) {
        $nameArray = explode('_', $name);
        $nameTemp = '';
        foreach ($nameArray as $index => $namePart) {
            if ($index === 0 && !$isClass) {
                $nameTemp .= $namePart;
            } else {
                $nameTemp .= ucfirst($namePart);
            }
        }
        $name = $nameTemp;
    }
}
