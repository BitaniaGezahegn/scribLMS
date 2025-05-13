<link rel="stylesheet" href="Components/CSS/reset.css">
<link rel="stylesheet" href="Components/CSS/Navigation.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<?php require_once 'subComponents/NavLink.php'; ?>
<?php require_once 'Button.php'; ?>

<?php
function Navigation(array $atts) {
    if (!isset($atts['navigation'])) {
        return;
    }
    $icon = $atts['icon'] ?? 'lock';
    $navlinks = [];

    if (isset($_SESSION['roleID'])) {
        if ($_SESSION['roleID'] == 1) {
            $userHref = 'Users.php';
        } else {
            $userHref = '?popup=error&message=unauthorized_access_librarian';
        }
    } else {
        $userHref = '?popup=error&message=unauthorized_access_librarian';
    }

    $navlinks[] = NavLink(atts:[
        'navLink' => 'Books',
        'href' => 'index.php'
    ]);
    $navlinks[] = NavLink(atts:[
        'navLink' => 'Authors',
        'href' => 'Authors.php'
    ]);
    $navlinks[] = NavLink(atts:[
        'navLink' => 'Users',
        'href' => $userHref,
        'icon' => $icon
    ]);

    if ($atts['navigation'] == 'default') {
        return ('
        <div class="navigation">
        <a class="logo" href="index.php">
            <img src="Assets/Images/Logo/Logo Single.png" alt="Logo">
        </a>
        
        <div class="nav-links">' 
        . $navlinks[0] . $navlinks[1] . $navlinks[2] .
        '</div>
        
        ' . Button(
            atts: [
                'btnType' => 'filled',
                'button' => 'Add Book',
                'symbol' => 'add_circle',
                'background' => 'var(--primary)',
                'color' => 'var(--background)',
                'url' => './Add_Book.php'
            ]
        )
         . '
    </div>
    ');
    }
}
?>
<script defer src="Components/JS/Navigation.js"></script>