<link rel="stylesheet" href="CSS/reset.css">
<link rel="stylesheet" href="CSS/Component.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
 
<?php
function Component(array $atts) {
    if (!isset($atts['comp'])) {
        return;
    }
    if ($atts['comp'] == 'value') {
        return ('
        
        ');
    }
}
?>

<link rel="stylesheet" href="CSS/reset.css">
<link rel="stylesheet" href="CSS/Popup.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" /> -->
 
<?php
function Popup(array $atts) {
    if (!isset($atts['popup'])) {
        return;
    }
    
    if ($atts['popup'] == 'value') {
        return ('
        
        ');
    }
}
?>