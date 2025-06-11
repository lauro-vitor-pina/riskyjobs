<?php
require_once(__DIR__ . '../../enums/enum_sort_riskyjob.php');
require_once(__DIR__ . '../../repositories/riskyjobs_repository.php');

function riskyjobs_service_get_all(mysqli $dbc, string $search, int $sort, int $page, int $results_per_page)
{
    $get_all_result = riskyjobs_repository_get_all($dbc, $search, $sort, $page, $results_per_page);

    $sort_config = [
        'Job Title' => $sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] : ENUM_SORT_RISKYJOBS['title_asc'],
        'Description' => null,
        'State' => $sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
        'Date Posted' => $sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc'],
    ];

    $view_model_result = [
        'page' => $page,
        'search' => $search,
        'sort' => $sort,
        'sort_config' => $sort_config,
        'total' => $get_all_result['total'],
        'num_pages' => $get_all_result['num_pages'],
        'rows' => $get_all_result['rows']
    ];

    return $view_model_result;
}
