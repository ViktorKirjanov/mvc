<?php

class UserController extends Controller
{


    public function signup()
    {
        $user = new UserModel();
        $errors = array();
        $signupResult = false;

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $fullname = $_POST['fullname'];
            $password = $_POST['password'];

            if (!$user->validateUsername($username)) {
                $errors[] = EMAIL_PREG_ERROR;
            }
            if (!$user->validateUsernameUnique($username)) {
                $errors[] = FULLNAME_IN_USE_ERROR;
            }
            if (!$user->validateFullname($fullname)) {
                $errors[] = FULLNAME_PREG_ERROR;
            }
            if (!$user->validatePassword($password)) {
                $errors[] = PASSWORD_PREG_ERROR;
            }
            if (!$errors) {
                $signupResult = $user->registration($username, $fullname, $password);
            }
        }
        $this->view->errors = $errors;
        $this->view->signupResult = $signupResult;
        $this->view->render('/user/signup');
    }

    public function login()
    {
        $user = new UserModel();
        $remember = false;
        $errors = array();

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (isset($_POST['remember'])) {
                $remember = true;
            }
            if (!$user->validateUsername($username)) {
                $errors[] = EMAIL_PREG_ERROR;
            }
            if (!$user->validatePassword($password)) {
                $errors[] = PASSWORD_PREG_ERROR;
            }
            if (!$user->authentication($username, $password, $remember)) {
                $errors[] = WRONG_USERNAME_OR_PASSWORD;
            } else {
                header("Location: /");
            }
        }
        $this->view->errors = $errors;
        $this->view->render('user/login');
    }

    public function logout()
    {
        Session::destroy();
        header("Location: /");

    }

}