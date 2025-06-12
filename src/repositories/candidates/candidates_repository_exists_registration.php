<?php

function candidates_repository_exists_registration(mysqli $dbc, int $job_id, string $email, string $phone): bool
{
    $query = "SELECT COUNT(candidate_id) AS total
              FROM candidate
              WHERE job_id = $job_id
              AND (email = '$email' OR phone = '$phone')";

    $query_result = mysqli_query($dbc, $query);

    $row = mysqli_fetch_array($query_result);

    $total = (int)$row['total'];

    return $total > 0;
}
