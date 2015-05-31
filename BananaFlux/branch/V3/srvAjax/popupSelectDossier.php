<?php
	require_once "../header.php";
	
/*	$prefilledName = $_POST['name'];*/
	$prefilledName = $db->real_escape_string($_POST['name']);
/*	$prefilledURL = $_POST['url'];*/
	$prefilledURL = $db->real_escape_string($_POST['url']);
	$prefilledID = $_POST['id'];
	
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
				
				$folders.='<input type="radio" id="'.$folder_id.'" class="folder_radioInput" name="popupSelectDossier_folder" value="'.$folder_id.'"/><label for="'.$folder_id.'">'.$folder_name.'</label>';
			}
			
			return $folders;
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

<div class="popup_content">
<p>
	'.$prefilledName.'<br/>
	'.$prefilledURL.'
</p>
</div>

<p id="popupSelectDossier_id">
	'.$prefilledID.'
</p>

<h2>'.$lang["FOLDER"].'</h2>

<div class="popup_content">
<p>
	'.getFolders($user->getUsername(), $db).'
</p>
</div>

 


<p class="boutonStyle popupSelectDossier_Ajouter">'.$lang["ADD"].'</p>
<p class="boutonStyle close_popup">'.$lang["ABORT"].'</p>';

?>
