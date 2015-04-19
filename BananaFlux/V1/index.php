<?php

require "header.php";

$user = new User($db,$lang);

if(isset($_POST['action']))
{    
    $action = htmlentities($_POST["action"]);
    if($action=="login")
    {
        if (isset($_POST['username']) && $user->valid_id($_POST['username']) && isset($_POST['password']))
        {
             if ($user->login($_POST['username'], md5($_POST['password'])))
             {
                header('Location: home.php');   
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
    elseif($action=="signup")
    {
        $login = $_POST['username'];
        $pass = $_POST['password'];
        $email = $_POST['email'];
        
        if ($login != "" && $pass != "" && $email != "")
        {
            if($user->signUpUser($login, md5($pass), $email))
            {
                if($user->login($login, md5($pass)))
                {
                    header('Location: home.html'); 
                }
            }
        }
        else
        {
            echo '<div class="informationBox warning">';
            echo $lang["SIGNUP_FAILED_MISSINGVALUE"];
            echo '</div>';
        }
    }
    
}

if(isset($_GET['action']))
{
    $action = htmlentities($_GET["action"]);
    if($action == "signout")
    {
        echo '<div class="informationBox warning">DECONNECTION';
        //echo $lang["SIGNUP_FAILED_MISSINGVALUE"];
        echo '</div>';
        $user->signOut();
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
<style>
.centerHorizontal {
  margin-left: auto;
  margin-right: auto;
}
.centerVertical {
  position: relative;
  top: 20%;
  transform: translateY(-20%);
}
</style>
</head>
<body background = "images/banana_orgie.jpg">

<div class="centerVertical">
  <center><h1>The Banana Flu(x)</h1></center>
  <div id="tabs" class="centerHorizontal" style="width: 480px;">
    <ul>
    <li><a href="#tabs-1">Login</a></li>
    <li><a href="#tabs-2" class="active">Signup</a></li>
    
    </ul>                 
    <div id="tabs-1">
      <form action="" method="post">
        <table class="loginSignUpTable">
          <tr>
            <td>
              <p><input id="username" name="username" type="text" placeholder="Username"></p>
            </td>
          </tr>
          <tr>
            <td>
              <p><input id="password" name="password" type="password" placeholder="Password"></p>
              <input name="action" type="hidden" value="login" /></p>
            </td>
          </tr>
          <tr>
            <td>
              <p><input type="submit" value="Login" /></p>
            </td>
          </tr>
        </table>
      </form>
    </div>
  
    <div id="tabs-2">
      <form action="#tabs-2" method="post">
        <table class="loginSignUpTable">
          <tr>
            <td>
              <p><input id="username" name="username" type="text" placeholder="Username"></p>
            </td>
          </tr>
          <tr>
            <td>
              <p><input id="email" name="email" type="text" placeholder="Email"></p>
            </td>
          </tr>
          <tr>
            <td>
              <p><input id="password" name="password" type="password" placeholder="Password">
              <input name="action" type="hidden" value="signup" /></p>
            </td>
          </tr>
          <tr>
            <td>
              <p><input type="submit" value="Signup" /></p>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <center><h6>Credits to Margaux Divernois, Steve Visinand, Roman Yakovenko</h6></center>
</div>    
