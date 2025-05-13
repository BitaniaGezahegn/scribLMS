<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/NavLink.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
 
<?php
function NavLink(array $atts) {
    if (!isset($atts['navLink'])) {
        return;
    }
    $href = $atts['href'];
    $link = $atts['navLink'];
    $icon = $atts['icon'] ?? '';
        return ('
<a href="' . $href . '" class="link">
<span class="material-symbols-outlined bicon">
    ' . $icon . '
</span>
    <p>' . $link . '</p>
</a>
        
        ');
}
?>