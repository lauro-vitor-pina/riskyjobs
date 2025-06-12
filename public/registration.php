<?php

require_once(__DIR__ . '../../src/validators/validate_email.php');
require_once(__DIR__ . '../../src/validators/validate_phone.php');
require_once(__DIR__ . '../../src/services/connection_database_service.php');

$first_name = '';
$last_name =  '';
$email = '';
$phone = '';
$desired_job = '';
$resume =  '';

$first_name_error = '';
$last_name_error = '';
$email_error = '';
$desired_job_error = '';
$phone_error = '';
$resume_error = '';

if (isset($_POST['submit'])) {

    $dbc = connection_database_service_get_dbc();

    $first_name = mysqli_escape_string($dbc, trim($_POST['first_name']));
    $last_name = mysqli_escape_string($dbc, trim($_POST['last_name']));
    $email = mysqli_escape_string($dbc, trim($_POST['email']));
    $phone = mysqli_escape_string($dbc, trim($_POST['phone']));
    $desired_job = mysqli_escape_string($dbc, trim($_POST['desired_job']));
    $resume = mysqli_escape_string($dbc, trim($_POST['resume']));
    $output_form = false;

    //form validation
    if (empty($first_name)) {
        $output_form = true;
        $first_name_error = 'You forgot to enter your first name.';
    }

    if (empty($last_name)) {
        $output_form = true;
        $last_name_error = 'You forgot to enter your last name.';
    }

    if (!validate_email($email)) {
        $output_form = true;
        $email_error = 'Your e-mail is invalid.';
    }

    if (!validate_phone($phone)) {
        $output_form = true;
        $phone_error =  'Your phone number is invalid, must be in XXX-XXX-XXXX format.';
    }

    if (empty($desired_job)) {
        $output_form = true;
        $desired_job_error = 'You forgot to enter your desired job.';
    }

    if (empty($resume)) {
        $output_form = true;
        $resume_error = 'You forgot to enter your resume.';
    }

    if (!$output_form) {

        $new_phone = preg_replace('/[\(\)\-\s]/', '', $phone);
        //insert a registration
    }

    connection_database_service_close($dbc);
} else {
    $output_form = true;
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
    <h3>Risky Jobs - Registration</h3>

    <?php if ($output_form) { ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <p>Register with Risky Jobs, and post your resume.</p>
            <table>
                <tr>
                    <td>
                        <label for="first_name"> First Name:</label>
                    </td>
                    <td>
                        <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>">
                        <span class='error'> <?php echo $first_name_error; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="last_name">Last Name:</label>
                    </td>
                    <td>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>">
                        <span class="error">
                            <?php echo $last_name_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email:</label>
                    </td>
                    <td>
                        <input type="text" name="email" value="<?php echo $email; ?>">
                        <span class="error">
                            <?php echo $email_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="phone"> Phone: </label>
                    </td>
                    <td>
                        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>">
                        <span class="error">
                            <?php echo $phone_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="desired_job">Desired Job:</label>
                    </td>
                    <td>
                        <input type="text" name="desired_job" id="desired_job" value="<?php echo $desired_job; ?>">
                        <span class="error">
                            <?php echo $desired_job_error; ?>
                        </span>
                    </td>
                </tr>
            </table>
            <p>
                <label for="resume">Paste your resume here:</label> <br />
                <textarea name="resume" id="resume" rows="4" cols="40"><?php echo $resume; ?></textarea>
                <br>
                <span class="error">
                    <?php echo $resume_error; ?>
                </span>
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
    <?php  } else {
        echo '<p>' . $first_name . ' ' . $last_name . ', thanks for registering with Risky Jobs!</p>';
    } ?>
</body>

</html>