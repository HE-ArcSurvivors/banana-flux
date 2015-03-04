<?php

function valid($v, $re)
{
   return preg_match("/" . $re . "/", $v);
}

?>