<?php
require_once(__DIR__ . '/src/services/connection_database_service.php');
require_once(__DIR__ . '/src/repositories/riskyjobs_repository.php');
require_once(__DIR__ . '/src/enums/enum_sort_riskyjob.php');

function generate_sort_links(string $search, int $sort): string
{
    $names_links = [
        'Job Title' => $sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] :ENUM_SORT_RISKYJOBS['title_asc'],
        'Description' => null,
        'State' => $sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
        'Date Posted' => $sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc'],
    ];

    $sort_links = '<tr class="heading">';

    foreach ($names_links as $key => $value) {

        $url = $_SERVER['PHP_SELF'];

        if ($value != null)
            $sort_links .=  "<td> <a href='$url?search=$search&sort=$value'>$key</a> </td>";
        else
            $sort_links .=  "<td> $key </td>";
    }

    $sort_links .= '</tr>';

    return $sort_links;
}


$query_search = isset($_GET['search']) ? $_GET['search'] : '';
$query_sort = isset($_GET['sort']) ? $_GET['sort'] : 0;

$dbc = connection_database_service_get_dbc();
$result = riskyjobs_repository_get_all($dbc, $query_search, $query_sort);
connection_database_service_close($dbc);

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

        <?php

        echo generate_sort_links($query_search, $query_sort);

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