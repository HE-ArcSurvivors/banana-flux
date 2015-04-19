<?php

require "header.php";

$user = new User($db,$lang);
$login = new login_DB($db);

if(isset($_POST['action']))
{          
    if($_POST['action']=="login")
    {
        //print "Margaux <3";
        if (isset($_POST['username']) && $login->valid_id($_POST['username']) && isset($_POST['password']))
        {
             if ($login->connect($_POST['username'], md5($_POST['password'])))
             {
                echo "OK";
                //$id = $login->get_id();
                //$user = new user($db);
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
<link rel="stylesheet" href="bananaWithStyle.css"/>
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

<?php
 //echo '<b>'.$message.'</b>';
?>
    
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