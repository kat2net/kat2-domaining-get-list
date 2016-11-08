<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo 'Begin ...<br />';
for( $i = 0 ; $i < 10 ; $i++ )
{
    echo $i . '<br />';
    flush();
    ob_flush();
    sleep(1);
}
echo 'End ...<br />';