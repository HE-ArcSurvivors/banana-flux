<?php

require "valid.inc";

class login {
   # héritable par une classe fille, sinon inaccessible
   protected $_id;

   # on pourrait stocker hash(password) pour plus de sécurité
   # (static == variable de classe et non pas d'objet)
   protected static $users = array("1" => "truc", "2" => "demo");
   
   public function logout()
   { 
   	unset($_SESSION["login"]);
   	unset($this->_id);
   }
   
   public function connect($id, $pw)
   {
   
      if ($this->verify_user($id, $pw))
      {
         $this->_id = $id;

         $_SESSION["login"] = $id;

         return 1;
      }

      return 0;
   }

   public function verify_user($id, $pw)
   {
      return isset(self::$users[$id]) && (self::$users[$id] == $pw);
   }


   public function has_logon()
   {
      if (isset($_SESSION["login"]))
      {
         $this->_id = $_SESSION["login"];
         return 1;
      }

      return 0;
   }

   public function get_id()
   {
   		return $this->_id;
   }
   public function valid_id($id)
   { 
   		return valid($id, '^[0-9]+$');
   }
}


class login_DB extends login {
   private $_db;

   function __construct($db)
   {
	   $_db = $db;
   }
   
   public function verify_user($id, $pw)
   {
   	  $sql = "SELECT `pseudo`, `pass` FROM user WHERE user_id= '$id'";
   	  
   	  
   	  if (!($resource = mysqli_query($_db, $sql))) 
   	  {
			return false;
	  }
   	  if(mysqli_num_rows($resource) != 1)
   	  {
	   	  	return false;
   	  }
   	  else
   	  {
	   	  $row = mysqli_fetch_assoc($resource);
	   	  
	   	  if($row['pass'] == $pw) #ENCODER !
	   	  {
		   	 return true; 
	   	  }
   	  }
   	  
   	  
   	  
      return 
   }
}

?>