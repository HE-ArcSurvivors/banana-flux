<?php
	require_once "../header.php";
	
	$action = htmlentities($_POST['action']);
	$id_folder= htmlentities($_POST['id']);
    
    if($action == "deleteFolder")
    {
        //NEED TO EMPTY LINKS BETWEEN FOLDERS AND FEED
        //NEED TO MOVE LOST FEED INTO DEFAULT FOLDER
        
        $sqlCheck = 'SELECT COUNT(*) FROM feed_folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
        $resultCheck = mysqli_query($db, $sqlCheck);
        $row = mysqli_fetch_array($resultCheck);
        
        if($row[0] == 0)
        {
            $sql = 'DELETE FROM folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
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
        else
        {
           echo '<div class="informationBox warning">Le dossier n\'est pas vide</div>';
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