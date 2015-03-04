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

?>