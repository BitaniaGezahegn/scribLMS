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
    <title>View Book Detail | Scrib Library</title>
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
    <link rel="stylesheet" href="Assets/css/Book_Details.css">
</head>
<body>

<?php
if (isset($_GET['ISBN'])) {
    $ISBN = $_GET['ISBN'];
} else if (isset($_POST['ISBN'])) {
    $ISBN = $_POST['ISBN'];
    $nextISBN = '';
    $prevISBN = '';


    foreach (getALLISBNs() as $key => $value) { 
        if ($_POST['ISBN'] == $value['ISBN']) {
            $nextISBN = getALLISBNs()[$key + 1]['ISBN'] ?? $value['ISBN'];
            $prevISBN = getALLISBNs()[$key - 1]['ISBN'] ?? $value['ISBN'] ;
            break;
        }
    }
    if ($_POST['action'] == 'next') {
        $ISBN = $nextISBN;
    } else if ($_POST['action'] == 'prev') {
        $ISBN = $prevISBN;
    }
    
    header('location: Book_Details.php?ISBN=' . $ISBN);
}

$book = searchBooks($ISBN)['books'][0];
$authorBio = '';
foreach (getAuthors() as $key => $value) {
    if ($value['Name'] == $book['Authors'][0]) {
        $authorBio = $value['Biography'];
    }
}
?>

<!-- Components -->
<?php require_once 'Components/Account.php' ?>
<?php require_once 'Components/Navigation.php' ?>

    <div class="container">
        <!-- Navigation -->
        <?= Navigation(atts: [
        'navigation' => 'default',
        'icon' => $navIcon
        ]);?>
        
        <!-- Content -->
        <div class="content content-details" id="content">
            <div class="banner" style='background: url("<?= $book['bookCover'] ?>");'></div>
            <div class="content-wrapper">
            
                <div class="floating-cover">
                  <img src=" <?= $book['bookCover'] ?>" alt="Book Cover">
                </div>

                <div class="main-details">
                    <div class="title-paginate">
                        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
                            <button type="submit">
                                <input type="hidden" name="action" value="prev">
                                <input type="hidden" name="ISBN" value=<?=$ISBN?>>
                                <span class="material-symbols-outlined">
                                    chevron_left
                                </span>
                            </button>
                        </form>
                        <h2> <?= $book['title'] ?></h2>
                        <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
                            <button type="submit">
                                <input type="hidden" name="action" value="next">
                                <input type="hidden" name="ISBN" value=<?=$ISBN?>>
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </button>
                        </form>
                    </div>
                    
                    <p class="author"> <?= $book['author'] ?></p>

                    <div class="actions-wrapper">
                        <div class="edit action" title="Edit book" data-isbn=<?= $ISBN ?> onclick="redirectToEdit(this)">
                            <span class="material-symbols-outlined">
                                edit_square
                            </span>
                        </div>
                        <div class="delete action" title="Delete book" data-isbn=<?= $ISBN ?> onclick="redirectToDelete(this)">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </div>
                    </div>
                </div>

                <div class="all-details">
                    <div class="left-details">
                        <h4 class="heading">Details</h4>
                        <div class="detail">
                            <p class="sub">ISBN</p>
                            <p> <?= $ISBN ?></p>
                        </div>
                        <div class="detail">
                            <p class="sub">Genre</p>
                            <p><?= $book['genre'] ?></p>
                        </div>
                        <div class="detail">
                            <p class="sub">Publisher</p>
                            <p> <?= $book['publisher'] ?></p>
                        </div>
                        <div class="detail">
                            <p class="sub">Published in</p>
                            <p> <?= $book['publicationyear'] ?></p>
                        </div>
                        <div class="detail">
                            <p class="sub">Copies Available</p>
                            <p> <?= $book['copiesowned'] ?></p>
                        </div>
                    </div>

                    <div class="right-details">
                        <h4 class="heading">Description</h4>
                        <div class="description">
                            <p class="sub"> <?= $book['description'] ?></p>
                        </div>

                        <h4 class="heading biography">Author's Biography</h4>
                        <div class="detail">
                            <p class="sub"><?= $authorBio ?></p>
                        </div>
                    </div>
                </div>

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
    <script defer src="Assets/JS/script.js"></script>
</body>
</html>