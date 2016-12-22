<?php


class Controller
{

    public function __construct()
    {

//        $login_session_duration = 86400;
//        if(isset($_SESSION['loggedin_time']) and isset($_SESSION["user_id"])){
//            if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){
//                Session::destroy();
//            }
//        }
        
        $this->view = new View();
    }


}