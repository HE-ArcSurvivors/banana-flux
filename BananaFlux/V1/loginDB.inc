<?php

require "valid.inc";

class login_DB{

	protected $_db;
    protected $_id;
    
	protected static $users;

   public function __construct($db)
   {
	   $this->_db = $db;
   }
   
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
        $sql = 'SELECT count(*) FROM user WHERE (
        user_login = "'.mysqli_escape_string($this->_db, $id).'"
        AND user_password = "'.mysqli_escape_string($this->_db, $pw).'")';
            
	   $result = mysqli_query($this->_db, $sql);

	   if(!$result)
	   {
			echo "Connection error: ".mysqli_connect_errno();
	   }
	   else
	   {
	   		$row = mysqli_fetch_array($result);
	   		return ($row[0] == 1);
	   }   
       
	   return 0;
       
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
   		return valid($id, '^[a-zA-Z0-9]+$');
   }
}
?>