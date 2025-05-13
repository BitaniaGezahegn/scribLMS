<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Button.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<?php

function Button(array $atts) {
    if (!isset($atts['btnType'])) {
        return;
    }

    // else cotinue
    if ($atts['btnType'] == 'viewby') {
        return (
            '
<div class="view-by btn view-list collapsed" id="view_by">
    <span class="material-symbols-outlined" id="view_icon">
        list
    </span>
    <p>View By</p>
    <span class="material-symbols-outlined arrow" id="view_arrow">
        arrow_drop_down
    </span>

    <div class="select" id="view_select">
        <p class="option" id="list_mode">
            <span class="material-symbols-outlined">
                list
            </span>
            List
        </p>
        <p class="option" id="grid_mode">
            <span class="material-symbols-outlined">
                grid_view
            </span>
            Grid
        </p>
    </div>
</div>

                '
        );
    } else if ($atts['btnType'] == 'filterby')
    {
        return (
            '
<div class="filters btn filter-genre collapsed" id="filter_by">
    <span class="material-symbols-outlined" id="filter_icon">
        filter_list
    </span>
    <p>Filters</p>
    <span class="material-symbols-outlined" id="filter_arrow">
        arrow_drop_down
    </span>

    <div class="select" id="filter_select">
        <p class="option" id="genre_mode">
            <span class="material-symbols-outlined">
                filter_list
            </span>
            Genre
        </p>
        <p class="option" id="author_mode">
            <span class="material-symbols-outlined">
            person_4
        </span>
            Author
        </p>
    </div>
</div>
<script defer src="Components/JS/Button.js"></script>
            '
        );
    } else if ($atts['btnType'] == 'filled') {
        // Setting Background
        if (isset($atts['background']) && $atts['background'] != '') {
            $background = $atts['background'];
        } else if (isset($atts['background']) && $atts['background'] == ''){
            $background = 'var(--primary)';
        }

        // Setting color
        if (isset($atts['color']) && $atts['color'] != '') {
            $color = $atts['color'];
        } else if (isset($atts['color']) && $atts['color'] == ''){
            $color = 'var(--background)';
        }

        // Setting url
        if (isset($atts['url']) && $atts['url'] != '') {
            $url = $atts['url'];
        } else if (isset($atts['url']) && $atts['url'] == ''){
            $url = 'Add_Book.php';
        }

        // Setting button type        
        if (isset($atts['type']) && $atts['type'] != '') {
            $type = $atts['type'];
        } else if (isset($atts['type']) && $atts['type'] == '' || !isset($atts['type'])){
            $type = 'a';
        }

        // Setting ID
        if (isset($atts['id']) && $atts['id'] != '') {
            $id = $atts['id'];
        } else {
            $id = '';
        }


        return ('
<' . $type . ' href="' . $url . '" class="filled" style="background-color: ' . $background . ';" id="'. $id . '">
    <span class="icon material-symbols-outlined" style="color: ' . $color . ';">
        ' . $atts['symbol'] . '
    </span>
    <p style="color: ' . $color . ';">' . $atts['button'] . '</p>
</' . $type . '>
        ');
    }
}
?>