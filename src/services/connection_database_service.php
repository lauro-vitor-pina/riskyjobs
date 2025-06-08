<?php

require_once(__DIR__ . '/load_environmentvars_service.php');

function connection_database_service_get_dbc() : mysqli
{
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT) or die('Faield to connect Database');

    return $dbc;
}

function connection_database_service_close(mysqli $dbc)
{
    if ($dbc != null) {
        mysqli_close($dbc);
    }
}
