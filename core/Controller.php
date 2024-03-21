<?php

namespace core;

use app\classes\Uri;
use app\exceptions\ControllerNotExistException;

class Controller
{
    private $uri;
    private $namespace;
    private $controller;
    private $folders = [
        'app\controllers\admin',
        'app\controllers\site'
    ];

    /**
     * PT-BR # Pega automaticamente a uri para instanciar o controlador.
     * EN # Automatically gets the uri to instantiate the controller.
     */
    public function __construct()
    {
        $this->uri = Uri::uri();
    }

    /**
     *  PT-BR # Carrega o controlador com base na uri.
     *  EN # Loads the controller based on the uri.
     *  @return object Retorna o objeto já instânciado.
     */
    public function load(): object
    {
        if ($this->isHome()) {
            return $this->controllerHome();
        }

        return $this->controllerNotHome();
    }

    /**
     *  PT-BR # Verifica se a uri retornou uma barra ou algo a mais.
     *  EN # Checks if the uri returned a slash or something else.
     *  @return bool Retorna verdadeiro ou falso para verificação.
     */
    private function isHome(): bool
    {
        return ($this->uri == '/');
    }

    /**
     * PT-BR # Verifica se o controlador existe e retorna um booleano.
     * EN # Checks if the controller exists and returns a boolean.
     * @param string $controllerName Nome do controlador para ser verificado.
     * @return bool Retorna verdadeiro ou falso para verificação.
     */
    private function controllerExist(string $controllerName): bool
    {
        $controllerExist = false;

        foreach ($this->folders as $folder) {
            if (class_exists($folder . '\\' . $controllerName)) {
                $this->namespace = $folder;
                $this->controller = $controllerName;

                $controllerExist = true;
            }
        }

        return $controllerExist;
    }

    /**
     *  PT-BR # Verifica a uri para retornar o controlador correspondente.
     *  EN # Checks the uri to return the corresponding controller.
     *  @return object Objeto instânciado é devolvido.
     */
    private function controllerHome(): object
    {
        if (! $this->controllerExist('HomeController')) {
            throw new ControllerNotExistException('Esse controller não existe');
        }

        return $this->instantiateController();
    }

    /**
     *  PT-BR # Instância um novo controlador.
     *  EN # Instance a new controller.
     *  @return object Objeto instânciado é devolvido.
     */
    private function instantiateController(): object
    {
        $controller = $this->namespace . '\\' . $this->controller;
        return new $controller;
    }

    /**
     *  PT-BR # Instancia controladores que não for o home.
     *  EN # Instantiate controllers other than home.
     *  @return object Retorna um objeto instânciado.
     */
    private function controllerNotHome(): object
    {
        $controller = $this->getControllerNotHome();

        if (! $this->controllerExist($controller)) {
            throw new ControllerNotExistException('Esse controller não existe');
        }

        return $this->instantiateController();
    }

    /**
     *  PT-BR # Retorna o nome do controlador diferente do home.
     *  EN # Returns the name of the controller other than home.
     *  @return string Retorna uma string com o nome do controlador
     */
    private function getControllerNotHome(): string
    {
        if (substr_count($this->uri, '/') > 1) {
            list($controller) = array_values(array_filter(explode('/', $this->uri)));
            return ucfirst($controller) . 'Controller';
        }

        return ucfirst(ltrim(Uri::uri(), '/') . 'Controller');
    }
}
