<?php

function riskyjobs_repository_get_all(mysqli $dbc, string $search)
{
    $where_list = array();

    $search_words = explode(' ', $search);

    foreach ($search_words as $word) {
        array_push($where_list, "description LIKE '%$word%'");
    }

    $where_clausule = implode(' OR ', $where_list);

    $query = "SELECT
	            `job_id`,
	            `title`,
                `description`,
                `state`,
                `date_posted`
              FROM riskyjobs";

    if (!empty($where_clausule)) {
        $query .= " WHERE $where_clausule ";
    }

    $query_result = mysqli_query($dbc, $query);

    $result = [];

    while ($row = mysqli_fetch_array($query_result)) {
        array_push($result, $row);
    }

    return $result;
}
