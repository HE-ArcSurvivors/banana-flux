<?php

require "header.php";

$arr = array();

if (!empty($_POST['keywords'])) {
	$keywords = $db->real_escape_string($_POST['keywords']);
	//$sql = "SELECT ID, post_title FROM wp_posts WHERE post_content LIKE '%".$keywords."%' AND post_status = 'publish'";
	$sql = "SELECT user_id, user_login FROM user WHERE user_login LIKE '%".$keywords."%'";
	$result = $db->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) {
		while ($obj = $result->fetch_object()) {
			$arr[] = array('id' => $obj->user_id, 'title' => $obj->user_login);
		}
	}
}
echo json_encode($arr);

?>