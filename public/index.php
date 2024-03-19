<?php

/**
 *  index
 */

require __DIR__ . '/../bootstrap.php';

use core\Controller;

try {

    $controller = new Controller;
    $controller = $controller->load();
    
    dd($controller);

} catch (\Exception $e) {
    echo $e->getMessage();
}