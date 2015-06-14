﻿<?php

class Article {

    private $_title;
    private $_description;
    private $_url;
    private $_img;
    private $_pubDate;
    private $_lang;
    
    private $_titleFeed;
    private $_tabTags = array();

    public function __construct($title, $description, $url, $img, $pubDate, $titleFeed, $tabTags , $lang)
    {
	   $this->_title = $title;
	   $this->_description = $description;
	   $this->_url = $url;
	   $this->_img = $img;
	   $this->_titleFeed = $titleFeed;
	   
	   $this->_tabTags = $tabTags;
	   
	   $this->_pubDate = new DateTime($pubDate);
	   $this->_lang = $lang;
    }
   
/*
    public function saveForLater()
    {
       return true;
    }
*/
    private function cutText($string, $length)
	{
		//Hard cut ! am�lioration possible
		if(strlen($string)>$length)
		{
			$string = substr ($string, 0, $length).'...'; 
		}
		
		return $string;
	}
	
	private function printTags()
	{
		$tags = "";
		foreach ($this->_tabTags as $tag){
			$tags .= '<span class="article_category">'.htmlentities($tag).'</span>';
    	}
		
		return $tags;
	}
	
	private function printFullTags()
	{
		$tags = " |";
		foreach ($this->_tabTags as $tag){
			$tags .= htmlentities($tag).'|';
    	}
		
		return $tags;
	}
	
    public function getApercu()
    {
       	//Size of the strings
		$lengthDescr = "140";
		$lengthTitle = "55";
		
		//Image ?
		$showImg = "";
		if(!empty($this->_img))
		{
			$showImg = '<img src="'.htmlentities($this->_img).'" alt="'.htmlentities($this->_title).'" />';
		}

		$descr = htmlentities($this->cutText($this->_description, $lengthDescr));
		
		$descr.='[<a href="'.htmlentities($this->_url).'" target="_blank">'.$this->_lang["ARTICLES_READ_NEXT"].'</a>]';
		$title = $this->cutText($this->_title, $lengthTitle);
		
		//Return the constructed article

	    return '<div class="article">
	
		  <div class="article_thumb">
		      	'.$showImg.'
		  </div>
	  
		  <div class="article_date">
		    <span class="article_date_day">'.$this->_pubDate->format('d').'</span>
		    <span class="article_date_month">'.$this->_pubDate->format('F').'</span>
		  </div>
		  
		  <div class="article_body">
	
		    <div class="article_categories">'.$this->printTags().'</div>
		    
		    <h2 class="article_title"><a href="#">'.htmlentities($title).'</a></h2>
		    <div class="article_description">
		    <p>
		      '.$descr.'
		    </p>
		    <p class="article_description_category">'.$this->printFullTags().'</p>
		    </div>
		  </div>
		
		  <div class="article_footer">
		  <hr/>
			  <p>'.htmlentities($this->_titleFeed).' : '.$this->_pubDate->format('d.m.Y H:i').'</p>
		  </div>
	  
	  </div>';
    }
    
    public function getCompareDate()
    {
	    return $this->_pubDate->format('U');
    }
    
}

?>