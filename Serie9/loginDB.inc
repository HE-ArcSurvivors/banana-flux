<?php

class login_DB extends login {
   private $_db;

   function __construct($db)
   {
	   $this->_db = $db;
   }
   
   public function verify_user($id, $pw)
   {
   	  $sql = "SELECT `pseudo`, `pass` FROM user WHERE user_id= '$id'";
   	  
   	  if (!($resource = mysqli_query($this->_db, $sql))) 
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
   	  
      return true;
   }
}
?>