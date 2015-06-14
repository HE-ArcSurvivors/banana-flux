<?php
	require_once "../header.php";
	
	$flux_dossier_id=@$_POST['iddossier'];
	$flux_id=@$_POST['idflux'];
	
	
	function addFlux($user_id, $db, $flux_id, $flux_dossier_id)
	{
		$flux_dossier_id = mysqli_escape_string($db, $flux_dossier_id);
		$flux_id = mysqli_escape_string($db, $flux_id);
		
		$sql="INSERT INTO `bananafluxbdd`.`feed_folder` (`feed_folder_id`, `feed_id`, `folder_id`) VALUES (NULL, '$flux_id', '$flux_dossier_id');";
		
		$resource = mysqli_query($db, $sql);

		if(!$resource)
		{
			return $lang["INSERT_UNKNOWN_ERROR"];
		}
		else
		{
			return "ok";
		}
	}
	
	if(isset($_SESSION["login"]))
	{
    	$user = new User($db, $lang);
    	$user->loadUser();
    	
    	echo addFlux($user->getUsername(), $db, $flux_id, $flux_dossier_id);
    }	
    else
    {
    	header('Location: index.php');
	}	

?>