<?php

function valid($v, $re)
{
   return preg_match("/" . $re . "/", $v);
}

function isEqual($data1, $data2)
{
    return $data1 === $data2;
}

?>