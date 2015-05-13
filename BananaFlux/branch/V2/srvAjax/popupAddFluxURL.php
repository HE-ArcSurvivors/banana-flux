<?php
	require_once "../header.php";
	
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
			
			while ($record = mysqli_fetch_assoc ($resource))
			{
				$folder_id =$record['folder_id'];
				$folder_name =$record['folder_name'];
				
				$folders.='<input type="radio" id="'.$folder_id.'" class="folder_radioInput" name="addFluxURLPopup_folder" value="'.$folder_id.'"/><label for="'.$folder_id.'">'.$folder_name.'</label>';
			}
			
			return $folders;
		}
	}
	
	function getTags($db)
	{
		$sql= 'SELECT `tag_id`, `tag_name` FROM `tag`';
		
		$resource = mysqli_query($db, $sql);
	
		if(!$resource)
		{
			return $lang["CONNECTION_FAILED"].mysqli_connect_errno();
		}
		else
		{
			$tags = "";
			
			while ($record = mysqli_fetch_assoc ($resource))
			{
				$tag_id =$record['tag_id'];
				$tag_name =$record['tag_name'];
				
				$tags.='<input type="checkbox" id="'.$tag_id.'" class="tags_checkboxInput" name="addFluxURLPopup_tag" value="'.$tag_id.'"/><label for="'.$tag_id.'">'.$tag_name.'</label>';
			}
			
			return $tags;
		}
	}
	
	if(isset($_SESSION["login"]))
	{
    	$user = new User($db, $lang);
    	$user->loadUser();
    }	
    else
    {
    	header('Location: index.php');
	}
	
	
	echo '
<h1>'.$lang["ADD_A_FLUX"].'</h1>

<h2>'.$lang["FOLDER"].'</h2>

<div class="popup_content">
<p>
	'.getFolders($user->getUsername(), $db).'
</p>
</div>

<h2>'.$lang["ADD_FLUX_GLOBAL_TAG"].'</h2>

<div class="popup_content">
<p>
	'.getTags($db).'
</p>
</div>
 
<h2>
	<label for="flux_name">'.$lang["ADD_FLUX_NAME"].'</label>
</h2>

<div class="popup_content">
<p>
	<input type="text" id="addFluxPopup_flux_name" class="inputTextStyle" name="flux_name"/>
</p>
</div>

<h2>
	<label for="flux_url">'.$lang["ADD_FLUX_URL"].'</label>
</h2>

<div class="popup_content">
<p>
	<input type="text" id="addFluxPopup_flux_url" class="inputTextStyle" name="flux_url"/>
</p>
</div>

<p class="boutonStyle addFluxURLpopup_Ajouter">'.$lang["ADD"].'</p>
<p class="boutonStyle close_popup">'.$lang["ABORT"].'</p>';

?>
