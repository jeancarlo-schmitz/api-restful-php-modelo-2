<?php
namespace Presentation\Routes;

use Exception;
use Infrastructure\ExceptionHandler;
use Application\Exceptions\DuplicatedRouteException;

Class Route
{
    private $routes;

    private function get(string $uri, $handler)
    {
        $this->checksIfRouteIsAlreadyRegistered($uri, 'GET');
        $this->routes[$uri]['GET'] = $handler;
    }

    private function post(string $uri, $handler)
    {
        $this->checksIfRouteIsAlreadyRegistered($uri, 'POST');
        $this->routes[$uri]['POST'] = $handler;
    }

    private function put(string $uri, $handler)
    {
        $this->checksIfRouteIsAlreadyRegistered($uri, 'PUT');
        $this->routes[$uri]['PUT'] = $handler;
    }

    private function delete(string $uri, $handler)
    {
        $this->checksIfRouteIsAlreadyRegistered($uri, 'DELETE');
        $this->routes[$uri]['DELETE'] = $handler;
    }

    private function checksIfRouteIsAlreadyRegistered($route, $method){
        if(isset($this->routes[$route][$method])){
            throw new DuplicatedRouteException($route);
        }

        if($this->isRouteWithParams($route)){
            $this->checksIfRouteWithParamsIsAlreadyRegistered($route, $method);
        }
    }

    private function isRouteWithParams($route){
        return strpos($route, '{') !== false;
    }

    private function checksIfRouteWithParamsIsAlreadyRegistered($routeToVerify, $methodToVerify){
        $routeToVerifyWithoutParam = $this->getRouteWithoutParam($routeToVerify);

        foreach ($this->routes as $route => $dataMethod){
            if($this->isRouteWithParams($route)){
                $routeWithoutParam = $this->getRouteWithoutParam($route);
                if(isset($dataMethod[$methodToVerify]) && $routeWithoutParam === $routeToVerifyWithoutParam){
                    throw new DuplicatedRouteException($routeToVerify);
                }
            }
        }
    }

    private function getRouteWithoutParam($routeToVerify){
        preg_match("/(?<route>\/.*)(?<param>\{.*\})/", $routeToVerify, $results);

        return $results['route'];
    }

    public function getAllRoutes(){
        try {
            $this->addGetRoutes();
            $this->addPostRoutes();
            $this->addDeleteRoutes();
            $this->addPutRoutes();

            return $this->routes;
        }catch (Exception $e){
            $exceptionHandler = new ExceptionHandler();
            $response = $exceptionHandler->handle($e);
            $response->send();
        }
    }

    private function addGetRoutes(){
    }

    private function addPostRoutes(){
    }

    private function addDeleteRoutes(){
    }

    private function addPutRoutes(){
    }
}