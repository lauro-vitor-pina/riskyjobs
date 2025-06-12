<?php
require_once(__DIR__ . '../../src/services/connection_database_service.php');
require_once(__DIR__ . '../../src/repositories/riskyjobs/riskyjobs_repository_get_all.php');
require_once(__DIR__ . '../../src/enums/enum_sort_riskyjob.php');
require_once(__DIR__ . '/includes/generate_sort_links.php');
require_once(__DIR__ . '/includes/generate_pagination_links.php');

$dbc = connection_database_service_get_dbc();

$search = isset($_GET['search']) ? mysqli_real_escape_string($dbc, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? (int)mysqli_real_escape_string($dbc, $_GET['sort']) : 0;
$page_number = isset($_GET['page']) ? (int)mysqli_real_escape_string($dbc, $_GET['page']) : 1;
$page_size = 5;

$result = riskyjobs_repository_get_all($dbc, $search, $sort, $page_number, $page_size);
$total = $result['total'];
$num_pages = $result['num_pages'];
$rows = $result['rows'];

$sort_config = [
    'Job Title' => $sort == ENUM_SORT_RISKYJOBS['title_asc'] ? ENUM_SORT_RISKYJOBS['title_desc'] : ENUM_SORT_RISKYJOBS['title_asc'],
    'Description' => null,
    'State' => $sort == ENUM_SORT_RISKYJOBS['state_asc'] ? ENUM_SORT_RISKYJOBS['state_desc'] : ENUM_SORT_RISKYJOBS['state_asc'],
    'Date Posted' => $sort == ENUM_SORT_RISKYJOBS['date_posted_asc'] ? ENUM_SORT_RISKYJOBS['date_posted_desc'] : ENUM_SORT_RISKYJOBS['date_posted_asc']
];

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
        if ($total > 0) {
            echo  '<tr class="heading">';

            echo generate_sort_links($sort_config, $search);

            echo '</tr>';

            foreach ($rows as $row) {
                echo '<tr class="results">';
                echo '<td valign="top" width="20%"> 
                        <a title="click here to apply"  href="registration.php?job_id='.$row['job_id'].'">' . $row['title'] . ' </a>
                     </td>';
                echo '<td valign="top" width="50%">' . substr($row['description'], 0, 100) . ' ...</td>';
                echo '<td valign="top" width="10%">' . $row['state'] . '</td>';
                echo '<td valign="top" width="20%">' . substr($row['date_posted'], 0, 10) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<h4>No results found</h4>';
        }

        ?>

    </table>

    <?php
    if ($num_pages > 1) {
        echo generate_pagination_links(
            $page_number,
            $num_pages,
            $search,
            $sort
        );
    }
    ?>
</body>

</html>