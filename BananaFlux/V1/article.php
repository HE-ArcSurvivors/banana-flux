<?php

class Article {

    private $_title;
    private $_description;
    private $_url;
    private $_img;

    public function __construct($title, $description, $url, $img)
    {
	   $this->_title = $title;
	   $this->_description = $description;
	   $this->_url = $url;
	   $this->_img = $img;
    }
   
/*
    public function saveForLater()
    {
       return true;
    }
*/
    private function cutText($string, $length)
	{
		//Hard cut ! amélioration possible
		if(strlen($string)>$length)
		{
			$string = substr ($string, 0, $length).'...'; 
		}
		
		return $string;
	}
	
    public function getApercu()
    {
       	//Size of the strings
		$lengthDescr = "50";
		$lengthDescrSansImage = "1000";
		$lengthTitle = "60";
		
		//Image ?
		$showImg = "";
		if(!empty($this->_img))
		{
			$showImg = '<div class="article_image"><img src="'.$this->_img.'" alt="'.$this->_title.'"></div>';
			
			$descr = $this->cutText($this->_description, $lengthDescr);
		}
		else
		{
			$descr = $this->cutText($this->_description, $lengthDescrSansImage);
		}
		
		$descr.='[<a href="'.$this->_url.'" target="_blank">Lire la suite</a>]';
		$title = $this->cutText($this->_title, $lengthTitle);
		
		//Return the constructed article
		return '<div id="articles"><div class="article">
	      		<div class="article_head">
	      			<h1>'.$this->_title.'</h1>
	      		</div>
	      		'.$showImg.'
	      		<div class="article_descritption">
	      			<p>'.$descr.'</p>
	      		</div>
	      		</div></div>';

    }
    
    
}

?>