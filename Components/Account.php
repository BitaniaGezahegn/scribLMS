<link rel="stylesheet" href="Assets/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Account.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<?php
function Account(array $atts) {
    if (!isset($atts['owner']) && !isset($atts['role']) && !isset($atts['profile'])) {
        return;
    }
    $action = $atts['action'] ?? 'Includes/Processes/User/signout.inc.php';

    // else Continue
    return (
        '
<div class="footer">
    <div class="left-side">
        <div class="profile-picture">
            <img src="' . $atts['profile'] . '" alt="Profile Picture">
        </div>

        <div class="user-details">
            <h4>' . $atts['owner'] . '</h4>
            <p class="sub">>> ' . $atts['role'] . '</p>
        </div>
    </div>

    <form action="' . $action . '" method="GET" class="right-side">
        <button type="submit" class="logout" style="border: none; background-color: transparent; outline: none;">
            <span class="material-symbols-outlined icon">
                logout
            </span>
        </button>
    </form>
</div>
        '
    );
}

?>