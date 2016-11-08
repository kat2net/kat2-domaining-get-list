<?php
header('Content-Type: application/json');

$worker_name = getenv('worker_name');

$list_active = 'N/A';
$list_domains_done = '';
$list_domains_left = '';
$list_percentage = '';

if(file_exists('/app/d/lock')){
    $data = file('/app/d/output');
    $last_line = $data[count($data)-2];
    $last_line = explode('|', $last_line);
    $last_line = explode(':', $last_line[0]);

    $list_active = 'yes';
    $list_domains_done = $last_line[0];
    $list_domains_left = $last_line[1];
    $list_percentage = ($last_line[0] / $last_line) * 100;

    $last_line = explode('|', $last_line);
    $last_line = explode(':', $last_line[0]);
}

$array = array(
    'worker' => array(
        'name' => $worker_name
    ),
    'list' => array(
        'active' => $list_active,
        'domains_done' => $list_domains_done,
        'domains_left' => $list_domains_left,
        'percentage' => $list_percentage
    )
);

echo json_encode($array, JSON_PRETTY_PRINT);