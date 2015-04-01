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
	
    

    $content = file_get_contents('http://www.comptoir-hardware.com/home.xml');
    $listflux = new SimpleXmlElement($content);
    
    
    //revoir
    $i=0;
    foreach($listflux->channel->item as $entry)
    {   
    	if($i<=$nbAdd+$nbShowed && $i > $nbShowed)
    	{
    		echo article($entry->title, $entry->description, "");
    	}
        $i++;
    }
 

?>