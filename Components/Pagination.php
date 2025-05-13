<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Pagination.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
<?php
function Pagination(array $atts) {
    global $pagination;

    if (!isset($atts['pagination'])) {
        return;
    }
    $page = $atts['page'];
    $group = $atts['group'];
    if ($atts['pagination'] == 'list') {    
        return ('
<div class="pagination">
    <div class="page-info">
        <p id="page_data">Page ' . $page . ' of ' . $group . '</p>
    </div>

    <div class="buttons">
        <form class="pagination_prev pagination-form" method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <button class="sub" type"submit" name="page" value="' . $pagination->currentPage - 1 . '">Previous</button>
            <input type="text" name="viewType" value="list" hidden>
        </form>

        <form class="pagination_next pagination-form" method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <button class="sub" type"submit" name="page" value="' . $pagination->currentPage + 1 . '">Next</button>
            <input type="text" name="viewType" value="list" hidden>
        </form>
    </div>
</div>
    ');

    } else if ($atts['pagination'] == 'grid') {
        return ('
<div class="pagination pagination-cover">
    <div class="page-info">
        <p>Page ' . $page . ' of ' . $group . '</p>
    </div>
    
    <div class="buttons">
        <form class="pagination_prev pagination-form" method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <button class="sub" type"submit" name="page" value="' . $pagination->currentPage - 1 . '">Previous</button>
            <input type="text" name="viewType" value="grid" hidden>
        </form>
        <form class="pagination_next pagination-form" method="POST" action="' . $_SERVER['PHP_SELF'] . '">
            <button class="sub" type"submit" name="page" value="' . $pagination->currentPage + 1 . '">Next</button>
            <input type="text" name="viewType" value="grid" hidden>
        </form>
    </div>
</div> 
        ');
    }
}
?>