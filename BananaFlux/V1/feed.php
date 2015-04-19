<?php

require "article.php";

class Feed {

    private $_id;
    private $_title; 
    private $_url;
    
    //private $_tag; //TODO ?
    
    private $_tabArticles = array();
    
    private $_db;

    public function __construct($id, $db)
    {
    
    	$this->_db = $db;
    	$this->_id = $id;
    	
    	
    	$sql = "SELECT `feed_url`, `feed_title`  FROM `feed` WHERE `feed_id`=".$id;
		$resource = mysqli_query($db, $sql);
		
		
		if(!$resource)
		{
			echo "Connection error: ".mysqli_connect_errno(); //TODO
		}
		else
		{
	   		$row = mysqli_fetch_assoc($resource);
	   		$this->_url = $row['feed_url'];
	   		$this->_title = $row['feed_title'];
	   		
	   		if(!empty($this->_url))
	   		{	   		
	   			$this->getArticles();
	   		}
	   		else
	   		{
		   		echo "<p>Erreur : Arguments incorrectes</p>"; //TODO
	   		}
	   	}
	}
    
   	public function getArticlesFeed($idfirst, $idlast)
   	{
   		$articles ="";
   		
   		if($idlast>(sizeof($this->_tabArticles)-1))
   		{
	   		$idlast = sizeof($this->_tabArticles)-1;
   		}
   		
   		$i=$idfirst;
	   	for($i; $i<$idlast; $i++)
	   	{
		   	$articles.=$this->_tabArticles[$i]->getApercu();
	   	}
	   	
	   	return $articles;
   	}
    
    private function getArticles()
    {
	    $content = file_get_contents($this->_url);
		$listflux = new SimpleXmlElement($content);
    
		foreach($listflux->channel->item as $entry)
		{   
			$article = new article($entry->title, $entry->description, $entry->link, $entry->image);
			array_push($this->_tabArticles, $article);
    	}
    }
   
    private function updateDefaultTag()
    {
       
    }
    
}

?>