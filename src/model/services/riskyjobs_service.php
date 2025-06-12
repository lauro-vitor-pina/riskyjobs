<?php
require_once(__DIR__ . '../../enums/enum_sort_riskyjob.php');
require_once(__DIR__ . '../../repositories/riskyjobs_repository.php');
require_once(__DIR__ . '../../viewmodels/SearchViewModel.php');

function riskyjobs_service_get_all(mysqli $dbc, string $search, int $sort, int $page_number, int $page_size): SearchViewModel
{
    $result = riskyjobs_repository_get_all($dbc, $search, $sort, $page_number, $page_size);

    $view_model = new SearchViewModel();

    $view_model->rows = $result['rows'];
    $view_model->total = $result['total'];
    $view_model->num_pages = $result['num_pages'];

    $view_model->search = $search;
    $view_model->sort = $sort;
    $view_model->page_number = $page_number;
    $view_model->page_size = $page_size;

    return $view_model;
}

function riskyjobs_service_registration($dbc, $first_name, $last_name, $email, $phone, $desired_job,  $resume) {
    echo 'process registration <br>';
}
