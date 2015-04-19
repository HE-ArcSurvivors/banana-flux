<?php

require "header.php";

$user = new User($db,$lang);

if(isset($_POST['action']))
{          
    if($_POST['action']=="login")
    {
        if (isset($_POST['username']) && $user->valid_id($_POST['username']) && isset($_POST['password']))
        {
             if ($user->login($_POST['username'], md5($_POST['password'])))
             {
                header('Location: editProfile.php');   
             }
             else
             {
                echo '<div class="informationBox warning">';
                echo $lang["CONNECTION_FAILED"];
                echo '</div>';
             }
        }
        else
        {
            echo '<div class="informationBox warning">';
            echo $lang["CONNECTION_FAILED_INVALID_LOGIN"];
            echo '</div>';
        }
    }
    elseif($_POST['action']=="signup")
    {
        $login = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        
        if ($login != "" && $pass != "" && $email != "")
        {
            $user->signUpUser($login, md5($pass), $email);
        }
        else
        {
            echo '<div class="informationBox warning">';
            echo $lang["SIGNUP_FAILED_MISSINGVALUE"];
            echo '</div>';
        }
    }
}

?>

<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="styles/bananaStyle.css"/>
<script src="scripts/modernizr.custom.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>  

<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>

<title>Banana Flux - Welcome</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
</head>
<body>
    
<div id="tabs" style="width: 480px;">
  <ul>
    <li><a href="#tabs-1">Login</a></li>
    <li><a href="#tabs-2" class="active">Signup</a></li>
    
  </ul>                 
  <div id="tabs-1">
  <form action="" method="post">
    <p><input id="username" name="username" type="text" placeholder="Username"></p>
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
</div>