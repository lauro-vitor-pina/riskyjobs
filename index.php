<?php 

require_once(__DIR__ . '/src/services/connection_database_service.php');

$dbc = connection_database_service_get_dbc();

echo 'connect with success';

connection_database_service_close($dbc);

echo '<h1>Hello world! Risky Jobs</h2>';