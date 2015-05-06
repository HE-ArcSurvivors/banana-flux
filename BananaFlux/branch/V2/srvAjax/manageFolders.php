<?php
	require_once "../header.php";
	
	$action = htmlentities($_POST['action']);
	$id_folder= htmlentities($_POST['id']);
    
    if($action == "deleteFolder")
    {
        $sqlEmpty = 'DELETE FROM feed_folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
        $resultEmpty = mysqli_query($db, $sqlEmpty);
        
        if(mysqli_affected_rows($db) > 0)
        {
            $sql = 'DELETE FROM folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
            $result = mysqli_query($db, $sql);

            if (mysqli_affected_rows($db) > 0)
            {            
                echo true;
            }
            else 
            {
                echo $db->error;
            } 
        }
        else
        {
            echo $db->error;
        }
    }
    else if($action == "editFolder")
    {
	   $folder_name = htmlentities($_POST['folder_name']);
       
       $sql = 'UPDATE folder SET folder_name = "'.mysqli_escape_string($db, $folder_name).'" 
       WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
            
       $result = mysqli_query($db, $sql);

        if ($result === TRUE)
        {            
            echo true;
        }
        else 
        {
            echo $db->error;
        } 
    }

    
?>