<?php

require_once(__DIR__ . '../../controller/riskyjobs_controller.php');
require_once(__DIR__ . '/includes/generate_sort_links.php');
require_once(__DIR__ . '/includes/generate_pagination_links.php');

$view_model = riskyjobs_controller_handler_search();

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
        if ($view_model->total > 0) {
            echo  '<tr class="heading">';

            echo generate_sort_links($view_model->get_sort_config(), $view_model->search);

            echo '</tr>';

            foreach ($view_model->rows as $row) {
                echo '<tr class="results">';
                echo '<td valign="top" width="20%">' . $row['title'] . '</td>';
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
    if ($view_model->num_pages > 1) {
        echo generate_pagination_links(
            $view_model->page_number,
            $view_model->num_pages,
            $view_model->search,
            $view_model->sort
        );
    }
    ?>
</body>

</html>