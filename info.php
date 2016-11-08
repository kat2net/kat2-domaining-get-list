<?php
header('Content-Type: application/json');

$worker_name = getenv('worker_name');

$list_active = 'N/A';

$data = file('/app/d/output');
$last_line = $data[count($data)-2];

$last_line = explode('|', $last_line);
$last_line = explode(':', $last_line[0]);

$array = array(
    'worker' => array(
        'name' => $worker_name
    ),
    'list' => array(
        'active' => $list_active,
        'domains_done' => $last_line[0],
        'domains_left' => $last_line[1]
        
    ),
    'output' => array(
        'last_line' => $last_line
    )
);

echo json_encode($array, JSON_PRETTY_PRINT);