<?php

function riskyjobs_repository_get_by_id($dbc, $job_id)
{
    $query = "SELECT
	              `job_id`,
	              `title`,
                `description`,
                `state`,
                `date_posted`
              FROM riskyjobs
              where job_id = $job_id";

    $query_result = mysqli_query($dbc, $query) or die('error in riskyjobs_repository_get_by_id');

    $row = mysqli_fetch_array($query_result);

    return $row;
}
