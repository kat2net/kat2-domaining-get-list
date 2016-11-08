<?php
$domains = array();

if(getList()){
    echo time()."\n";
    foreach($domains as $domain){
        $isAvailable = isAvailable($domain['domain'], $domain['tld']);
        if($isAvailable){
            file_get_contents('http://intern.kat2.net/api/domaining/add-domain/?domain='.$domain['domain']);
        }
    }
    echo time()."\n";
    echo 'done';
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
                    ($tld == 'net')
                    ||
                    ($tld == 'org')
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

function isAvailable($domain, $tld){
    $finders = array(
        'com' => array('whois.crsnic.net', 'No match for'),
        'net' => array('whois.crsnic.net', 'No match for'),
        'org' => array('whois.publicinterestregistry.net', 'NOT FOUND')
    );

    $server = $finders[$tld][0];
    $finder = $finders[$tld][1];

	$fp = @fsockopen($server, 43, $errno, $errstr, 10) or die("Socket Error " . $errno . " - " . $errstr);
	if($server == "whois.verisign-grs.com"){
        $domain = "domain ".$domain;
    }
	fputs($fp, $domain . "\r\n");
	$out = "";
	while(!feof($fp)){$out .= fgets($fp);}
	fclose($fp);

    if(strstr($out, $finder)){
        return true;
    }else{
        return false;
    }
}