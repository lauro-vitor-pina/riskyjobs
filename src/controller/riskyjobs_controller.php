<?php
require_once(__DIR__ . '../../model/services/connection_database_service.php');
require_once(__DIR__ . '../../model/services/riskyjobs_service.php');

function riskyjobs_controller_handler_search()
{
    $dbc = connection_database_service_get_dbc();

    $search = isset($_GET['search']) ? mysqli_real_escape_string($dbc, $_GET['search']) : '';
    $sort = isset($_GET['sort']) ? (int)mysqli_real_escape_string($dbc, $_GET['sort']) : 0;
    $page = isset($_GET['page']) ? (int)mysqli_real_escape_string($dbc, $_GET['page']) : 1;
    $results_per_page = 5;

    $result = riskyjobs_service_get_all($dbc, $search, $sort, $page, $results_per_page);

    connection_database_service_close($dbc);

    return $result;
}
