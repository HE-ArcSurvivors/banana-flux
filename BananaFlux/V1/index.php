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
                $error = 'Connexion échouée';
             }
        }
        else
        {
            $error = 'Paramètres invalides, le login est numérique';
        }
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

?>

<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="styles/bananaWithStyle.css"/>
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

<?php
 echo '<b>'.$message.'</b>';
?>
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
      <form action="" method="post">
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
