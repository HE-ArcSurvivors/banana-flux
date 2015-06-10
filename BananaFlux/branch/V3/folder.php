<?php

require_once("feed.php");
require_once("article.php");

class Folder {

    private $_id;
    private $_name; 
    private $_color; 
    
    private $_db;
    private $_lang;
    
    private $_tabFeeds = array();
    private $_tabTagsHidden;

    public function __construct($id, $db, $lang, $tagshidden)
    {
    	$this->_db = $db;
    	$this->_id = $id;
    	$this->_lang = $lang;
    	$this->_tabTagsHidden = $tagshidden;
    	
    	$sql = "SELECT `folder_name`, `folder_color` FROM `folder` WHERE `folder_id` =".$id;
		$resource = mysqli_query($db, $sql);

		if(!$resource)
		{
			echo "Connection error: ".mysqli_connect_errno();
		}
		else
		{
			if(mysqli_num_rows($resource) == 1)
			{
	   			$row = mysqli_fetch_assoc($resource);
	   			$this->_name = $row['folder_name'];
	   			$this->_color = $row['folder_color'];
	   			
	   			$this->getFeeds();
	   		}
	   		else
	   		{   		
		   		echo '<div class="informationBox warning">'.$this->_lang["FOLDER_NOT_FOUND"].'</div>';
	   		}
	   	}
	}
	
	private function getFeeds()
	{
		$sql = "SELECT `feed_id` FROM `feed_folder` WHERE `folder_id` =".$this->_id;
		
		$resource = mysqli_query($this->_db, $sql);
		
		if(!$resource)
		{
			echo "Connection error: ".mysqli_connect_errno();
		}
		else
		{ 		
	   		while ($record = mysqli_fetch_assoc ($resource))
			{
				$feed = new feed($record['feed_id'], $this->_db, $this->_lang);
				
				if($feed->hasTags($this->_tabTagsHidden) == false)
				{
					array_push($this->_tabFeeds, $feed);
				}
			}
	   	}
	}
	
	private function getArticlesByDate()
	{
		 $tabArticles = array();
		 
		 //get all feed
		 foreach ($this->_tabFeeds as $feed){
			 $tabArticles = array_merge($tabArticles, $feed->getTabArticles());
		 }
		 
		 //sort feed
		 function comparer($article1, $article2) {
			 return ($article1->getCompareDate() < $article2->getCompareDate());
		 }
        
		 usort($tabArticles, 'comparer');
		 
		 return $tabArticles;
	}
	
	public function getArticlesFolderByDate($idfirst, $idlast)
	{
        
		$tabArticles = $this->getArticlesByDate();
		
		$articles ="";
   		
   		if($idlast>(sizeof($tabArticles)-1))
   		{
	   		$idlast = sizeof($tabArticles)-1;
   		}
   		
   		$i=$idfirst;
	   	for($i; $i<$idlast; $i++)
	   	{
		   	$articles.=$tabArticles[$i]->getApercu("");
	   	}
	   	
	   	return $articles;
	}
    
    
  /* public function printFeedAccordingToTag($tag_id)
    {
        
    }  */
    
    public function getTagList()
    {
        $array = array();
        foreach($this->_tabFeeds as $feed)
        {
            $arrayNEW = array_merge($array, $feed->getTagList());
            $array = $arrayNEW;
        }
        return $array;
    }
}

?>