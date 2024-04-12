<?php 

namespace app\traits;

use core\Twig;

trait View
{
    /**
     *  PT-BR # Instancia um novo objeto twig e carrega suas funções se houver.
     *  EN # Instantiates a new twig object and loads its functions if any.
     *  @return object
     */
    private function twig(): object
    {
        $twig = new Twig;

        $loadTwig = $twig->loadTwig();

        $twig->loadFunctions();

        return $loadTwig;
    }

    /**
     *  PT-BR # Método para receber o array com dados e qual view exibir.
     *  EN # Method to receive the array with data and which view to display.
     *  @return mixed
     */
    public function view($data, $view): mixed
    {
        $template = $this->twig()->load(str_replace('.', '/', $view) . '.html');
        return $template->display($data);
    }
}