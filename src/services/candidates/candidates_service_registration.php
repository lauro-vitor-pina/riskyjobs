<?php

require_once(__DIR__ . '../../../repositories/candidates/candidates_repository_exists_registration.php');
require_once(__DIR__ . '../../../repositories/candidates/candidates_repository_insert.php');

function candidates_service_registration(
    mysqli $dbc,
    int $job_id,
    string $first_name,
    string $last_name,
    string $email,
    string $phone,
    string $resume
) {

    $exists_registration = candidates_repository_exists_registration(
        $dbc, 
        $job_id, 
        $email, 
        $phone
    );

    if ($exists_registration) {
        throw new Exception('The information of contact are already registration in this job.');
    }

    candidates_repository_insert(
        $dbc, 
        $job_id, 
        $first_name, 
        $last_name, 
        $email, 
        $phone, 
        $resume
    );
}
