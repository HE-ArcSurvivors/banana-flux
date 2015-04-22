<?php

//require_once "loginDB.inc";
require_once "config.php";
require_once "user.php";

$lang = parse_ini_file("lang/FR-fr.ini");
    
$self_url = $_SERVER['PHP_SELF'];

session_start();
setcookie(session_name(), session_id(), time() + 3600);

#Connexion
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("failed at connection to the database, please verify the credentials in the config file or contact the support".mysqli_connect());

?>