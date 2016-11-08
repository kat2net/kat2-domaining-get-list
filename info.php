<?php
header('Content-Type: application/json');

$worker_name = getenv('worker_name');

$list_active = 'N/A';

$data = file('/app/d/output');
$line = $data[count($data)-2];

$array = array(
    'worker' => array(
        'name' => $worker_name
    ),
    'list' => array(
        'active' => $list_active,
        'domains_done' => $list_active,
        'domains_left' => $list_active
        
    ),
    'output' => array(
        'last_line' => $line
    )
);

echo json_encode($array, JSON_PRETTY_PRINT);