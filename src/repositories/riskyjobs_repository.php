<?php

function riskyjobs_repository_get_all(mysqli $dbc, string $search, int $sort): array
{
    $query = "SELECT
	            `job_id`,
	            `title`,
                `description`,
                `state`,
                `date_posted`
              FROM riskyjobs";

    $query = riskyjobs_repository_filter_get_all($query, $search);

    $query = riskyjobs_repository_order_get_all($query, $sort);

    $query_result = mysqli_query($dbc, $query);

    $result = [];

    while ($row = mysqli_fetch_array($query_result)) {
        array_push($result, $row);
    }

    return $result;
}


function riskyjobs_repository_filter_get_all(string $query, string $search): string
{
    $search_clean = str_replace(',', ' ', $search);

    $search_words = explode(' ', $search_clean);

    if (count($search_words) <= 0) {
        return $query;
    }

    $where_list = array();

    foreach ($search_words as $search_word_item) {

        $word = trim($search_word_item);

        if (!empty($word)) {
            array_push($where_list, "description LIKE '%$word%'");
        }
    }

    $where_clausule = implode(" OR ", $where_list);

    if (empty($where_clausule)) {
        return $query;
    }

    return $query . " WHERE $where_clausule ";
}

function riskyjobs_repository_order_get_all(string $query, int $sort): string
{
    $order_clausule = '';

    switch ($sort) {
        case ENUM_SORT_RISKYJOBS['title_asc']:
            $order_clausule = 'ORDER BY title ASC';
            break;
        case ENUM_SORT_RISKYJOBS['title_desc']:
            $order_clausule = 'ORDER BY title DESC';
            break;
        case ENUM_SORT_RISKYJOBS['state_asc']:
            $order_clausule = 'ORDER BY state ASC';
            break;
        case ENUM_SORT_RISKYJOBS['state_desc']:
            $order_clausule  = 'ORDER BY state DESC';
            break;
        case ENUM_SORT_RISKYJOBS['date_posted_asc']:
            $order_clausule = 'ORDER BY date_posted ASC';
            break;
        case ENUM_SORT_RISKYJOBS['date_posted_desc']:
            $order_clausule = 'ORDER BY date_posted  DESC';
            break;
        default:
            $order_clausule = 'ORDER BY job_id ASC';
            break;
    }

    return  $query . ' ' . $order_clausule;
}
