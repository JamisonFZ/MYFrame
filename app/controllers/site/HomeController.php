<?php

namespace app\controllers\site;

class HomeController
{
    public function index()
    {
        echo 'index';
    }

    public function show($request)
    {
        dd($request);
    }
}
