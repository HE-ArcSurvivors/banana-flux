<?php

require "../header.php";

$arr = array();

//Not empty search
/*if (!empty($_POST['keywords'])) {*/
	$keywords = $db->real_escape_string($_POST['keywords']);

	$arr = array();
	$sql = "SELECT feed_id, feed_title, feed_url FROM feed WHERE feed_title LIKE '%".$keywords."%' ORDER BY feed_title ASC";
	$result = $db->query($sql) or die($mysqli->error);
		
	if ($result->num_rows > 0) {
			
		while ($obj = $result->fetch_object())
		{
			$arr[] = array('type' => "FLUX TITLE", 'searchStatus' => "done", 'url' => $obj->feed_url, 'title' => $obj->feed_title, 'karma' => $karma, 'id' => $obj->feed_id);
		}
	}
/*}
else
{*/
/*	$arr = array();
		
	$sql = "SELECT feed_id, feed_title, feed_url FROM feed ORDER BY feed_title ASC";
		
	$result = $db->query($sql) or die($mysqli->error);
		
	if ($result->num_rows > 0) {
			
		while ($obj = $result->fetch_object())
		{
			$arr[] = array('searchStatus' => "done", 'url' => $obj->feed_url, 'title' => $obj->feed_title, 'id' => $obj->feed_id);
		}
	}*/
/*}*/

echo json_encode($arr);

?>