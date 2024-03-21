<?php

namespace core;

use app\classes\Uri;
use app\exceptions\MethodNotExistException;

class Method
{
    private $uri;

    /**
     *  PT-BR # Pega a uri da requisição
     *  EN # Get the uri of the request
     */
    public function __construct()
    {
        $this->uri = Uri::uri();
    }

    /**
     *  PT-BR # Verifica se o método existe
     *  EN # Checks if the method exists
     *  @return string Retorna uma string com o método se existir
     */
    public function load($controller): string
    {
        $method = $this->getMethod();

        if(! method_exists($controller, $method)) {
            throw new MethodNotExistException("Esse método não existe: {$method}");
        }

        return $method;
    }

    /**
     *  PT-BR # Verifica se a uri do método foi passada
     *  EN # Checks if the method uri was passed
     *  @return string Retorna uma string com o método.
     */
    private function getMethod(): string
    {
        if (substr_count($this->uri, '/') > 1) {

            $uriExplode = array_values(array_filter(explode('/', $this->uri)));

            if (! empty($uriExplode[1])) {

                list($controller, $method) = array_values(array_filter(explode('/', $this->uri)));

            } else {

                $method = 'index';
            }

           return $method;
        }

        return 'index';
    }
}
