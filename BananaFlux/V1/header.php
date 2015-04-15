<?php

require_once "loginDB.inc";
require_once "config.php";

$self_url = $_SERVER['PHP_SELF'];

session_start();
setcookie(session_name(), session_id(), time() + 3600);

#Connexion
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("failed at".mysqli_connect());

?>