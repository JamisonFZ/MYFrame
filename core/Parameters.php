<?php

namespace core;
use app\classes\Uri;

class Parameters
{
    private $uri;

    /**
     *  PT-BR # 
     *  EN #
     */
    public function __construct()
    {
        $this->uri = Uri::uri();
    }

    /**
     *  PT-BR # Carrega a função getParameter ao ser executada
     *  EN # Loads the getParameter function when executed
     *  @return null|object Retorno vazio ou um objeto
     */
    public function load()
    {
        return $this->getParameter();
    }
    
    /**
     *  PT-BR #  Verifica se o parâmetro foi enviado
     *  EN # Checks if the parameter was sent
     *  @return null|object Retorna vazio ou um objeto com base na verificação
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

    private function getNextParameter($actual)
    {
        $parameter = array_values(array_filter(explode('/', $this->uri)));

        return $parameter[$actual + 1] ?? $parameter[$actual];
    }

}
