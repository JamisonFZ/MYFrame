<?php

namespace core;
use app\classes\Uri;

class Parameters
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
     *  PT-BR # Carrega a função getParameter ao ser executada
     *  EN # Loads the getParameter function when executed
     *  @return null|object
     */
    public function load()
    {
        return $this->getParameter();
    }
    
    /**
     *  PT-BR #  Verifica se o parâmetro foi enviado
     *  EN # Checks if the parameter was sent
     *  @return null|object
     */
    private function getParameter(): null|object
    {
        if (substr_count($this->uri, '/') > 2) {
            $parameter = array_values(array_filter(explode('/', $this->uri)));
            
            return (object) [
                'parameter' => htmlspecialchars($parameter[2]),
                'next' => htmlspecialchars($this->getNextParameter(2))
            ];    
        }

        return null;
    }

    /**
     *  PT-BR # Verifica se o segundo parâmetro foi enviado
     *  EN # Checks if the second parameter was sent
     *  @return string
     */
    private function getNextParameter($actual): string
    {
        $parameter = array_values(array_filter(explode('/', $this->uri)));

        return $parameter[$actual + 1] ?? $parameter[$actual];
    }

}