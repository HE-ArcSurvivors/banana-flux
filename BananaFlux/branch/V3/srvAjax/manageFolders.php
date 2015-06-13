<?php
	require_once "../header.php";
	
	$action = htmlentities($_POST['action']);
    
    if($action == "deleteFolder")
    {
        $id_folder= $_POST['id'];
        $sqlCheckEmpty = 'SELECT COUNT(*) FROM feed_folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
        $resultCheckEmpty = mysqli_query($db, $sqlCheckEmpty);
        
        $nbFeed = mysql_fetch_row($resultCheckEmpty); 
        
        if($nbFeed[0] != 0) 
        {
            $sqlEmpty = 'DELETE FROM feed_folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
            $resultEmpty = mysqli_query($db, $sqlEmpty);

            if(mysqli_affected_rows($db) < 0)
            {
                echo $db->error;
            }
        }
        
        $sql = 'DELETE FROM folder WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
        $result = mysqli_query($db, $sql);

        if (mysqli_affected_rows($db) > 0)
        {            
            echo "SUCCESS";
        }
        else 
        {
            echo $db->error;
        } 
    }
    else if($action == "editFolder")
    {
        $id_folder= htmlentities($_POST['id']);
	   $folder_name = htmlentities($_POST['folder_name']);
       
       $sql = 'UPDATE folder SET folder_name = "'.mysqli_escape_string($db, $folder_name).'" 
       WHERE folder_id = "'.mysqli_escape_string($db, $id_folder).'"';
            
       $result = mysqli_query($db, $sql);

        if ($result)
        {            
            echo "SUCCESS";
        }
        else 
        {
            echo $db->error;
        } 
    }
    else if($action == "addFolder")
    {
        if(isset($_SESSION["login"]))
        {
            $user = new User($db, $lang);
            $user->loadUser();
        }
        else
        {
            return "ERROR_UNLOGGED";
        }        
        
        $folder_name = $_POST['folder_name'];
        
        $sql = 'INSERT INTO `folder` (`folder_name`, `user_id`) VALUES ("'.mysqli_escape_string($db, $folder_name).'",'.$user->getID().')';
        $result = mysqli_query($db, $sql);
        
        if(!$result)
        {
            echo "Erreur".$db->error;
        }
        else
        {
            echo "SUCCESS";
        }
    }
?>