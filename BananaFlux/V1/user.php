<?php

class User {

    private $login;
    private $email;
    private $icon;
    
    private $_db;

    public function __construct($db)
    {
	      $this->_db = $db;
	      $this->icon = "https://s-media-cache-ak0.pinimg.com/236x/82/0f/52/820f526af6dc24cda8b67b3ddf688532.jpg"; //default icon
    }
    
    public function connect()
    {
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
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function editEmail($email)
    {
        $sql = 'UPDATE user SET user_email = "'.mysqli_escape_string($this->_db, $email).'" 
        WHERE user_login = "'.mysqli_escape_string($this->_db, $this->_login).'"';
            
	    $result = mysqli_query($this->_db, $sql);

        if ($result === TRUE)
        {
            echo '<div class="info">';
            echo 'Record updated successfully';
            echo '</div>';
            
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
    
    private function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            return "Invalid email address format!";
        }
        else
        {
            $query = "SELECT COUNT(*) FROM user WHERE user_email = '".$email."'";
            $resource = mysqli_query($this->_db, $query);
            $row = mysqli_fetch_array($resource);
            if($row[0]>=1)
            {
                return "Your email address <b>".$email."</b> is already registered.";
            }
        }
        return 1;
    }
    
    public function signUpUser($login, $pass, $email)
    {
        $login  = mysqli_real_escape_string($this->_db,$login);
        $email  = mysqli_real_escape_string($this->_db,$email);
        $pass   = mysqli_real_escape_string($this->_db,$pass);
        $icon   = $this->icon;
        
        $emailValidity = self::validateEmail($email);
            
        if ($emailValidity != 1)
        {
            return $emailValidity;
        }
        else
        {
            $query = "insert into user(user_login,user_email,user_password,user_icon) values('".$login."','".$email."','".$email."','".$icon."')";
            $resource = mysqli_query($this->_db, $query);
            if(!$resource)
            {
                return "Connection error: ".mysqli_connect_errno()." - Unable to contact the database.";
            }
            else
            {
                return "You are now Registred and you can Login with your username ".$login;
            }
        }
    }
    
    private function verifyUser($login, $pass)
    {
       return true;
    }
}

?>