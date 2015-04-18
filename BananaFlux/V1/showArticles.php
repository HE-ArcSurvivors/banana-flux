<?php
	require_once "header.php";
	
	$nbShowed=@$_POST['nbshowed'];
	$nbAdd=@$_POST['nbadd'];
	$id_flux=@$_POST['idflux'];
	$id_dossier=@$_POST['iddossier'];
	
	function cutText($string, $length)
	{
		//Hard cut ! amélioration possible
		if(strlen($string)>$length)
		{
			$string = substr ($string, 0, $length).'...'; 
		}
		
		return $string;
	}
	
	function article($title, $descr, $url, $image="")
	{
		//Size of the strings
		$lengthDescr = "50";
		$lengthDescrSansImage = "1000";
		$lengthTitle = "60";
		
		//Image ?
		$showImg = "";
		if(!empty($image))
		{
			$showImg = '<div class="article_image"><img src="'.$image.'" alt="'.$title.'"></div>';
			
			$descr = cutText($descr, $lengthDescr);
		}
		else
		{
			$descr = cutText($descr, $lengthDescrSansImage);
		}
		
		$descr.='[<a href="'.$url.'" target="_blank">Lire la suite</a>]';
		$title = cutText($title, $lengthTitle);
		
		//return the constructed article
		return '<div id="articles"><div class="article">
	      		<div class="article_head">
	      			<h1>'.$title.'</h1>
	      		</div>
	      		'.$showImg.'
	      		<div class="article_descritption">
	      			<p>'.$descr.'</p>
	      		</div>
	      		</div></div>';
	}
	
	function showArticlesRSS($urlRSS, $idfirst, $idlast)
	{
		$content = file_get_contents($urlRSS);
		$listflux = new SimpleXmlElement($content);
    
		$i=0;
		foreach($listflux->channel->item as $entry)
		{   
    		if($i<=$idlast+$idfirst && $i > $idfirst)
    		{
    			echo article($entry->title, $entry->description, $entry->link, $entry->image);
    		}
    		$i++;
    	}

	}
	
	//http://www.20min.ch/rss/rss.tmpl?type=rubrik&get=313&lang=ro
	//http://www.jeuxvideo.com/rss/rss.xml
    
	if(empty($id_dossier) && !empty($id_flux))
	{
		//afficher flux unique
		
		$sql = "SELECT `feed_url` FROM `feed` WHERE `feed_id`=".$id_flux;
		$resource = mysqli_query($db, $sql);
		
		if(!$resource)
		{
			echo "Connection error: ".mysqli_connect_errno(); //TODO
		}
		else
		{
	   		$row = mysqli_fetch_array($resource);
	   		$urlRSS = $row[0];
	   		
	   		showArticlesRSS($urlRSS, $nbShowed, $nbAdd);
	   }

		
	}
	else if(!empty($id_dossier) && empty($id_flux))
	{
		//afficher tout les flux du dossier
	}
    else
    {
	    echo "<p>Erreure AJAX (showArticles.php): Arguments manquants</p>"; //TODO
    }

?>