<?php
# Pas de sortie HTML avant ce point, sinon problème avec les cookies!

# on nomme les fichiers .inc de manière à ce qu'ils ne soient pas
# directement exécutables. Leur code sera probablement visible via le
# serveur WWW, sans autre protection. Ne pas y mettre de mot de passe
# p.ex.!  ou alors protéger (via un .htaccess) ou appeler .php
require "login.inc";
require "loginDB.inc";

# supposé sûr
$self_url = $_SERVER['PHP_SELF'];

# Créer une nouvelle session si elle n'existe pas déjà. Contrairement
# à un cookie dont la valeur est directement contrôlable par
# l'utilisateur, les informations de session ne le sont pas.
session_start();

# Rafraîchir la variable de session
# (suppose que l'utilisateur accepte la session!)
setcookie(session_name(), session_id(), time() + 3600);

#Connexion
//if (!($db = mysqli_connect("localhost", "root", "root", "Serie9Ex1")) && !mysqli_connect_errno())
if (!($db = mysqli_connect("localhost", "root", "", "Serie9Ex1")) && !mysqli_connect_errno())
{
	echo "Erreur de connexion a la BDD"; #A revoir
}

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
else {
   if (isset($_POST['do_login']))
   {
      if (isset($_POST['id']) && $login->valid_id($_POST['id']) && isset($_POST['pw']))
      {
         if ($login->connect($_POST['id'], $_POST['pw']))
         {
            $id = $login->get_id();
         }
         else
         {
            $error = 'connexion échouée';
         }
      }
      else
      {
         $error = 'paramètres invalides';
      }
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>Démonstration</title>
   </head>
   <body>
<?php

# Très important que register_globals soit sur OFF!
if (isset($id)) {
   # l'utilisateur est connecté: affichage du menu
   ?>
   <h1>Menu principal pour <?php echo htmlentities($id); ?></h1>
   <ul>
      <li><a href="<?php echo $self_url . '?do_logout=1'; ?>">logout</a></li>
   </ul>
   <?php
}
else {
   # l'utilisateur doit se connecter
   if (isset($error)) {
      echo "<p>Erreur: <strong>" . htmlentities($error) . "</strong></p>";
   }
   ?>
   <div id="login">
      <p>Veuillez vous connecter</p>
      <form method="post" action="<?php echo $self_url; ?>">
         <div id="field_login">
   	    <label for="id">Login
               <input type="text" id="id" name="id" />
            </label>
         </div>
         <div id="field_pw">
   	    <label for="pw">Password
               <input type="password" id="pw" name="pw" />
            </label>
         </div>
	 <div id="field_submit">
            <input type="submit" />
	    <input type="hidden" name="do_login" value="1" />
         </div>
      </form>
   </div>
<p>
   <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
</p>
   <?php
}
?>

   </body>
</html>