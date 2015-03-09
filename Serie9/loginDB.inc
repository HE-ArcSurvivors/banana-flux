<?php

require "login.inc";

class login_DB extends login {

	protected $_db;

	protected static $users;

   public function __construct($db)
   {
	   $this->_db = $db;
   }
   
   public function verify_user($id, $pw)
   {
   	  /*$sql = "SELECT `pseudo`, `pass` FROM user WHERE user_id= '$id'";
   	  
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
	   	  
	   	  if($row['pass'] ==  md5($pw))
	   	  {
		   	 return true; 
	   	  }
	   	  else
	   	  {
		   	 return false;
	   	  }
   	  }*/

	   #SELECT user_id FROM user WHERE (user_id = $id AND pass = '$pw')
	   #$sql = "SELECT user_id FROM user WHERE (user_id = "$id" AND pass = '"mysqli_escape_string($this->_db, $pw)"')";
	   $sql = "SELECT user_id FROM user WHERE (user_id = "
		   . $id
		   . " AND pass = '"
		   . mysqli_escape_string($this->_db, $pw)
		   . "')";
	   printf($sql);

	   $resource = mysqli_query($this->_db, $sql);
	   if(!$resource){
		   echo "connection Error".mysqli_connect_errno();
	   }
	   printf($resource);

	   if($resource = mysqli_query($this->_db, $sql)) {
		   printf("in if");
		   return (mysqli_num_rows($resource) == 1);
	   }

	   printf("not in if");

	   return 0;
   }
}
?>