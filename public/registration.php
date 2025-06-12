<?php

require_once(__DIR__ . '../../src/validators/validate_email.php');
require_once(__DIR__ . '../../src/validators/validate_phone.php');
require_once(__DIR__ . '../../src/services/connection_database_service.php');
require_once(__DIR__ . '../../src/repositories/riskyjobs/riskyjobs_repository_get_by_id.php');
require_once(__DIR__ . '../../src/services/candidates/candidates_service_registration.php');

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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Risky Jobs - Registration</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>

<body>
    <img src="assets/images/riskyjobs_title.gif" alt="Risky Jobs" />
    <img src="assets/images/riskyjobs_fireman.jpg" alt="Risky Jobs" style="float:right" />

    <h2>Job Information</h2>

    <table class="tb_job_information">
        <thead>
            <tr>
                <td width="100px"></td>
                <td width="800px"></td>
            </tr>
        </thead>
        <tbody>
            <tr class="tr_job_information">
                <td>
                    <b>Job Title:</b>
                </td>
                <td>
                    <?php echo $job['title']; ?>
                </td>
            </tr>
            <tr class="tr_job_information">
                <td>
                    <b>Description:</b>
                </td>
                <td>
                    <?php echo $job['description']; ?>
                </td>
            </tr>
            <tr class="tr_job_information">
                <td>
                    <b>State:</b>
                </td>
                <td>
                    <?php echo $job['state']; ?>
                </td>
            </tr>
            <tr class="tr_job_information">
                <td><b> Date Posted: </b></td>
                <td><?php echo $job['date_posted']; ?> </td>
            </tr>
        </tbody>

    </table>
    <hr>

    <?php
    if ($has_error) {
        echo '<p class="error">' . $message_result . '</p>';
    } else {
        echo '<p>' . $message_result . '</p>';
        echo '<p> <a href="index.html">Back to Search Jobs Here</a> </p>';
    }

    ?>

    <?php if ($output_form) { ?>
        <h2>Registration</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />

            <p>Register with Risky Jobs, and post your resume.</p>

            <div class="form-group">
                <label for="first_name"> First Name:</label> <br>
                <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>"> <br>
                <span class='error'> <?php echo $first_name_error; ?></span>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label> <br>
                <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>"> <br>
                <span class="error"> <?php echo $last_name_error; ?> </span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label> <br>
                <input type="text" name="email" value="<?php echo $email; ?>"> <br>
                <span class="error"> <?php echo $email_error; ?> </span>
            </div>

            <div class="form-group">
                <label for="phone"> Phone: </label> <br>
                <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>"> <br>
                <span class="error"> <?php echo $phone_error; ?> </span>
            </div>

            <div class="form-group">
                <label for="resume">Paste your resume here:</label> <br />
                <textarea name="resume" id="resume" rows="4" cols="40"><?php echo $resume; ?></textarea><br>
                <span class="error"> <?php echo $resume_error; ?> </span>
            </div>

            <input type="submit" name="submit" value="Submit" />
        </form>
    <?php  }  ?>
</body>

</html>