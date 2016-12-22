<?php

class UserModel extends Model
{
    /**
     * @param $username
     * @return bool
     */
    public function validateUsername($username){
        if(preg_match('/^[A-Za-z0-9]{6,16}$/', $username))
            return true;
        return false;
    }

    /**
     * @param $username
     * @return bool
     */
    public function validateUsernameUnique($username){
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data = $stmt->fetchColumn();
        if($data)
            return false;
        return true;
    }

    /**
     * @param $fullname
     * @return bool
     */
    public function validateFullname($fullname){
        if(preg_match('/^[A-Za-z\s]{6,32}$/', $fullname))
            return true;
        return false;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password){
        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/', $password))
            return true;
        return false;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public  function authentication($username, $password, $remember){
        $sql = "SELECT user_id, full_name FROM users WHERE  username = :username AND password = MD5(:password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $data = ($stmt->fetch());
        if ($data['user_id']) {
            Session::init($remember);
            Session::set('loggedIn',true);
            Session::set('user_id',$data['user_id']);
            Session::set('full_name',$data['full_name']);
            Session::set('loggedin_time',time());
            return true;
        }
        else
            return false;
    }

    /**
     * @param $username
     * @param $fullname
     * @param $password
     * @return bool
     */
    public function registration($username, $fullname, $password){
        $sql = "INSERT INTO users(username, full_name, password) VALUES (:username, :fullname, MD5(:password));";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':fullname',$fullname);
        $stmt->bindParam(':password',$password);
        return $stmt->execute();
    }


}