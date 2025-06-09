<?php
require_once(__DIR__ . '/src/services/connection_database_service.php');
require_once(__DIR__ . '/src/repositories/riskyjobs_repository.php');
require_once(__DIR__ . '/src/enums/enum_sort_riskyjob.php');


$query_search = isset($_GET['search']) ? $_GET['search'] : '';
$query_sort = isset($_GET['sort']) ? $_GET['sort'] : 0;

$dbc = connection_database_service_get_dbc();
$result = riskyjobs_repository_get_all($dbc, $query_search, $query_sort);
connection_database_service_close($dbc);

$sort_config = [
    'Job Title' => $query_sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] :ENUM_SORT_RISKYJOBS['title_asc'],
    'Description' => null,
    'State' => $query_sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
    'Date Posted' => $query_sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc'],
];

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

        echo  '<tr class="heading">';

        echo generate_sort_links($sort_config, $query_search);

        echo '</tr>';

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

<?php 

function generate_sort_links(array $sort_config, string $query_search): string
{
    $sort_links = '';

    foreach ($sort_config as $key => $value) {

        $url = $_SERVER['PHP_SELF'];

        if ($value != null)
            $sort_links .=  "<td> <a href='$url?search=$query_search&sort=$value'>$key</a> </td>";
        else
            $sort_links .=  "<td> $key </td>";
    }

    return $sort_links;
}


?>