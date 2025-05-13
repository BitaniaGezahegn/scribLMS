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
    <title>Add Book | Scrib Library</title>
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
    
    <!-- Custom Css -->
    <link rel="stylesheet" href="Assets/css/reset.css">
    <link rel="stylesheet" href="Assets/css/Add_Book.css">
</head>
<body>
    
<!-- Components -->
<?php require_once 'Components/Button.php' ?>
<?php require_once 'Components/Account.php' ?>
<?php require_once 'Components/Navigation.php' ?>
<?php require_once 'Components/Input.php' ?>
<?php
$options = [];
foreach (getGeners() as $key => $value) {
    $options[] = [
        'option' => $value['Name'],
        'value' => $value['ID']
    ];
}

$authors = [];
foreach (getAuthors() as $key => $value) {
    $authors[] = [
        'option' => $value['Name'],
        'value' => $value['ID']
    ];
}
?>
    <div class="container">
        <!-- Navigation -->
        <?= Navigation(atts: [
        'navigation' => 'default',
        'icon' => $navIcon
        ]);?>
        
        <!-- Content -->
         <div class="content" id="content">
            <div class="header">
                <span class="icon material-symbols-outlined">
                    add_circle
                </span>
                <h2>Add Book Information</h2>
                <?php
                $title = $POST['Title'] ?? '';
                $POST['Publisher'];
                
                ?>
            </div>

            <div class="form">
                <form action="Includes/Processes/Book/addBook.inc.php" method="POST" id="form">
                    <div class="left-inputs inputs">
                        <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'ISBN',
                        'placeholder' => 'International Standard Book Number'
                        ]) ?>

                        <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Title',
                        'placeholder' => 'Name of the Book'
                        ]) ?>

                        <?php 
                        echo Input(atts:[
                            'input' => 'multiselect',
                            'label' => 'Authors',
                            'placeholder' => '',
                            'options' => $authors
                        ]);

                        echo Input(atts:[
                            'input' => 'multiselect',
                            'label' => 'Geners',
                            'placeholder' => '',
                            'options' => $options
                        ]);
                        ?>

                        <?php echo Input(atts:[
                        'input' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description of the Book'
                        ]);
                        ?>
                    </div>
                    <div class="right-inputs inputs">
                    <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'PublicationYear',
                        'placeholder' => 'Only the year'
                        ]) ?>

                    <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Publisher',
                        'placeholder' => 'The company'
                        ]) ?>

                    <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'CoverImage',
                        'placeholder' => 'URL to the books cover'
                        ]) ?>

                    <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'CopiesAvailable',
                        'placeholder' => 'Quantity'
                        ]) ?>
                    <button type="submit" class="action-btn">
                    <?=
                    Button(
                        atts: [
                            'btnType' => 'filled',
                            'button' => 'Add Book',
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
                 
        <!-- Footer/Dashboard -->
        <?php
        if ($userrole == 1) {
            $role = 'Admin';
        } else {
            $role = 'Librarian';
        }
        ?>

        <?= Account(atts: ['owner' => $username, 'role' => $role, 'profile' => 'Assets/Images/Profile Pictures/profile picture.jpg']); ?>
        
    </div>
    <!-- Scripts -->
</body>
</html>