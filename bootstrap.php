<?php

/**
 *  bootstrap
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/functions/helpers.php';

use core\Connect;
use core\Controller;
use core\Method;
use core\Parameters;
use app\exceptions\SystemExecutionErrorException;

try {

    // Carregamento e execução da base de dados
    $database = Connect::load();

    // Carregamento dos controladores
    $controller = new Controller;
    $controller = $controller->load();

    // Carregamento dos métodos
    $method = new Method;
    $method = $method->load($controller);

    // Carregamento dos parametros
    $parameters = new Parameters;
    $parameters = $parameters->load();

    // execução do sistema
    $controller->$method($parameters);

} catch (SystemExecutionErrorException $error) {

    echo $error->getMessage();
    
}