<?php


class ErrorController extends Controller
{

    /**
     * Error constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->msg = '404';
        $this->view->render('error');
    }
}