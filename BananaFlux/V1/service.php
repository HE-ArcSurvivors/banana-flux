<?php
require "header.php";

$login = new login_DB($db);

# L'utilisateur est-il déjà connecté ?
if ($login->has_logon())
{
   if (isset($_GET['do_logout']))
   {
      $login->logout();
   }
   else 
   {
      $id = $login->get_id();
   }
}
else
{
   if (isset($_POST['do_login']))
   {
       if (isset($_POST['id']) && $login->valid_id($_POST['id']) &&     isset($_POST['pw']))
      {
         if ($login->connect($_POST['id'], md5($_POST['pw'])))
         {
            $id = $login->get_id();
             //$user = new user($db);
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
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Banana Flu(x)</title>
   </head>
   <body>
<?php

# Très important que register_globals soit sur OFF!
if (isset($id))
{
   # l'utilisateur est connecté: affichage du menu
?>
   <h1>Menu principal pour <?php echo htmlentities($id); ?></h1>
   <ul>
      <li><a href="<?php echo $self_url . '?do_logout=1'; ?>">logout</a></li>
       <li><a href="editProfile.php">Modifier son profil</a></li>
   </ul>
<?php
}
else
{
   if (isset($error))
   {
      echo "<p>Erreur: <strong>" . htmlentities($error) . "</strong></p>";
   }
?>
   <div id="login">

       <form method="post" action="<?php echo $self_url; ?>">

       <table>
            <tr>
                <td><label for="id">Login</label></td>
                <td><input type="text" id="id" name="id" /></td>
            </tr>
            <tr>
                <td><label for="pw">Password</label></td>
                <td><input type="password" id="pw" name="pw" /></td>
            </tr>
            <tr>
                <td></td>
                <td align="center"><input type="submit" /></td>
            </tr>   
        </table>
           
        <input type="hidden" name="do_login" value="1" />
    </form>
</div>

<?php
}

mysqli_close($db);

?>

   </body>
</html>