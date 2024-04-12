<?php

namespace core;

use Closure;

class Twig
{
    private $twig;
    private $functions = [];

    /**
     * PT-BR # Instância um novo objeto com as configurações de ambiente do twig.
     * EN # Instantiate a new object with twig environment settings.
     * @return object
     */
    public function loadTwig(): object
    {
        $this->twig = new \Twig\Environment($this->loadViews(), [
            // 'cache' => '',
        ]);

        return $this->twig;
    }

    /**
     *  PT-BR # Instância um novo objeto com o caminho para pasta views.
     *  EN # Instance a new object with the path to views folder.
     *  @return object
     */
    private function loadViews(): object
    {
        return new \Twig\Loader\FilesystemLoader('../app/views');
    }

    /**
     *  PT-BR # Instância uma nova função para o twig.
     *  EN # Instantiate a new function for twig.
     *  @param string $functionName
     *  @param Closure $callback
     *  @return object
     */
    private function functionsToView(string $functionName, Closure $callback)
    {
        return new \Twig\TwigFunction($functionName, $callback);
    }

    /**
     *  PT-BR # Carrega todas as funções para o twig através de array.
     *  EN # Load all functions into twig through array.
     *  @return void
     */
    public function loadFunctions(): void
    {
        require '../app/functions/twig.php';

        foreach ($this->functions as $key => $value) {

            $this->twig->addFunction($this->functions[$key]);
            
        }
    }
}