<?php

namespace lib;

class Router
{
    static $found = "false";

    static function get($route, $func)
    {
        Router::manageMethod($route, $func, 'GET');
    }

    static function post($route, $func)
    {
        Router::manageMethod($route, $func, 'POST');
    }

    static function delete($route, $func)
    {
        Router::manageMethod($route, $func, 'DELETE');
    }

    static function put($route, $func)
    {
        Router::manageMethod($route, $func, 'PUT');
    }

    static function notFound($func)
    {
        if (Router::$found == false) {
            echo $func();
        }
    }

    static private function manageMethod($route, $func, $method)
    {
        if ($_SERVER['REQUEST_METHOD'] === $method) {
            $routeParamsOrFound = Router::findMatch($route);
            if ($routeParamsOrFound != "not found") {
                Router::printJSONResponse($func, $routeParamsOrFound);
            }
        }
    }

    static private function findMatch($route)
    {
        $routeParams = Router::matchRouteAndGetParams($route);
        if ($routeParams != "not found") {
            Router::$found = true;
            return $routeParams;
        } else {
            return "not found";
        }
    }

    static private function matchRouteAndGetParams($route)
    {
        $match = true;
        $routeParams = [];
        $routeParts = explode("/", $route);
        $pathParts = explode("/", $_SERVER['REQUEST_URI']);
        if (count($routeParts) != count($pathParts)) {
            return;
        }
        for ($i = 0; $i < count($routeParts); $i++) {
            if ($routeParts[$i] != $pathParts[$i]) {
                if (substr($routeParts[$i], 0, 1) == "{" && substr($routeParts[$i], -1, 1) == "}") {
                    if ($pathParts[$i] != "") {
                        $routeParams[] = $pathParts[$i];
                    } else {
                        $match = false;
                    }
                } else {
                    $match = false;
                }
            }
        }
        if ($match) {
            return $routeParams;
        } else {
            return "not found";
        }
    }

    static private function printJSONResponse($func, $routeParams)
    {
        header('Content-Type: application/json');
        if (is_array(($routeParams))) {
            echo json_encode($func(...$routeParams));
        } else {
            echo json_encode($func());
        }
    }
}
