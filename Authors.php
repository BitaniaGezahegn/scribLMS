<?php
require_once 'config.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    require_once 'Includes/Data/dbFunctions.inc.php';

    $userrole = $_SESSION['roleID'];
    $userid = $_SESSION['userid'];
    $user = getUser('', $userid)['users'][$userid] ?? '';
    $username = $user['username'];


    if ($userrole === 1) {
        $navIcon = '';
    } else {
        $navIcon = 'lock';
    }
} else {
    header('location: auth.php?popup=error&message=unauthorized');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors | Scrib Library</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="Assets/Images/Logo/Icons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="Assets/Images/Logo/Icons/favicon.svg" />
    <link rel="shortcut icon" href="Assets/Images/Logo/Icons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="Assets/Images/Logo/Icons/apple-touch-icon.png" />
    <link rel="manifest" href="Assets/Images/Logo/Icons/site.webmanifest" />

    <!-- Custom Style Sheets -->
    <link rel="stylesheet" href="Assets/CSS/reset.css">
    <link rel="stylesheet" href="Assets/CSS/styles.css">
    <link rel="stylesheet" href="Assets/CSS/Authors.css">
</head>
<body>
<!-- Includes -->
<?php require_once 'Components/Search.php' ?>

<?php
$Aauthors = getAuthors();
if (isset($_GET['q'])) {
    if ($_GET['q'] != '') {
        $Aauthors = searchAuthors($_GET['q'])['authors'];
    }
}

$successMessages = ['Successfully <span class="completed">completed</span> the action :)', 'Successfully <span class="added">Added</span> a book to your database :)', 'Successfully <span class="deleted">Deleted</span> a book from your database :)', 'Successfully <span class="updated">Updated</span> a book from your database :)'];

if (isset($_GET['message'])) {
    $message = $successMessages[$_GET['message']] ?? $successMessages[0];
} else {
    $message = $successMessages[0];
}
$popup = $_GET['popup'] ?? '';
?>

<!-- Components -->
<?php require_once 'Components/Button.php' ?>
<?php require_once 'Components/Account.php' ?>
<?php require_once 'Components/Table.php' ?>
<?php require_once 'Components/Navigation.php' ?>
<?php require_once 'Components/Input.php' ?>
<?php require_once 'Components/Popup.php' ?>

<?php
$table = Table(atts: [
    'table' => 'authors',
    'rows' => $Aauthors
]);
?>

<div class="container" id="container">
<?=
Popup(
    atts: [
        'popup' => $popup,
        'message' => $message,
    ]);
?>
    <?= Navigation(atts: [
    'navigation' => 'default',
    'icon' => $navIcon
    ]);?>

    <div class="search-browse">
        <?= Search(atts: [
            'search' => '',
            'placeholder' => 'Search for an author'
        ]); ?>

        <div class="browse">
        <?=
        Button(
            atts: [
                'btnType' => 'filled',
                'button' => 'Add Author',
                'symbol' => 'add_circle',
                'background' => 'var(--background)',
                'color' => 'var(--link)',
                'type' => 'div',
                'url' => '',
                'id' => 'addAuthor'
            ]
        );
        ?>
        </div>
    </div>

<!-- List View-->
<div class="list" id="list_mode_container">
    <table>
        <thead>
            <tr><?php foreach ($table[0] as $key => $value) {
                echo $value;
            } ?></tr>
        </thead>
        </tbody>
        <?php foreach ($table[1] as $key => $value) {
                echo '<tr>';
                foreach ($value as $key => $value) {
                    echo $value;
                }
                echo '</tr>';
            } ?>
        </tbody>
    </table>
</div>


<?php
    if ($userrole == 1) {
        $role = 'Admin';
    } else {
        $role = 'Librarian';
    }
    ?>

    <?= Account(atts: ['owner' => $username, 'role' => $role, 'profile' => 'Assets/Images/Profile Pictures/profile picture.jpg']); ?>
</div>

<!-- Add Author -->
<div class="content add-author-container" style="display: none; width: 80%;">
        <div class="quit" id="quitAddAutor">
        <span class="material-symbols-outlined">
            close
        </span>
        </div>

        <div class="header">
                <span class="icon material-symbols-outlined">
                    add_circle
                </span>
                <h2>Add Author</h2>
        </div>

        <div class="form">
            <form action="Includes/Processes/Author/addAuthor.inc.php" method="POST">
                <div class="left-inputs inputs">
                    <?= Input(atts:[
                            'input' => 'regular',
                            'label' => 'First Name',
                            'placeholder' => 'First Name of the Author',
                            'name' => 'firstname'
                    ]) ?>
                    <?php echo Input(atts:[
                        'input' => 'textarea',
                        'label' => 'Biography',
                        'placeholder' => 'Description of the Author',
                        'name' => 'biography'
                        ]);
                    ?>
                </div>
                <div class="right-inputs inputs">
                <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Last Name',
                        'placeholder' => 'Last Name of the Author',
                        'name' => 'lastname'
                ]) ?>

                <button type="submit" class="action-btn">
                    <?=
                    Button(
                        atts: [
                            'btnType' => 'filled',
                            'button' => 'Add Author',
                            'symbol' => 'add_circle',
                            'background' => 'var(--primary)',
                            'color' => 'var(--background)',
                            'url' => '#',
                            'type' => 'div'
                        ]
                    );
                    ?>
                </button>

                </div>
            </form>
        </div>
</div>


<?php
 if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $data = getAuthor($id)['authors'][$id] ?? '';
    $firstname = $data['firstName'] ?? '';
    $lastname = $data['lastName'] ?? '';
    $biography = $data['Biography'] ?? '';

    echo '
    <script defer>
        setTimeout(() => {
            editAuthorContainer.style.display = "flex";
        }, 1);
    </script>';
 } else {
    echo '
    <script defer>
        setTimeout(() => {
            editAuthorContainer.style.display = "none";
        }, 1);
    </script>';
 }
 ?>

<!-- Edit Author -->
<div class="content edit-author-container" style="display: none; width: 80%;">
        <div class="quit" id="quitEditAutor">
        <span class="material-symbols-outlined">
            close
        </span>
        </div>

        <div class="header">
                <span class="icon material-symbols-outlined" style="color: var(--heading);">
                    border_color
                </span>
                <h2 style="color: var(--heading);">Edit Author Details</h2>
        </div>

        <div class="form">
            <form action="Includes/Processes/Author/editAuthor.inc.php" method="POST">
                <input type="text" hidden name="id" value="<?= $id ?>">
                <div class="left-inputs inputs">
                    <?= Input(atts:[
                            'input' => 'regular',
                            'label' => 'First Name',
                            'placeholder' => 'First Name of the Author',
                            'name' => 'firstname',
                            'value' => $firstname
                    ]) ?>
                    <?php echo Input(atts:[
                        'input' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description of the Book',
                        'name' => 'biography',
                        'value' => $biography
                        ]);
                    ?>
                </div>
                <div class="right-inputs inputs">
                <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Last Name',
                        'placeholder' => 'Last Name of the Author',
                        'name' => 'lastname',
                        'value' => $lastname
                ]) ?>

                <button type="submit" class="action-btn">
                    <?=
                    Button(
                        atts: [
                            'btnType' => 'filled',
                            'button' => 'Edit Author\'s Details',
                            'symbol' => 'edit',
                            'background' => 'var(--heading)',
                            'color' => 'var(--background)',
                            'url' => '#',
                            'type' => 'div'
                        ]
                    );
                    ?>
                </button>

                </div>
            </form>
        </div>
</div>
</body>
<script defer src="Assets/JS/authors.js"></script>
</html>