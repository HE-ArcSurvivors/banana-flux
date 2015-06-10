<?php
	
	require_once "../header.php";

$action = $_POST['action'];
$feed_folder_id = $_POST['id'];
    
if($action == "deleteFeed")
{
    $sql = 'DELETE FROM feed_folder WHERE feed_folder_id = "'.mysqli_escape_string($db, $feed_folder_id).'"';
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
?>