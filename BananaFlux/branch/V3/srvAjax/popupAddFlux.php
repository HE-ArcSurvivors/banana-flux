<?php
	require_once "../header.php";
	?>
	
	<script type="text/javascript">
	
	$(document).ready(function() {
		
		var searchKeyword;
						
		$.post('srvAjax/popupAddFluxSearch.php', { keywords: searchKeyword }, function(data) {
			$('p#searchResult').empty();
			$.each(data, function()
			{
			$('p#searchResult').append('<div class="select_flux"><h1>' + this.title + '</h1><p>' + this.url + '</p><div class="hidden_idflux">' + this.id + '</div></div>');
			});
							
		}, "json");
		
		$('#addFluxPopup-searchbar-input').on('input', function() {
			searchKeyword = $(this).val();
			
			if (searchKeyword.length > 0)
			{
			
				$.post('srvAjax/popupAddFluxSearch.php', { keywords: searchKeyword }, function(data) {
					$('p#searchResult').empty();
					$.each(data, function()
					{
					$('p#searchResult').append('<div class="select_flux"><h1>' + this.title + '</h1><p>' + this.url + '</p><div class="hidden_idflux">' + this.id + '</div></div>');
					});
							
				}, "json");
			}
			
		});
	});
	</script>
	
<?php

	function affFlux($db, $filter)
	{

		/*$arr = array();
		$sql = "SELECT feed_id, feed_title, feed_url FROM feed WHERE feed_title LIKE '%".$keywords."%'";
		$result = $db->query($sql) or die($mysqli->error);
		
		if ($result->num_rows > 0) {
			
			while ($obj = $result->fetch_object()){
				$arr[] = array('type' => "FLUX TITLE", 'searchStatus' => "done", 'url' => $obj->feed_url, 'title' => $obj->feed_title, 'karma' => $karma, 'id' => $obj->feed_id);
				}
		}*/

		if (!isset($filter))
		{
		
			$sql = "SELECT feed_id, feed_title, feed_url FROM feed WHERE feed_title ORDER BY feed_title ASC";
		
			$resource = mysqli_query($db, $sql);
		
			if(!$resource)
			{
				return $lang["CONNECTION_FAILED"].mysqli_connect_errno();
			}
			else
			{
				$flux= "";
			
				while ($record = mysqli_fetch_assoc ($resource))
				{
					$flux_id =$record['feed_id'];
					$flux_title =$record['feed_title'];
					$flux_url =$record['feed_url'];
				
					$flux .= printflux($flux_id, $flux_title, $flux_url);
				}
			
				return $flux;
			}
		}
		else
		{
			
		}
	}
	

	function printflux($flux_id, $flux_title, $flux_url)
	{
		return '<div class="select_flux"><h1>'.$flux_title.'</h1><p>'.$flux_url.'</p><div class="hidden_idflux">'.$flux_id.'</div></div>';
	}
	
	function getFolders($user_id, $db)
	{
		$sql= 'SELECT `folder`.`folder_id`, `folder`.`folder_name` FROM `folder`, `user`
WHERE `folder`.`user_id` = `user`.`user_id` AND `user`.`user_login` = "'.$user_id.'" ORDER BY `folder`.`folder_name` ASC';
	
	$resource = mysqli_query($db, $sql);
	
		if(!$resource)
		{
			return $lang["CONNECTION_FAILED"].mysqli_connect_errno();
		}
		else
		{
			$folders = "";
			
			$curentFolder_id=null;
			while ($record = mysqli_fetch_assoc ($resource))
			{
				$folder_id =$record['folder_id'];
				$folder_name =$record['folder_name'];
				
				$folders.='<input type="radio" id="'.$folder_id.'" class="folder_radioInput" name="addFluxPopup_folder" value="'.$folder_id.'"/><label for="'.$folder_id.'">'.$folder_name.'</label>';
			}
			
			return $folders;
		}
	}
	
	if(isset($_SESSION["login"]))
	{
    	$user = new User($db, $lang);
    	$user->loadUser();
    	
    	
    	echo
		'<h1>'.$lang["ADD_A_FLUX"].'</h1>
		
		<h2>'.$lang["FOLDER"].'</h2>

		<div class="popup_content">
		<p>
			'.getFolders($user->getUsername(), $db).'
		</p>
		</div>
		
		<h2>'.$lang["SELECT_A_FLUX"].'</h2>
		
		<div id="searchbar" align="center">
		<form method="post" role="form">
       		<input type="text" id="addFluxPopup-searchbar-input" name="searchbar-input" placeholder="Filter with title" />
       		<button id="searchbar-button" display="none">Search</button>
       	</form>
       	</div>
       	
       	<br/>
		
		<div class="popup_content" id = "box_select_flux">
		<p id="searchResult">
		
		</p>
		</div>
		
		<p class="boutonStyle addFluxPopup_addFluxURL">'.$lang["I_DONT_FIND"].'</p>
		<p class="boutonStyle close_popup">'.$lang["ABORT"].'</p>
		';
    	
    }	
    else
    {
    	header('Location: index.php');
	}

	
	
	
	
?>