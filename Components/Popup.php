<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Popup.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
 
<?php
function Popup(array $atts) {
    if (!isset($atts['popup'])) {
        return;
    }

    $popup = $atts['popup'] ?? 'error';
    $header = $atts['header'] ?? $popup;
    $message = $atts['message'] ?? '';
    
    $borderColor = 'secondary';
    $symbol = 'close';
    // If Success
    if ($popup != 'error') {
        $borderColor = 'primary';
        $symbol = 'check';
    }

    return ('
<div class="popup-container ' . $popup . '" id="popup-container">
    <div class="status ' . $popup . '" style="background-color: var(--' . $popup . '); border: 2px solid var(--' . $borderColor . ');">
        <span class="material-symbols-outlined">
            ' . $symbol . '
        </span>
    </div>
    
    <div class="popup-content">
        <div class="wrapper">
            <span class="timer-container">
                <span class="timer" style="background-color: var(--' . $popup . ');" id="timer"></span>
            </span>
            <span class="material-symbols-outlined close" id="close">
                close
            </span>
        </div>
        <h4 class="messagetype">' . $header . '</h4>
        <p class="sub message">' . $message . '</p>
        </div>
</div>
        ');
}
?>
<script defer src="Components/JS/Popup.js"></script>