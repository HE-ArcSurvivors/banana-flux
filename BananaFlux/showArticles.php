<?php
	session_start();
	
	$nbShowed=@$_POST['nbshowed'];
	$nbAdd=@$_POST['nbadd'];
	
	
	function article($title, $descr, $image)
	{
		
		return '<div id="articles"><div class="article">
	      		<div class="article_head">
	      			<h1>'.$title.'</h1>
	      		</div>
	      		<div class="article_image">
	      			
	      		</div>
	      		<div class="article_descritption">
	      			<p>'.$descr.'</p>
	      		</div>
	      		</div></div>';
	}
	
	for($i=$nbShowed; $i<$nbAdd+$nbShowed; $i++)
	{
		echo article("Article"+$i, "Une description", "");
	}

?>