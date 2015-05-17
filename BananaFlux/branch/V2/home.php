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
   	        <script type="text/javascript" src="scripts/bananaflux.js"></script>
			<script type="application/javascript">
            var jLang = "<?php echo json_encode($lang); ?>";
            </script>
            <script type="text/javascript">
            
            function shortcutAddFlux(title, url)
			{
				//document.getElementById("superTest").innerHTML = title+" "+url;
				
									
				jQuery.ajax({
					type: 'POST',
					url: 'srvAjax/popupAddFluxURL.php',
					data : {'name': title.replace(/ /gi,"-"), 'url': url},
       				
					
					success: function(data, textStatus, jqXHR) {
						showPopup("popup_addfluxURL", data, 650);
					},
										
					error: function(jqXHR, textStatus, errorThrown) {
						alert("erreur PopupAddFluxURL");
					}
				});
			}
							
            var queryDDBLenght = 3;
            
			$(document).ready(function() {
				$('#searchbar-input').on('input', function() {
					var searchKeyword = $(this).val();
					if (searchKeyword.length < queryDDBLenght || document.getElementById("articles").style.display == "none") {
						$('tr#searchbar-search-results').empty();
						document.getElementById("articles").style.display = "initial";
						//document.getElementById("searchbar-result-table").style.display = "none";
					}
					if (searchKeyword.length >= queryDDBLenght) {
						
						$.post('srvAjax/search.php', { keywords: searchKeyword }, function(data) {
							
							
							if (data[0].searchStatus == "done")
							{
						
								document.getElementById("articles").style.display = "none";
								$('tr#searchbar-search-results').empty();
								$('tr#searchbar-search-results').append("<p> <?php echo $lang['SEARCH_DETECTED_TYPE']; ?>" + data[0].type);
								$('tr#searchbar-search-results').append('<tr><td>'+ "<?php echo $lang['SEARCH_FEED_NAME']; ?>" + '</td>' + '<td>' + "<?php echo $lang['SEARCH_FEED_URL']; ?>" + '</td>' + '<td>' + "<?php echo $lang['SEARCH_FEED_KARMA']; ?>" + '</td>' + '<td>' + "<?php echo $lang['SEARCH_OPTIONS']; ?>" + '<td><tr>');
								$.each(data, function() {
									$('tr#searchbar-search-results').append('<tr><td>' + this.title + '</td>' + 
									'<td>' + this.url + '</td>' + 
									'<td>' + this.karma + '</td>' + 
									'<td>' + "<button class=\"boutonStyle\" onclick='shortcutAddFlux(\""+this.title+"\",\""+this.url+"\")'><?php echo $lang['SEARCH_ADD_THE_FEED']; ?></button>" +'</td>' + 
									/*'<td>' + "<button class= 'boutonStyle' type='button' onclick='alert(\"I am an alert box!\")><?php //echo $lang['SEARCH_ADD_THE_FEED']; ?></button>" +'</td>' + */
									/*'<td>' + "<p class='boutonStyle shortcutAddFlux'><?php //echo $lang['SEARCH_ADD_THE_FEED']; ?></p>" +'</td>' + */
									'</td></tr>');
									//showPopup("popup_addfluxURL", data, 650);
									
								});
								
								
								
								//var preFilledData = {preFillName:"test",preFillURL:"testURL"};
								
								/*$.post('srvAjax/popupAddFluxURL.php', { preFilledData: preFilledData }, function(data) {
											showPopup("popup_addfluxURL", data, 650);
										
								}, "json");*/
								
								
								/*$('.shortcutAddFlux').on('click', function(){
									
									 //prefilled Array
									var preFilledData = {preFillName:"test",preFillURL:"testURL"}; 
									
									jQuery.ajax({
										type: 'POST',
										url: 'srvAjax/popupAddFluxURL.php',
										data: preFilledData,
					
										success: function(data, textStatus, jqXHR) {
											showPopup("popup_addfluxURL", data, 650);
										},
										
										error: function(jqXHR, textStatus, errorThrown) {
											alert("erreur PopupAddFluxURL");
										}
									});
								});*/
								
							}
							
						}, "json");
					}
				});
			});
	</script>   </head>

   <body>
   	<!--<p id="superTest">TEST</p>-->

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
       	
       	<table id="searchbar-result-table">
    		<thead id="searchbar-search-td">
        		<tr id="searchbar-search-results">
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
			   <p class="addFlux boutonStyle"><?php echo $lang["ADD_A_FEED"]; ?></p>
			   <p class="addFolder boutonStyle"><?php echo $lang["CREATE_A_FOLDER"]; ?></p>
			   
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
     <div id="popup_newFolder" class="popup_block"></div>
       
      <!-- MANAGE PROFIEL -->
       <div id="popup_editProfile" class="popup_block"></div>

</body>
</html>