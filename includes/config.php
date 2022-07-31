<?php
define('SITEURL', '/contactsbook/');

function print_arr($arr)
{
    echo "<pre>";
    print_r($arr);
    exit();
}

// pagination

function getpagination($total_records, $current_page = 1, $per_page = 5)
{
    $total_pages = !empty($total_records) ? ceil($total_records / $per_page) : 0;
    $pagination = '';
    if ($total_pages > 1) {

        $pagination .= '<nav>
        <ul class="pagination justify-content-center">';
        $prevClass = ($current_page <= 1) ? " disabled" : "";

        $pagination .= '<li class="page-item' . $prevClass . '">
            <a class="page-link" href="' . SITEURL . 'index.php?page=' . ($current_page - 1) . '" >Previous</a>
            </li>';
        for ($page = 1; $page <= $total_pages; $page++) {
            if ($page == $current_page) {
                $pagination .= '<li class="page-item active"><a class="page-link" href="' . SITEURL . 'index.php?page=' . $page . '">' . $page . '</a></li>';
            } else {
                $pagination .= '<li class="page-item"><a class="page-link" href="' . SITEURL . 'index.php?page=' . $page . '">' . $page . '</a></li>
                ';
            }

        }

        $nextClass = ($current_page >= $total_pages) ? " disabled" : "";

        $pagination .= '<li class="page-item' . $nextClass . '">
            <a class="page-link" href="' . SITEURL . 'index.php?page=' . ($current_page + 1) . '">Next</a>
        </li>';

        $pagination .= '</ul>
    </nav>';
    }
    echo $pagination;
}
