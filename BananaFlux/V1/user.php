<?php

class User {

    private $login;
    private $email;
    private $icon;
    
    private $_db;

    public function __construct($db)
    {
	   $this->_db = $db;
       $this->_login = $_SESSION["login"];
           
       $sql = 'SELECT user_email, user_icon FROM user WHERE (
        user_login = "'.mysqli_escape_string($this->_db, $this->_login).'")';
            
	   $result = mysqli_query($this->_db, $sql);

	   if(!$result)
	   {
			echo "Connection error: ".mysqli_connect_errno();
	   }
	   else
	   {
	   		$row = mysqli_fetch_array($result);
            $this->_email = $row["user_email"];
            $this->_icon = $row["user_icon"];
	   }   
    }
   
    public function printUser()
    {
        echo '<p>Username: '.$this->_login.'<br>';
        echo 'Email: '.$this->_email.'<br>';
        echo 'Icon: '.$this->_icon.'<br></p>';
    }
    
    public function editEmail($email)
    {
        $sql = 'UPDATE user SET user_email = "'.mysqli_escape_string($this->_db, $email).'" 
        WHERE user_login = "'.mysqli_escape_string($this->_db, $this->_login).'"';
            
	    $result = mysqli_query($this->_db, $sql);

        if ($result === TRUE)
        {
            echo "Record updated successfully";
            $this->_email = $email; 
        }
        else 
        {
            echo "Error updating record: " . $this->_db->error;
        }
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