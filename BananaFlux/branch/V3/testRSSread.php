<?php
 
function getFeed($feed_url) {
     
    $content = file_get_contents($feed_url);
    $x = new SimpleXmlElement($content);
     
    echo "<ul>";
     
    foreach($x->channel->item as $entry) {
        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
        echo "<li>" . $entry->description . "</a></li>";
    }
    echo "</ul>";
}

getFeed('http://www.comptoir-hardware.com/home.xml');
?>