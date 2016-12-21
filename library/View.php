<?php

class View
{
    public $msg;

    /**
     * View constructor.
     */
    public function __construct()
    {

    }

    public function render($view)
    {
        require(VIEW_DIR . '/templates/header.php');
        require(VIEW_DIR . DS . $view . '.php');
        require(VIEW_DIR . '/templates/footer.php');
    }
}