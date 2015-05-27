<?php

require_once "../header.php";
	
$action = htmlentities($_POST['action']);
$folder_id = htmlentities($_POST['folder_id']);
$flux_id = htmlentities($_POST['flux_id']);
    
if($action == "print")
{
    $sql = "";
    
    if($flux_id == NULL)
    {
        $sql = "SELECT DISTINCT tag.tag_name AS tag_name FROM tag, feed_folder_tag, feed_folder WHERE tag.tag_id = feed_folder_tag.tag_id 
        && feed_folder_tag.feed_folder_id = feed_folder.feed_folder_id 
        && feed_folder.folder_id = ".$folder_id;
    }
    else if($folder_id == NULL)
    {
        $sql = "SELECT DISTINCT tag.tag_name AS tag_name FROM tag, feed_folder_tag, feed_folder WHERE tag.tag_id = feed_folder_tag.tag_id 
        && feed_folder_tag.feed_folder_id = feed_folder.feed_folder_id 
        && feed_folder.feed_id = ".$flux_id;
    }
    
    $result = mysqli_query($db, $sql);

    if(!$result)
    {
        return $lang["CONNECTION_FAILED"].mysqli_connect_errno();
    }
    else
    {
        while ($record = mysqli_fetch_assoc ($result))
        {
            echo '<div class="tagBox">';
            echo $record["tag_name"];
            
            if($flux_id == NULL) { echo '<span class="deleteTag fa fa-times"></span>'; }
            echo '</div>';
        }
    }
}
?>