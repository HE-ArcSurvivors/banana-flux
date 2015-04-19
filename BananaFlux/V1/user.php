<?php

require_once "valid.inc";

class User {

    private $login;
    private $email;
    private $icon;
    
    private $lang;
    private $_db;

    public function __construct($db,$lang)
    {
        $this->_db = $db;
        $this->icon = "icon/default_icon_banana.png";
        $this->lang = $lang;
    }
    
    public function loadUser()
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
    
    public function getUsername()
    {
        return $this->_login;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function editEmail($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = 'UPDATE user SET user_email = "'.mysqli_escape_string($this->_db, $email).'" 
            WHERE user_login = "'.mysqli_escape_string($this->_db, $this->_login).'"';

            $result = mysqli_query($this->_db, $sql);

            if ($result === TRUE)
            {            
                $this->_email = $email; 
                return true;
            }
            else 
            {
                echo '<div class="informationBox warning">';
                echo $this->lang["ERROR_NUMBER"].' '.$this->_db->error.'</div>';
            }    
        }
        else
        {
            echo '<div class="informationBox warning">';
            echo $this->lang["EMAIL_UNVALID"];
            echo '</div>';
        }
    }
    
    public function editPass($passwordOLD,$passwordNEW)
    {
        if($this->checkCurrentPassword(md5($passwordOLD)))
        {
            $sql = 'UPDATE user SET user_password = "'.mysqli_escape_string($this->_db, md5($passwordNEW)).'" 
            WHERE user_login = "'.mysqli_escape_string($this->_db, $this->_login).'"';

            $result = mysqli_query($this->_db, $sql);

            if ($result === TRUE)
            {            
                return true;
            }
            else 
            {
                echo '<div class="informationBox warning">';
                echo $this->lang["ERROR_NUMBER"].' '.$this->_db->error.'</div>';
            }   
        }
        else
        {
            echo '<div class="informationBox warning">';
            echo $this->lang["EDIT_PASSWORD_OLD_NOTEQUAL"];
            echo '</div>';
        }
    }
    
    public function checkCurrentPassword($password)
    {
        $sql = 'SELECT count(*) FROM user WHERE (
        user_login = "'.mysqli_escape_string($this->_db, $this->_login).'"
        AND user_password = "'.mysqli_escape_string($this->_db, $password).'")';
        
        $result = mysqli_query($this->_db, $sql);
        
        if($result)
        {
            $row = mysqli_fetch_array($result);
            return ($row[0] == 1);   
        }
    }
    
    public function getIcon()
    {
        $sql = 'SELECT user_icon FROM user WHERE (user_login = "'.$this->_login.'")';
        
        $result = mysqli_query($this->_db, $sql);
        $row = mysqli_fetch_array($result);

        return $row["user_icon"];
    }
    public function editIcon($icon)
    {
       return true;
    }
    
    public function logIn($login, $pass)
    {
        if ($this->verify_user($login, $pass))
        {
            $_SESSION["login"] = $login;
            $this->loadUser();
            return 1;
        }
        return 0;
    }
    
    public function isLogged()
    {
        if (isset($_SESSION["login"]))
        {
            $this->_id = $_SESSION["login"];
            return 1;
        }
        return 0;
    }
        
    public function logOut()
    { 
        unset($_SESSION["login"]);
        unset($this->_id);
    }
    
    private function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            echo '<div class="informationBox warning">';
            echo $this->lang["SIGNUP_EMAIL_INVALID"];
            echo '</div>';
            
            return false;
        }
        else
        {
            $query = "SELECT COUNT(*) FROM user WHERE user_email = '".$email."'";
            $resource = mysqli_query($this->_db, $query);
            $row = mysqli_fetch_array($resource);
            if($row[0]>=1)
            {
                echo '<div class="informationBox warning">';
                echo $this->lang["SIGNUP_EMAIL_ALREADYUSED"];
                echo '</div>';
                return false;
            }
        }
        return true;
    }
    
    public function signUpUser($login, $pass, $email)
    {
        $login  = mysqli_real_escape_string($this->_db,$login);
        $email  = mysqli_real_escape_string($this->_db,$email);
        $pass   = mysqli_real_escape_string($this->_db,$pass);
        $icon   = $this->icon;
        
        $emailValidity = self::validateEmail($email);
            
        if (!$emailValidity)
        {
            return false;
        }
        else
        {
            $query = "INSERT INTO user(user_login,user_email,user_password,user_icon) VALUES('".$login."','".$email."','".$pass."','".$icon."')";
            $resource = mysqli_query($this->_db, $query);
            if(!$resource)
            {
                echo '<div class="informationBox warning">';
                echo $this->lang["ERROR_CONNECTION_NUMBER"].' '.mysqli_connect_errno();
                echo '</div>';
                return false;
            }
            else
            {
                echo '<div class="informationBox info">';
                echo $this->lang["SIGNUP_SUCCESS"];
                echo '</div>';
                return true;
            }
        }
    }

   public function verify_user($login, $password)
   {    
        $sql = 'SELECT count(*) FROM user WHERE (
        user_login = "'.mysqli_escape_string($this->_db, $login).'"
        AND user_password = "'.mysqli_escape_string($this->_db, $password).'")';
            
	   $result = mysqli_query($this->_db, $sql);

	   if(!$result)
	   {
            echo '<div class="informationBox warning">';
            echo $this->lang["ERROR_CONNECTION_NUMBER"].' '.mysqli_connect_errno();
            echo '</div>';
	   }
	   else
	   {
	   		$row = mysqli_fetch_array($result);
	   		return ($row[0] == 1);
	   }   
       
	   return 0;
       
   }

    public function valid_id($id)
    { 
   	    return valid($id, '^[a-zA-Z0-9]+$');
    }
}

?>