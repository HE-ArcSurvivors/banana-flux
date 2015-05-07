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
   	        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
   	        
            <script type="text/javascript" src="scripts/manageFolders.js"></script>
            <script type="text/javascript" src="scripts/manageProfile.js"></script>
   	        <script type="text/javascript" src="scripts/bananaflux.js"></script>
<script type="application/javascript">
            var jLang = <?php echo json_encode($lang); ?>;
            </script><script type="text/javascript">
			$(document).ready(function() {
				$('#searchbar-input').on('input', function() {
					var searchKeyword = $(this).val();
					if (searchKeyword.length >= 3) {
						$.post('srvAjax/search.php', { keywords: searchKeyword }, function(data) {
							$('tr#searchResults').empty()
							$('tr#searchResults').append('<tr><td>' + "ID" + '</td>' + '<td>' + "Name" + '<td><tr>');
							$.each(data, function() {
								$('tr#searchResults').append('<tr><td>' + this.id + '</td>' + '<td>' + this.title + '<td><tr>');
							});
						}, "json");
					}
				});
			});
	</script>   </head>

   <body>

       <div id="headbar">
           <div id="headbar-left"><h1><?php echo $lang["WEBSITE_NAME"]; ?></h1></div>
           <div id="headbar-right">
               <img src="menu/editProfile.png" class="editProfileButton" />
               <a href="index.php?action=disconnect"><img src="menu/exit.png" alt="Déconnection" /></a>
           </div>
       </div>
       
       
		<div id="searchbar" align="center">
		<form method="post" role="form">
       		<input type="text" id="searchbar-input" name="searchbar-input" placeholder="Search by title, #topic or URL" />
       		<button id="searchbar-button" display="none">Search</button>
       	</form>
       	</div>
       	
       	<table align="center">
    		<thead>
        		<tr id="searchResults" align="center">
        		</tr>
		    </thead>
    	<tbody></tbody>
		</table>

      
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
				   <!-- ici les dossiers -->
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
     <div id="popup_addflux" class="popup_block"></div>
     <div id="popup_addfluxURL" class="popup_block"></div>
       
     <!-- MANAGE FOLDERS -->
     <div id="popup_editFolder" class="popup_block"></div>
     <div id="popup_deleteFolder" class="popup_block"></div>  
       
      <!-- MANAGE PROFIEL -->
       <div id="popup_editProfile" class="popup_block"></div>

</body>
</html>