<?php

class user {

    private $login;
    private $email;
    private $icon;

    protected static $users;

    public function __construct()
    {
	   
    }
   
    public function editEmail($email)
    {
       return true;
    }
    
    public function editPass($pass)
    {
       return true;
    }
    
    public function editIcon($icon)
    {
       return true;
    }
    
    public function logIn($login, $pass)
    {
       return true;
    }
    
    public function logOut()
    {
       return true;
    }
    
    public function isLogged()
    {
       return true;
    }
    
    private function verifyUser($login, $pass)
    {
       return true;
    }
}

?>