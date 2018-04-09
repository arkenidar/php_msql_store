<?php

function read_json($filename){
    $content=json_decode(file_get_contents($filename));
    return $content;
}

function write_json($filename, $content){
    file_put_contents($filename,json_encode($content));
}

function prepend_item($filename, $item){
    $items=read_json($filename);
    array_unshift($items,$item);
    //$items[]=$item;
    write_json($filename,$items);
}
