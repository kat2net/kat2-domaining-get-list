<?php
header('Access-Control-Allow-Origin: *');
header('Content-Typle: application/json');

file_get_contents($_GET['url']);