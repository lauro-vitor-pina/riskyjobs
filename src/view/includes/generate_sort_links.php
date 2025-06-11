<?php 

function generate_sort_links(array $sort_config, string $query_search): string
{
    $sort_links = '';

    foreach ($sort_config as $link_name => $sort_value) {

        $url = $_SERVER['PHP_SELF'];

        if ($sort_value != null)
            $sort_links .=  "<td> <a href='$url?search=$query_search&sort=$sort_value'>$link_name</a> </td>";
        else
            $sort_links .=  "<td> $link_name </td>";
    }

    return $sort_links;
}