<?php
require_once(__DIR__ . '../../model/viewmodels/RegistrationViewModel.php');
require_once(__DIR__ . '../../model/services/connection_database_service.php');
require_once(__DIR__ . '../../model/services/riskyjobs_service.php');

function riskyjobs_controller_handler_search(): SearchViewModel
{
    $dbc = connection_database_service_get_dbc();

    $search = isset($_GET['search']) ? mysqli_real_escape_string($dbc, $_GET['search']) : '';
    $sort = isset($_GET['sort']) ? (int)mysqli_real_escape_string($dbc, $_GET['sort']) : 0;
    $page = isset($_GET['page']) ? (int)mysqli_real_escape_string($dbc, $_GET['page']) : 1;
    $results_per_page = 5;

    $view_model = riskyjobs_service_get_all($dbc, $search, $sort, $page, $results_per_page);

    connection_database_service_close($dbc);

    return $view_model;
}

function riskyjobs_controller_handler_registration(): RegistrationViewModel
{

    if (!isset($_POST['submit'])) {
        return new RegistrationViewModel();
    }

    $dbc = connection_database_service_get_dbc();

    $first_name = mysqli_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_escape_string($dbc, trim($_POST['email']));
    $phone = mysqli_escape_string($dbc, trim($_POST['phone']));
    $desired_job = mysqli_escape_string($dbc, trim($_POST['desired_job']));
    $resume = mysqli_escape_string($dbc, trim($_POST['resume']));

    $view_model = riskyjobs_service_registration($dbc, $first_name, $last_name, $email, $phone, $desired_job, $resume);

    connection_database_service_close($dbc);

    return $view_model;
}
