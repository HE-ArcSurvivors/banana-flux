<?php 

require "header.php";

if(isset($_SESSION["login"]))
{
    $user = new User($db, $lang);
    $user->loadUser();
    
}
else
{
	header('Location: index.php');
}

?>

<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
   <head>
   	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
   	  
   	        <title><?php echo $lang["WEBSITE_NAME"]; ?> <?php echo $lang["WEBPAGE_SEPARATOR"]; ?> <?php echo $lang["WEBPAGE_HOME"]; ?></title>
   	        
   	        <link rel="stylesheet" href="styles/font-awesome.min.css"/>
   	        <link rel="stylesheet" href="styles/bananaStyle.css"/>
   	        <script type="text/javascript" src="scripts/jquery-2.1.3.min.js"></script>
   	        <script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
   	        
   	        <script type="text/javascript" src="scripts/bananaflux.js"></script>
   </head>

   <body>

       <div id="headbar">
           <div id="headbar-left"><h1><?php echo $lang["WEBSITE_NAME"]; ?></h1></div>
           <div id="headbar-right">
               <ul id="navbar">
                    <li><img src="<?php echo $user->getIcon(); ?>" />
                        <ul>
                            <li><a href="editProfile.php">Editer mon profil</a></li>
                            <li><a href="index.php?action=disconnect">Déconnection</a></li>
                        </ul></li>
                </ul>
           </div>
       </div>

      
      <!--<div id="headfilters">
      	
      	<div id="filters">
      	
      	</div>
      	<div id="bottom">
      		<span id="showfilters">D</span>
      	</div>
      	
      </div>-->
      
      <div id="leftFlap">
		   <div id="leftFlap_Content">
			   <h1><?php echo $lang["FLUX_FOLDERS"]; ?></h1>
			   <h2><?php echo $lang["FLUX_PERSONAL"]; ?></h2>
			   
			   
			   
			   <!--
			   <div class="dossier">
				   <div class="dossierHead">
					   <p>Un dossier</p>
				   		<span class="control_elementLeftFlap">
				   			<span class="open fa fa-plus-square-o"></span>
				   			<span class="edit fa fa-pencil-square-o"></span>
				   			<span class="suppr fa fa-times"></span>
				   		</span>
				   		<span class="iddossier_hidden">1</span>
				   </div>
				   
				   <div class="flux">
			   		<p>20 Minutes</p>
			   		<span class="control_elementLeftFlap">
			   			<span class="edit fa fa-pencil-square-o"></span>
			   			<span class="suppr fa fa-times"></span>
			   		</span>
			   		<span class="idflux_hidden">1</span>
			   		</div>
			   		
			   		<div class="flux">
			   		<p>Jeux video</p>
			   		<span class="control_elementLeftFlap">
			   			<span class="edit fa fa-pencil-square-o"></span>
			   			<span class="suppr fa fa-times"></span>
			   		</span>
			   		<span class="idflux_hidden">1</span>
			   		</div>
			   		
			   </div>
			   -->
			   
			   <div id="dossiers_user">

			   </div>
			   <p class="addFlux boutonStyle">Ajouter un flux</p>
			   
			   <h2><?php echo $lang["FLUX_DEFAULT"]; ?></h2>
			   
			   <h1><?php echo $lang["FLUX_FLUX"]; ?></h1>
			   
			   <!--
			   <div class="flux">
			   		<p>20 Minutes</p>
			   		<span class="control_elementLeftFlap">
			   			<span class="edit fa fa-pencil-square-o"></span>
			   			<span class="suppr fa fa-times"></span>
			   		</span>
			   		<span class="idflux_hidden">1</span>
			   </div>
			   <div class="flux">
			   		<p>Jeux video</p>
			   		<span class="control_elementLeftFlap">
			   			<span class="edit fa fa-pencil-square-o"></span>
			   			<span class="suppr fa fa-times"></span>
			   		</span>
			   		<span class="idflux_hidden">2</span>
			   </div>
			   -->
	
		   </div>
		   <div id="leftFlap_Bouton"><p><?php echo $lang["FLUX_OPEN"]; ?></p></div>
	  </div>
	      
	  <div id="articles">
	      	<!-- Feed me with articles ! -->
	  </div>
      
      <div class="blocend"></div> <!-- Stop the evil float -->

     
      <!-- Popups -->
     <div id="popup_addflux" class="popup_block">
	 </div>   </body>
</html>