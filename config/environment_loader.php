<?php

$host = $_SERVER['SERVER_NAME'] ?? throw new Exception('Cannot determine server environment');


$local_environments = [
    'localhost',
    '127.0.01'
];


if (in_array($host, $local_environments)) {
    require_once(__DIR__ . '/environmentvars.local.php');
} else {
    require_once(__DIR__ . '/environmentvars.prd.php');
}
