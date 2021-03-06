<?php

require "article.php";

class Feed {

    private $_id;
    private $_title; 
    private $_url;
    
    private $_tag = array();
    private $_tabArticles = array();
	private $_tagid = array();
    
    private $_db;
    private $_lang;
    

    public function __construct($id, $db, $lang)
    {
    	$this->_db = $db;
    	$this->_id = $id;
    	$this->_lang = $lang;
    	
    	$this->loadTag();
    	
    	$sql = "SELECT `feed_url`, `feed_title`  FROM `feed` WHERE `feed_id`=".mysqli_escape_string($db, $id);
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
			$article = new article($entry->title, $entry->description, $entry->link, $entry->image, $entry->pubDate, $this->_title, $this->_tag, $this->_lang);
			array_push($this->_tabArticles, $article);
    	}
    }
   
    private function updateDefaultTag()
    {
       //todo
    }
    
    private function loadTag()
    {
        if(isset($_SESSION["login"]))
        {
            $user = new User($this->_db, $this->_lang);
            $user->loadUser();
            
            $sql = "SELECT DISTINCT tag.tag_id, tag.tag_name AS tag_name FROM tag, feed_folder_tag, feed_folder WHERE tag.tag_id = feed_folder_tag.tag_id 
            && feed_folder_tag.feed_folder_id = feed_folder.feed_folder_id 
            && feed_folder.feed_id = ".mysqli_escape_string($this->_db, $this->_id);
        }
        else
        {
            $sql = "SELECT DISTINCT tag.tag_id, tag.tag_name AS tag_name FROM tag, feed_tag_defaut WHERE tag.tag_id = feed_folder_tag.tag_id 
            && feed_tag_defaut.feed_id = ".mysqli_escape_string($$this->_db, $this->_id);
        }
        
        $result = mysqli_query($this->_db, $sql);

        if(!$result)
        {
            return $this->_lang["CONNECTION_FAILED"].mysqli_connect_errno();
        }
        else
        {
            while ($record = mysqli_fetch_assoc($result))
            {
                array_push($this->_tagid, $record["tag_id"]);
                array_push($this->_tag, $record["tag_name"]);
            }
        }
    }
    
    public function hasTags($tagsHidden)
    {
    	$hasAllTags = true;
    	
    	foreach($this->_tagid as $tag)
    	{
    		if(in_array($tag, $tagsHidden))
    		{
	    		$hasAllTags = $hasAllTags && true;
	    	}
	    	else
	    	{
		    	$hasAllTags = false;
	    	}
    	}
    	
    	if(sizeof($this->_tagid)==0)
    	{
	    	$hasAllTags = false;
    	}
    	
    	//print_r($tagsHidden);
    	//print_r($this->_tagid);
    	
    	return $hasAllTags;
    }
    
    public function getTagList()
    {
        return array_values($this->_tag);
    }
        
}

?>