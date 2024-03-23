<?php 

namespace app\traits;

use core\Twig;

trait View
{
    /**
     *  @return object Retorna o objeto twig 
     */
    private function twig()
    {
        $twig = new Twig;

        $loadTwig = $twig->loadTwig();

        $twig->loadFunctions();

        return $loadTwig;
    }

    /**
     *  @return mixed
     */
    public function view($data, $view): mixed
    {
        $template = $this->twig()->load(str_replace('.', '/', $view) . '.html');
        return $template->display($data);
    }
}