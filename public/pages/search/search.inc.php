<?php 

require_once(__DIR__ . '../../../../src/services/connection_database_service.php');
require_once(__DIR__ . '../../../../src/repositories/riskyjobs/riskyjobs_repository_get_all.php');
require_once(__DIR__ . '../../../../src/enums/enum_sort_riskyjob.php');


$dbc = connection_database_service_get_dbc();

$search = isset($_GET['search']) ? mysqli_real_escape_string($dbc, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? (int)mysqli_real_escape_string($dbc, $_GET['sort']) : 0;
$page_number = isset($_GET['page']) ? (int)mysqli_real_escape_string($dbc, $_GET['page']) : 1;
$page_size = 5;

$result = riskyjobs_repository_get_all($dbc, $search, $sort, $page_number, $page_size);
$total = $result['total'];
$num_pages = $result['num_pages'];
$rows = $result['rows'];

$sort_config = [
    'Job Title' => $sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] : ENUM_SORT_RISKYJOBS['title_asc'],
    'Description' => null,
    'State' => $sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
    'Date Posted' => $sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc']
];

connection_database_service_close($dbc);