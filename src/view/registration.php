<?php
require_once(__DIR__ . '../../controller/riskyjobs_controller.php');

$view_model =  riskyjobs_controller_handler_registration();

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
    <?php if ($view_model->output_form) { ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <p>Register with Risky Jobs, and post your resume.</p>
            <table>
                <tr>
                    <td>
                        <label for="first_name"> First Name:</label>
                    </td>
                    <td>
                        <input type="text" name="first_name" id="first_name" value="<?php echo $view_model->first_name; ?>">
                        <span class='error'> <?php echo $view_model->first_name_error; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="last_name">Last Name:</label>
                    </td>
                    <td>
                        <input type="text" name="last_name" id="last_name" value="<?php echo $view_model->last_name; ?>">
                        <span class="error">
                            <?php echo $view_model->last_name_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email:</label>
                    </td>
                    <td>
                        <input type="text" name="email" value="<?php echo $view_model->email; ?>">
                        <span class="error">
                            <?php echo $view_model->email_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="phone"> Phone: </label>
                    </td>
                    <td>
                        <input type="text" name="phone" id="phone" value="<?php echo $view_model->phone; ?>">
                        <span class="error">
                            <?php echo $view_model->phone_error; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="desired_job">Desired Job:</label>
                    </td>
                    <td>
                        <input type="text" name="desired_job" id="desired_job" value="<?php echo $view_model->desired_job; ?>">
                        <span class="error">
                            <?php echo $view_model->desired_job_error; ?>
                        </span>
                    </td>
                </tr>
            </table>
            <p>
                <label for="resume">Paste your resume here:</label> <br />
                <textarea name="resume" id="resume" rows="4" cols="40"><?php echo $view_model->resume; ?></textarea>
                <br>
                <span class="error">
                    <?php echo $view_model->resume_error; ?>
                </span>
            </p>
            <input type="submit" name="submit" value="Submit" />
        </form>
    <?php  } else {
        echo '<p>' . $view_model->first_name . ' ' . $view_model->last_name . ', thanks for registering with Risky Jobs!</p>';
    } ?>
</body>

</html>