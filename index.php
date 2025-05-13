<!-- Includes -->
<?php require_once 'Components/Search.php' ?>
<?php require_once 'Includes/Processes/Book/Paginate.inc.php'?>
<!-- Components -->
<?php require_once 'Components/Button.php' ?>
<?php require_once 'Components/Account.php' ?>
<?php require_once 'Components/Table.php' ?>
<?php require_once 'Components/Filters.php' ?>
<?php require_once 'Components/Navigation.php' ?>
<?php require_once 'Components/Pagination.php' ?>
<?php require_once 'Components/Card.php' ?>
<?php require_once 'Components/Popup.php' ?>

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
    exit();
}

// Popup Messages 
if (isset($_GET['popup']) && $_GET['popup'] == 'error') {
    $message = '';
    switch ($_GET['message']) {
        case 'missing_credentials':
            $message = "Please enter a username and password.";
            break;
        case 'wrong_password':
            $message = "Incorrect password.";
            break;
        case 'user_not_found':
            $message = "User not found.";
            break;
        case 'unapproved':
            $message = "Your account is not yet approved.";
            break;
        case 'unauthorized':
                $message = "Please login to continue.";
                break;
        case 'unauthorized_access_librarian':
                $message = "Only admins can access the users page.";
                break;
        case 'invalid_isbn':
                $message = "Invalid ISBN code.";
                break;
        default:
            $message = "Unexpected error occurred.";
        }
        echo Popup(atts: ['popup' => 'error', 'message' => $message]);
        
    } else if (isset($_GET['popup']) && $_GET['popup'] == 'success') {
        $message = '';
    switch ($_GET['message']) {
        case 'account_creation_success':
            $message = "Your account was successfully created";
            break;
        case 'signout_success':
            $message = "You have successfully signed out.";
            break;
        case 'signin_success':
                $message = "You have successfully <span class='completed'>signed into</span> your account.";
                break;
        default:
            $message = "Action was successfull.";
        }
        echo Popup(atts: ['popup' => 'success', 'message' => $message]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books | Scrib Library</title>
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
    <link rel="stylesheet" href="Assets/css/reset.css">
    <link rel="stylesheet" href="Assets/css/styles.css">
</head>
<body>

<?php $pagination = new Paginate($books); ?>

<?php
if (isset($_GET['categories'])) {
    if ($_GET['categories'] != '') {
        $filteredBooks = getBooksByCategoryIds(explode(',', $_GET['categories']))['books'];
        $pagination->data = $filteredBooks;
    
        if (count($filteredBooks) > 0 && $_GET['categories'] != '') {
            $pagination->itemsPerPage = count($filteredBooks);
            $pagination->paginateData();
        } else {
            $pagination->paginateData();
        }
    }
}

if (isset($_GET['authors'])) {
    if ($_GET['authors'] != '') {
        $filteredBooks = getBooksByAuthorIds(explode(',', $_GET['authors']))['books'];
        $pagination->data = $filteredBooks;

        if (count($filteredBooks) > 0 && $_GET['authors'] != '') {
            $pagination->itemsPerPage = count($filteredBooks);
            $pagination->paginateData();
        } else {
            $pagination->paginateData();
        }
    }
}

$genre_container = array();
$genre_container[] = ['ID' => '', 'Name' => 'Clear'];
foreach ($genres as $key => $value) {
    $genre_container[] = $value;
}

$author_container = array();
$author_container[] = ['ID' => '', 'Name' => 'Clear'];
foreach ($authors as $key => $value) {
    $author_container[] = $value;
}


if (isset($_GET['q'])) {
    $pagination->data = searchBooks($_GET['q'])['books'];
    if (count(searchBooks($_GET['q'])['books']) > 0 && $_GET['q'] != '') {
        $pagination->itemsPerPage = count(searchBooks($_GET['q'])['books']);
        $pagination->paginateData();
    } else {
        // No Search Results
        $pagination->paginateData();
    }
}
?>


<?php
if (isset($_POST['page'])) {
    $pagination->setPage($_POST['page']);
}

$table = Table(atts: [
    'table' => 'books',
    'rows' => $pagination->getPage()['data']
]);
?>

<div class="container" id="container">
    <?= Navigation(atts: [
    'navigation' => 'default',
    'icon' => $navIcon
    ]);?>

    <div class="search-browse">
        <?= Search(atts: [
            'search' => '',
            'placeholder' => 'Search for a book'
        ]); ?>
        
        <div class="browse">
            <?= Button(atts: ['btnType' => 'viewby']); ?>
            <?= Button(atts: ['btnType' => 'filterby']); ?>
        </div>
    </div>

    <?php
    if (isset($_GET['authors'])) {
        $filters  = $author_container;
        $filtersName = 'authors';
    } else {
        $filters  = $genre_container; 
        $filtersName = 'categories';
    }
        echo Filters(
            atts: 
                [
                'filters' => $filters,
                'name' => $filtersName
                ]
        );
    ?>

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
    <?=
        Pagination(atts: [
            'pagination' => 'list',
            'page' => $pagination->currentPage,
            'group' => $pagination->totalPages
        ]);
    ?>
</div>

<!-- Grid View -->
<div class="cards" id="grid_mode_container" style="display: none;">
    <div class="wrapper">      
        <?php
foreach ($pagination->getPage()['data'] as $item) {
    echo Card(
        atts: $item
    );
}
?>
    </div>
    <?=
        Pagination(atts: [
            'pagination' => 'grid',
            'page' => $pagination->currentPage,
            'group' => $pagination->totalPages
        ]);
    ?>
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
<?php

if (!$pagination->totalItems > 0) {
    echo '<script type="text/javascript">
        document.getElementById("list_mode_container").style.display = "none";
        document.getElementById("grid_mode_container").style.display = "none";

        var noData = document.createElement("h1");
        noData.innerText = "No Books";
        noData.classList.add("no-data");
        document.getElementById("container").appendChild(noData);
        </script>
        ';
}
?>
</body>
<?php
if (isset($_POST['viewType'])) {
    if ($_POST['viewType'] == 'list') {
        echo '
        <script>
            grid_mode_container.style.display = "none";
            list_mode_container.style.display = "block";
        </script>';

    } else if ($_POST['viewType'] == 'grid') {
        echo '
        <script>
            list_mode_container.style.display = "none";
            grid_mode_container.style.display = "grid";
        </script>';
    
    }
    
}
?>
<script defer src="Assets/JS/script.js"></script>
</html>