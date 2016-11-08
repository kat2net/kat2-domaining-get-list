<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$list = file_get_contents($_GET['url']);
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

echo json_encode($domains, JSON_PRETTY_PRINT);

function getTLD($domain){
    return str_replace(explode('.', $domain)[0].'.', '', $domain);
}