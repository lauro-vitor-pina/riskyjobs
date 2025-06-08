<?php

function riskyjobs_repository_get_all(mysqli $dbc, string $search): array
{
    $query = "SELECT
	            `job_id`,
	            `title`,
                `description`,
                `state`,
                `date_posted`
              FROM riskyjobs";

    $query = riskyjobs_repository_filter_get_all($query, $search);

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
