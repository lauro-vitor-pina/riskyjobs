<?php
require_once(__DIR__ . '/src/services/connection_database_service.php');
require_once(__DIR__ . '/src/repositories/riskyjobs_repository.php');

$result = [];

if (isset($_GET['search'])) {

    $dbc = connection_database_service_get_dbc();

    $result = riskyjobs_repository_get_all($dbc, $_GET['search']);

    connection_database_service_close($dbc);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Risky Jobs - Search</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>

<body>
    <img src="assets/images/riskyjobs_title.gif" alt="Risky Jobs" />
    <img src="assets/images/riskyjobs_fireman.jpg" alt="Risky Jobs" style="float:right" />
    <h3>Risky Jobs - Search Results</h3>

    <table border="0" cellpadding="2">
        <tr class="heading">
            <td>Job Title</td>
            <td>Description</td>
            <td>State</td>
            <td>Date Posted</td>
        </tr>

        <?php

        foreach ($result as $row) {
            echo '<tr class="results">';
            echo '<td valign="top" width="20%">' . $row['title'] . '</td>';
            echo '<td valign="top" width="50%">' . substr($row['description'], 0, 100) . ' ...</td>';
            echo '<td valign="top" width="10%">' . $row['state'] . '</td>';
            echo '<td valign="top" width="20%">' . substr($row['date_posted'], 0, 10) . '</td>';
            echo '</tr>';
        }

        ?>

    </table>
</body>

</html>