<?php
	require_once "header.php";
	
	require_once "feed.php";
	
	$nbShowed=@$_POST['nbshowed'];
	$nbAdd=@$_POST['nbadd'];
	$id_flux=@$_POST['idflux'];
	$id_dossier=@$_POST['iddossier'];
	
	//http://www.20min.ch/rss/rss.tmpl?type=rubrik&get=313&lang=ro
	//http://www.jeuxvideo.com/rss/rss.xml
    
	if(empty($id_dossier) && !empty($id_flux))
	{
		//afficher flux unique
		$feed = new feed($id_flux, $db);
		echo $feed->getArticlesFeed($nbShowed, $nbShowed+$nbAdd);
		
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