<?php

function candidates_repository_insert(
    mysqli $dbc, 
    int $job_id, 
    string $first_name, 
    string $last_name, 
    string $email, 
    string $phone, 
    string $resume
 )
{
    $query = "INSERT INTO candidate (`job_id`, `first_name`, `last_name`, `email`, `phone`, `resume`, `date_registration`)
              VALUES ($job_id, '$first_name', '$last_name', '$email', '$phone', '$resume', NOW())";

    mysqli_query($dbc, $query) or die('error candidates_repository_insert');

    $affected_rows = (int) mysqli_affected_rows($dbc);

    return $affected_rows == 1;
}
