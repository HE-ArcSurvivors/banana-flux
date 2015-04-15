<?php 
require "header.php";

if(isset($_SESSION["login"]))
{
    $user = new User($db);
    
    $user->printUser();
    $user->editEmail("margaux.blabla@gmail.com");
    $user->printUser();
}
    
    

?>