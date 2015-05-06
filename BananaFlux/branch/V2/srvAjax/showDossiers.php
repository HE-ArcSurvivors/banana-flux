<?php
	require_once "../header.php";
	
	
	function printFeed($user, $db)
	{
		$sql= 'SELECT `folder`.`folder_id`, `folder`.`folder_name`, `feed`.`feed_id`, `feed`.`feed_title`, `feed`.`feed_url` FROM `feed`, `feed_folder`, `folder`, `user`
	WHERE `feed`.`feed_id` = `feed_folder`.`feed_id` AND `feed_folder`.`folder_id` = `folder`.`folder_id` AND `folder`.`user_id` = `user`.`user_id` AND `user`.`user_login` = "'.$user->getUsername().'" ORDER BY `folder`.`folder_name` ASC';
	
		
		$resource = mysqli_query($db, $sql);
		
		if(!$resource)
		{
			return $lang["CONNECTION_FAILED"].mysqli_connect_errno();
		}
		else
		{
			$toShow = "";
			
			if(mysqli_num_rows($resource)>0)
			{
				$curentFolder_id=null;
				while ($record = mysqli_fetch_assoc ($resource))
				{
					if($record['folder_id']!=$curentFolder_id)
					{
						//end old folder
						if($curentFolder_id != null)
						{
							$toShow.="</div>";
						}
						
						$curentFolder_id =$record['folder_id'];
						
						//new folder
                        $toShow .='<div class="dossier">
                           <div class="dossierHead">
                                <p class="nameFolder">'.$record['folder_name'].'</p>
                                <span class="control_elementLeftFlap">
                                    <span class="open fa fa-plus-square-o"></span>
                                    <span class="editFolder edit fa fa-pencil-square-o"></span>
                                    <span class="deleteFolder suppr fa fa-times"></span>
                                </span>
                                <span class="iddossier_hidden">'.$record['folder_id'].'</span>
                           </div>';
					}
					
					//print flux
					
					$toShow .='<div class="flux">
					   		<p>'.$record['feed_title'].'</p>
					   		<span class="control_elementLeftFlap">
					   			<span class="edit fa fa-pencil-square-o"></span>
					   			<span class="suppr fa fa-times"></span>
					   		</span>
					   		<span class="idflux_hidden">'.$record['feed_id'].'</span>
					   		</div>';
					 
				}
				
				$toShow.="</div>"; //close the last folder
			}
			
			return $toShow;
		}
	
	}
	
	
	if(isset($_SESSION["login"]))
	{
	    $user = new User($db, $lang);
	    $user->loadUser();
	    
	    echo printFeed($user, $db);
	}
	else
	{
		header('Location: index.php');
	}
	
		
?>