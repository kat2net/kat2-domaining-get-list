<?php
$dir = $_SERVER['DOCUMENT_ROOT'];

if(file_exists('/app/d/lock')){
    echo 'locked';
}else{
    echo 'make lock';

    file_put_contents('/app/d/lock', time());

    //exec('php /app/bg.php > /app/d/output &');
}