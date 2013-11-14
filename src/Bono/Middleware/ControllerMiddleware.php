<?php

namespace Bono\Middleware;

class ControllerMiddleware extends \Slim\Middleware {
    public function call() {
        $config = $this->app->config('bono.controllers');
        $mapping = $config['mapping'];

        $resourceUri = $this->app->request->getResourceUri();

        foreach ($mapping as $uri => $Map) {
            if (strpos($resourceUri, $uri) === 0) {
                if (is_null($Map)) {
                    $Map = $config['default'];
                }
                $controller = new $Map($this->app, $uri);
                break;
            }
        }

        $this->next->call();
    }
}