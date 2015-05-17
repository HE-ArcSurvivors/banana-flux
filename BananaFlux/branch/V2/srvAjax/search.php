<?php

require "../header.php";

$arr = array();

if (!empty($_POST['keywords'])) {
	$keywords = $db->real_escape_string($_POST['keywords']);
	
	$karma = 1000;
	
	//URL SEARCH
	if (strpos($keywords,"http://") !== false)
	{
		$arr = array();
		$sql = "SELECT feed_title, feed_url FROM feed WHERE feed_url LIKE '%".$keywords."%'";
		$result = $db->query($sql) or die($mysqli->error);
		
		if ($result->num_rows > 0) {
			
			while ($obj = $result->fetch_object()){
				$arr[] = array('type' => "URL", 'searchStatus' => "done", 'url' => $obj->feed_url, 'title' => $obj->feed_title, 'karma' => $karma);
				}
		}
		
	}
	//Flux Name SEARCH
	else
	{
		$arr = array();
		$sql = "SELECT feed_title, feed_url FROM feed WHERE feed_title LIKE '%".$keywords."%'";
		$result = $db->query($sql) or die($mysqli->error);
		
		if ($result->num_rows > 0) {
			
			while ($obj = $result->fetch_object()){
				$arr[] = array('type' => "FLUX TITLE", 'searchStatus' => "done", 'url' => $obj->feed_url, 'title' => $obj->feed_title, 'karma' => $karma);
				}
		}
		
		// USER SEARCH, future iteration...	
		/*$sql = "SELECT user_id, user_login FROM user WHERE user_login LIKE '%".$keywords."%'";
		$result = $db->query($sql) or die($mysqli->error);
		if ($result->num_rows > 0) {
			while ($obj = $result->fetch_object()) {
				$arr[] = array('type' => "USER", 'searchStatus' => "done", 'id' => $obj->user_id, 'title' => $obj->user_login);
			}
		}*/
	}
}
echo json_encode($arr);

?>