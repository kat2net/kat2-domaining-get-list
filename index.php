<?php
header('Access-Control-Allow-Origin: *');

include 'Phois/Whois/Whois.php';

use Phois\Whois;

$domains = array();

if(getList()){
    foreach($domains as $domain){
        if(tooSend($domain['domain'], $domain['tld'])){
            file_get_contents('http://intern.kat2.net/api/domaining/add-domain/?domain='.$domain['domain']);
        }
    }
}else{
    echo 'no list found';
}

function getList(){
    $data = file_get_contents('http://intern.kat2.net/api/domaining/get-list/');
    $array = json_decode($data, true);

    if($array['success'] == true){
        getDomains($array['url']);
        return $array['id'];
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

function tooSend($domain, $tld){
    $call = new Phois\Whois\Whois($domain);
    if($call->isAvailable()){
        return true;
    }else{
        return true;
    }
}