<?php

require_once "../header.php";
require_once "../folder.php";
	
$action = $_POST['action'];
$folder_id = $_POST['folder_id'];
$flux_id = $_POST['flux_id'];
    
if($action == "print")
{
    $sql = "";
    
    if($flux_id == NULL)
    {
        /*$sql = "SELECT DISTINCT tag.tag_name AS tag_name FROM tag, feed_folder_tag, feed_folder WHERE tag.tag_id = feed_folder_tag.tag_id 
        && feed_folder_tag.feed_folder_id = feed_folder.feed_folder_id 
        && feed_folder.folder_id = ".$folder_id;*/
        
        $folder = new Folder($folder_id, $db, $lang);
        $array = $folder->getTagList();
        
        foreach ($array as $tag_name)
        {
            echo '<div class="tagBox">';
            echo $tag_name;
            echo '</div>';
        }
        
    }
    else if($folder_id = NULL)
    {
        $sql = "SELECT DISTINCT tag.tag_name AS tag_name FROM tag, feed_folder_tag, feed_folder WHERE tag.tag_id = feed_folder_tag.tag_id 
        && feed_folder_tag.feed_folder_id = feed_folder.feed_folder_id 
        && feed_folder.feed_id = ".$flux_id;
        
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
}
?>