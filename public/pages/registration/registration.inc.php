<?php

require_once(__DIR__ . '../../../../src/validators/validate_email.php');
require_once(__DIR__ . '../../../../src/validators/validate_phone.php');
require_once(__DIR__ . '../../../../src/services/connection_database_service.php');
require_once(__DIR__ . '../../../../src/services/candidates/candidates_service_registration.php');
require_once(__DIR__ . '../../../../src/repositories/riskyjobs/riskyjobs_repository_get_by_id.php');


$job_id = isset($_GET['job_id']) ? $_GET['job_id'] : 0;
$first_name = '';
$last_name =  '';
$email = '';
$phone = '';
$desired_job = '';
$resume =  '';

$output_form = true;
$has_error = false;
$first_name_error = '';
$last_name_error = '';
$email_error = '';
$desired_job_error = '';
$phone_error = '';
$resume_error = '';

$message_result = '';

$dbc = connection_database_service_get_dbc();

if (isset($_POST['submit'])) {

    $job_id = mysqli_escape_string($dbc, $_POST['job_id']);
    $first_name = mysqli_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_escape_string($dbc, trim($_POST['email']));
    $phone = mysqli_escape_string($dbc, trim($_POST['phone']));
    $resume = mysqli_escape_string($dbc, trim($_POST['resume']));


    if (empty($first_name)) {
        $has_error = true;
        $first_name_error = 'You forgot to enter your first name.';
    }

    if (empty($last_name)) {
        $has_error = true;
        $last_name_error = 'You forgot to enter your last name.';
    }

    if (!validate_email($email)) {
        $has_error = true;
        $email_error = 'Your e-mail is invalid.';
    }

    if (!validate_phone($phone)) {
        $has_error = true;
        $phone_error =  'Your phone number is invalid, must be in XXX-XXX-XXXX format.';
    }

    if (empty($resume)) {
        $has_error = true;
        $resume_error = 'You forgot to enter your resume.';
    }

    if (!$has_error) {

        $new_phone = preg_replace('/[\(\)\-\s]/', '', $phone);

        try {

            candidates_service_registration(
                $dbc,
                $job_id,
                $first_name,
                $last_name,
                $email,
                $new_phone,
                $resume
            );

            $message_result = $first_name . ' ' . $last_name . ', thanks for registering with Risky Jobs!';
        } catch (Exception $ex) {
            $has_error = true;
            $message_result = $ex->getMessage();
        }
    }

    $output_form = $has_error;
}


$job = riskyjobs_repository_get_by_id($dbc, $job_id);

connection_database_service_close($dbc);

if ($job == null) {
    exit('Ops! Job not found');
}
