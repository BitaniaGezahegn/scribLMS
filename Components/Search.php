<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Search.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<?php
function Search(array $atts) {
    $value = '';
    if (!isset($atts['search'])) {
        return;
    }
    
    if (!isset($_GET['q'])) {
        $value = '';
    } else {
        $value = $_GET['q'];
    }
    $placeholder = $atts['placeholder'] ?? '';

    if (isset($atts['search'])) {
        return ('
<form class="search" id="search">
    <div class="wrapper" method="GET" action="' . $_SERVER['PHP_SELF'] . '">
        <input type="text" placeholder="' . $placeholder . '" id="search_input" name="q" value="' . $value . '">
    </div>

    <button type="submit" class="search-icon" >
        <span class="material-symbols-outlined">
            search
        </span>
    </button>
</form>
        ');
    }
}
?>
<script defer src="Components/JS/Search.js"></script>