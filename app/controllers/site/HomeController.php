<?php

namespace app\controllers\site;

use app\controllers\ContainerController;

class HomeController extends ContainerController
{

    public function index()
    {
        $this->view([
            'home' => 'Meu projeto',
            'description' => 'descrição do projeto'
        ], 'site.home');
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function destroy()
    {

    }

}