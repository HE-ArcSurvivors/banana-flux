<?php

require "header.php";

$user = new User($db);

if(isset($_POST['action']))
{          
    if($_POST['action']=="login")
    {
        print "Margaux <3";
    }
    elseif($_POST['action']=="signup")
    {
        $login = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        
        print "Banana, Connection People: <br>";
        if ($login != "" && $pass != "" && $email != "")
        {
          $message = $user->signUpUser($login, md5($pass), $email);
        }
        else
        {
          $message = "To signup fill all the fields.";
        }
    }
}


echo '<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="bananaWithStyle.css"/>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">

</style>  
  <script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
  <title>Banana Flux - Welcome</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
</head>
<body>
 <b>'.$message.'</b>
<div id="tabs" style="width: 480px;">
  <ul>
    <li><a href="#tabs-1">Login</a></li>
    <li><a href="#tabs-2" class="active">Signup</a></li>
    
  </ul>                 
  <div id="tabs-1">
  <form action="" method="post">
    <p><input id="email" name="email" type="text" placeholder="Email"></p>
    <p><input id="password" name="password" type="password" placeholder="Password">
    <input name="action" type="hidden" value="login" /></p>
    <p><input type="submit" value="Login" /></p>
  </form>
  </div>
  <div id="tabs-2">
    <form action="" method="post">
    <p><input id="username" name="username" type="text" placeholder="Username"></p>
    <p><input id="email" name="email" type="text" placeholder="Email"></p>
    <p><input id="password" name="password" type="password" placeholder="Password">
    <input name="action" type="hidden" value="signup" /></p>
    <p><input type="submit" value="Signup" /></p>
  </form>
  </div>
</div>';
?>