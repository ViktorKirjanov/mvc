<?php

function __autoload($classname)
{

    $paths = array(
        'controllers',
        'models',
        'library'
    );

    foreach ($paths as $path) {

        $path = $path . DS . $classname . '.php';
        if (file_exists($path))
            include_once($path);
    }
}
