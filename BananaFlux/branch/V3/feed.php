<?php

require "article.php";

class Feed {

    private $_id;
    private $_title; 
    private $_url;
    
    //private $_tag; //TODO ?
    
    private $_tabArticles = array();
    
    private $_db;
    private $_lang;
    

    public function __construct($id, $db, $lang)
    {
    
    	$this->_db = $db;
    	$this->_id = $id;
    	$this->_lang = $lang;
    	
    	
    	$sql = "SELECT `feed_url`, `feed_title`  FROM `feed` WHERE `feed_id`=".$id;
		$resource = mysqli_query($db, $sql);
		
		
		if(!$resource)
		{
			echo "Connection error: ".mysqli_connect_errno();
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
		   		echo '<div class="informationBox warning">'.$this->_lang["FEED_NOT_FOUND"].'</div>';
	   		}
	   	}
	}
	
	public function getTabArticles()
	{
		return $this->_tabArticles;
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
		   	$articles.=$this->_tabArticles[$i]->getApercu($this->_title);
	   	}
	   	
	   	return $articles;
   	}
    
    private function getArticles()
    {
	    $content = file_get_contents($this->_url);
		$listflux = new SimpleXmlElement($content);
    
		foreach($listflux->channel->item as $entry)
		{   
			$article = new article($entry->title, $entry->description, $entry->link, $entry->image, $entry->pubDate, $this->_lang);
			array_push($this->_tabArticles, $article);
    	}
    }
   
    private function updateDefaultTag()
    {
       //todo
    }
    
}

?>