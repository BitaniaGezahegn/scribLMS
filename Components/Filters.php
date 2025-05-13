<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Filters.css">

<?php
function Filters(array $atts) {
    if (!isset($atts['filters'])) {
        return;
    }
    
    $name = $atts['name'] ?? '';

    $filters = [];
    foreach ($atts['filters'] as $key => $value) {
        $filters[] = '
        
        <button type="submit" name="' . $name . '" value="' . $value['ID'] . '" class="filter-btn">
        <p>' . $value['Name'] . '</p>
        </button>
        ';
    }

    $result = '<form action="' . $_SERVER['PHP_SELF'] . '" method="GET" class="filters-container" id="filters_contaienr">';

    for ($i=0; $i < count($filters); $i++) { 
        $result .= $filters[$i];
    }
    return ($result . '</form>');
}
?>
<script defer src="Components/JS/Filters.js"></script>