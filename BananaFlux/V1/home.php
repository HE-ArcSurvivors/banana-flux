<?php 

require "header.php";

if(isset($_SESSION["login"]))
{
    $user = new User($db, $lang);
    $user->loadUser();
    
    $dossiers = printFeed($user, $db); 
}
else
{
	header('Location: index.php');
}


function printFeed($user, $db)
{
	$sql= 'SELECT `folder`.`folder_id`, `folder`.`folder_name`, `feed`.`feed_id`, `feed`.`feed_title`, `feed`.`feed_url` FROM `feed`, `feed_folder`, `folder`, `user`
WHERE `feed`.`feed_id` = `feed_folder`.`feed_id` AND `feed_folder`.`folder_id` = `folder`.`folder_id` AND `folder`.`user_id` = `user`.`user_id` AND `user`.`user_login` = "'.$user->getUsername().'" ORDER BY `folder`.`folder_name` ASC';

	
	$resource = mysqli_query($db, $sql);
	
	if(!$resource)
	{
		echo "Connection error: ".mysqli_connect_errno();
	}
	else
	{
	   	$row = mysqli_fetch_array($resource);
	   	
	   	print_r($row);
	}


}

?>

<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
   <head>
   	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
   	  
   	        <title>Banana Flux - home</title>
   	        
   	        <link rel="stylesheet" href="styles/font-awesome.min.css"/>
   	        <link rel="stylesheet" href="styles/bananaStyle.css"/>
   	        <script type="text/javascript" src="scripts/jquery-2.1.3.min.js"></script>
   	        <script type="text/javascript" src="scripts/jquery.easing.1.3.js"></script>
   	        
   	        <script type="text/javascript" src="scripts/bananaflux.js"></script>
   	        
   </head>

   <body>
      
      <div id="headbar">
      	<h1>Banana Flux</h1>
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
			   <h1>Dossiers</h1>
			   <h2>Personnels</h2>
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
			   
			   <h2>Par défaut</h2>
			   
			   <h1>Flux</h1>
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
	
		   </div>
		   <div id="leftFlap_Bouton"><p>Ouvrir</p></div>
	  </div>
	      
	  <div id="articles">
	      	<!-- Feed me with articles ! -->
	  </div>
      
      <div class="blocend"></div> <!-- Stop the evil float -->

      
   </body>
</html>