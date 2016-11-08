<?php
$dir = $_SERVER['DOCUMENT_ROOT'];

exec('sudo mkdir '.$dir.'/d/');
exec('sudo touch '.$dir.'/d/lock');
exec('sudo touch '.$dir.'/d/output');
exec('sudo chmod 777 '.$dir.'/d/output')

exec('php /app/bg.php > '.$dir.'/d/output &');

echo 'k';