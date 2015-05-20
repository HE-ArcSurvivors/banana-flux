<?php
	require_once "../header.php";
	
	$flux_dossier_id=@$_POST['iddossier'];
	$flux_name=@$_POST['nomflux'];
	$flux_URL=@$_POST['urlflux'];
	
	$tags=@json_decode($_POST['tagsids']);

	
	
	if(isset($_SESSION["login"]))
	{
    	$user = new User($db, $lang);
    	$user->loadUser();
    	
    	echo addFluxURL($user->getUsername(), $db, $lang, $flux_name, $flux_URL, $flux_dossier_id, $tags);
    	
    }	
    else
    {
    	header('Location: index.php');
	}
		
	
	function addFluxURL($user_name, $db, $lang, $flux_name, $flux_URL, $flux_dossier_id, $tags)
	{
		$sql= "INSERT INTO `bananafluxbdd`.`feed` (`feed_id`, `feed_title`, `feed_url`) VALUES (NULL, '$flux_name', '$flux_URL');";
	
		$resource = mysqli_query($db, $sql);
	
		if(!$resource)
		{
			return $lang["URL_EXIST"];
		}
		else
		{
			$sql="INSERT INTO `bananafluxbdd`.`feed_folder` (`feed_folder_id`, `feed_id`, `folder_id`) VALUES (NULL, (SELECT `feed_id` FROM `feed` WHERE `feed_url` = '$flux_URL'), '$flux_dossier_id');";
			
			$resource = mysqli_query($db, $sql);
	
			if(!$resource)
			{
				return $lang["INSERT_UNKNOWN_ERROR"];
			}
			else
			{
				//ajout des tags
				$error ="";
				foreach ($tags as $tag_id)
				{
					$sql = "INSERT INTO `bananafluxbdd`.`feed_tag_defaut` (`feed_tag_id`, `tag_id`, `feed_id`) VALUES (NULL, '$tag_id', (SELECT `feed_id` FROM `feed` WHERE `feed_url` = '$flux_URL'));";
					
					$resource = mysqli_query($db, $sql);
	
					if(!$resource)
					{
						$error.=$lang["INSERT_UNKNOWN_ERROR"];
					}
				
				}
				
				if($error == "")
				{
					return "ok";
				}
				else
				{
					return $error;
				}
			}
		}
	}
	
	


?>