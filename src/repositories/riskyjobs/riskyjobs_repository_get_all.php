<?php


function riskyjobs_repository_get_all(mysqli $dbc, string $search, int $sort, int $page, int $results_per_page)
{
    $query = "SELECT
	            `job_id`,
	            `title`,
                `description`,
                `state`,
                `date_posted`
              FROM riskyjobs";

    $query = riskyjobs_repository_get_all_filter($query, $search);

    $query = riskyjobs_repository_get_all_sort($query, $sort);

    if ($page >= 1)
        $skip = ($page - 1) * $results_per_page;
    else
        $skip = 0;

    $query =  $query . " LIMIT $skip,$results_per_page";

    $query_result = mysqli_query($dbc, $query);

    $rows = [];

    while ($row = mysqli_fetch_array($query_result)) {
        array_push($rows, $row);
    }

    $total = riskyjobs_repository_get_all_total($dbc, $search, $sort);

    $num_pages = ceil($total / $results_per_page);

    $result = [
        'total' => $total,
        'num_pages' => $num_pages,
        'rows' => $rows,
    ];

    return $result;
}

function riskyjobs_repository_get_all_total(mysqli $dbc, string $search): int
{
    $query_count = "SELECT COUNT(job_id) AS total FROM riskyjobs";

    $query_count = riskyjobs_repository_get_all_filter($query_count, $search);

    $result_query_count = mysqli_query($dbc, $query_count);

    $row = mysqli_fetch_array($result_query_count);

    $total = $row['total'];

    return (int) $total;
}


function riskyjobs_repository_get_all_filter(string $query, string $search): string
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

function riskyjobs_repository_get_all_sort(string $query, int $sort): string
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
