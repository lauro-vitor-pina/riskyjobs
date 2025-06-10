<?php 

function generate_pagination_links($current_page, $num_pages, $search, $sort)
{
    $url = $_SERVER['PHP_SELF'];

    $next_page = $current_page + 1;

    $previous_page = $current_page - 1;

    $page_links = '';

    if ($current_page <= 1) {
        $page_links .= '<-';
    } else {  //se esta pagina não for a primeira, gera o link de página anterior (previous)
        $page_links .=  "<a href='$url?search=$search&sort=$sort&page=$previous_page'><-</a>";
    }

    for ($i = 1; $i <= $num_pages; $i++) { //faz um loop através das páginas, gerando os links com os números das páginas

        $number_of_page = $i;

        $page_links .=  "<a href='$url?search=$search&sort=$sort&page=$i'>$number_of_page</a>";
    }

    if ($current_page >= $num_pages) {
        $page_links .= '->';
    } else {  //se esta pagina não for a última, gera o link de proxima pagina
        $page_links .=  "<a href='$url?search=$search&sort=$sort&page=$next_page'>-></a>";
    }

    return $page_links;
}
