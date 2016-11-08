<?php
header('Access-Control-Allow-Origin: *');

$domains = '';

if(getList()){
    echo $domains;
}else{
    echo 'no list found';
}

function getList(){
    $data = file_get_contents('http://intern.kat2.net/api/domaining/get-list/');
    $array = json_decode($data, true);

    if($array['success'] == true){
        getDomains($row['url']);
        return $row['id'];
    }else{
        return false;
    }
}

function getDomains($url){
    global $domains;
    
    $list = file_get_contents($url);
    $lines = explode("\n", $list);

    $domains = array();
    foreach($lines as $line){
        $length = strlen($line);

        if(($length > 5) && ($length < 15)){
            if(strstr($line, '.')){
                $tld = getTLD($line);

                if(
                    ($tld == 'com')
                    ||
                    ($tld == 'org')
                    ||
                    ($tld == 'net')
                ){
                    $domains[] = array(
                        'domain' => $line,
                        'tld' => $tld,
                        'length' => $length
                    );
                }
            }
        }
    }

    return $domains;
}

function getTLD($domain){
    return str_replace(explode('.', $domain)[0].'.', '', $domain);
}