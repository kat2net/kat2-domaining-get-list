<?php
header('Access-Control-Allow-Origin: *');

$id = getList();
$domains = '';

if($id){
    echo $domains;
}else{
    echo 'no list found';
}

function getList(){
    $data = file_get_contents('http://intern.kat2.net/api/domaining/get-list/');
    $array = json_decode($data, true);

    if($array['success']){
        getDomains($row['url']);
        return $row['id'];
    }else{
        return false;
    }
}

function getDomains($url){
    global $domains;
    
    $domains = file_get_contents($url);
}