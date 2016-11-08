<?php
header('Access-Control-Allow-Origin: *');

ob_implicit_flush(1);

for($i=0; $i<10; $i++){
    echo $i;

    //this is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);

    sleep(1);
}