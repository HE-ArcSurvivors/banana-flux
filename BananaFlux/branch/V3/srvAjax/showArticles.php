<?php
	require_once "../header.php";
	
	require_once "../feed.php";
	require_once "../folder.php";
	
	$nbShowed=@$_POST['nbshowed'];
	$nbAdd=@$_POST['nbadd'];
	$id_flux=@$_POST['idflux'];
	$id_dossier=@$_POST['iddossier'];
	$tagshidden=@json_decode($_POST['tagshidden']);

	//http://www.20min.ch/rss/rss.tmpl?type=rubrik&get=313&lang=ro
	//http://www.jeuxvideo.com/rss/rss.xml
    
	if(empty($id_dossier) && !empty($id_flux))
	{
		//afficher flux unique
		$feed = new feed($id_flux, $db, $lang);
		echo $feed->getArticlesFeed($nbShowed, $nbShowed+$nbAdd);
	}
	else if(!empty($id_dossier) && empty($id_flux))
	{
		//afficher tout les flux du dossier
		$folder = new folder($id_dossier, $db, $lang, $tagshidden);
		echo $folder->getArticlesFolderByDate($nbShowed, $nbShowed+$nbAdd);
	}
    else
    {
	    echo '<div class="informationBox warning">Error AJAX (showArticles.php): missing arguments</div>';
    }

?>