<?php
	require_once "../header.php";
	
	$flux_dossier_id=@$_POST['iddossier'];
	$flux_name=@$_POST['nomflux'];
	$flux_URL=@$_POST['urlflux'];
	
	
	if(isset($_SESSION["login"]))
	{
    	$user = new User($db, $lang);
    	$user->loadUser();
    	
    	addFluxURL($user->getUsername(), $db, $flux_name, $flux_URL, $flux_dossier_id);
    	echo "ok";
    }	
    else
    {
    	header('Location: index.php');
	}
		
	
	function addFluxURL($user_name, $db, $flux_name, $flux_URL, $flux_dossier_id)
	{
		$sql= "INSERT INTO `bananafluxbdd`.`feed` (`feed_id`, `feed_title`, `feed_url`) VALUES (NULL, '$flux_name', '$flux_URL');";
	
		$resource = mysqli_query($db, $sql);
	
		if(!$resource)
		{
			echo $lang["URL_EXIST"];
		}
		else
		{
			$sql="INSERT INTO `bananafluxbdd`.`feed_folder` (`feed_folder_id`, `feed_id`, `folder_id`) VALUES (NULL, (SELECT `feed_id` FROM `feed` WHERE `feed_url` = '$flux_URL'), '$flux_dossier_id');";
			
			$resource = mysqli_query($db, $sql);
	
			if(!$resource)
			{
				echo "ERROR INCONITO";
			}
		}
	}
	
	


?>