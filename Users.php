<!-- Components -->
<?php require_once 'Components/Button.php'; ?>
<?php require_once 'Components/Account.php'; ?>
<?php require_once 'Components/Table.php'; ?>
<?php require_once 'Components/Navigation.php'; ?>
<?php require_once 'Components/Popup.php'; ?>
<?php require_once 'Components/Input.php'; ?>
<?php
require_once 'config.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['roleID'] === 1) {
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
    header('location: index.php?popup=error&message=unauthorized_access_librarian');
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
                $message = "Action not permitted.";
                break;
        case 'unauthorized_access_librarian':
                $message = "Only admins can access the users page.";
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
                $message = "You have successfully <span class='success'>signed into</span> your account.";
                break;
        case 'edit_successfull':
                $message = "You have successfully <span class='success'>Edited</span> <span class='link'>users</span> account.";
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
    <link rel="stylesheet" href="Assets/css/reset.css">
    <link rel="stylesheet" href="Assets/css/styles.css">
    <link rel="stylesheet" href="Assets/css/Users.css">
</head>
<body>
<!-- Includes -->
<?php require_once 'Components/Search.php'; ?>

<?php
$users = getUsers(); // Get all users

if (isset($_GET['q'])) {
    if ($_GET['q'] != '') {
        $users = searchUsers($_GET['q'])['users'];
    }
}
?>



<?php
$table = Table(atts: [
    'table' => 'users',
    'rows' => $users
]);
?>

<div class="container" id="container">

    <?= Navigation(atts: ['navigation' => 'default', 'icon' => $navIcon]); ?>
    <div class="search-browse">
        <?= Search(atts: ['search' => '', 'placeholder' => 'Search for a user']); ?>
    </div>

    <div class="list" id="list_mode_container">
        <table>
            <thead>
                <tr>
                    <?php foreach ($table[0] as $key => $value) {
                        echo $value;
                    } ?>
                </tr>
            </thead>
            <tbody>
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

    <script defer src="Assets/JS/users.js"></script>
    


<?php
 if (isset($_GET['edit'])) {
     $id = $_GET['edit'];
     $data = getUser('', $id)['users'][$id] ?? '';
     $statusID = $data['statusID'] ?? '';
     $roleID = $data['roleID'] ?? '';
     $username = $data['username'] ?? '';
     $firstname = $data['firstName'] ?? '';
     $lastname = $data['lastName'] ?? '';
     $joinedDate = $data['joinedDate'] ?? '';
     
    //  Roles
     $roles = [];
     $getRoles = [
         [
             'ID' => 1,
             'role' => 'Admin',
         ],
         [
             'ID' => 2,
             'role' => 'Librarian'
         ]
     ];

     foreach ($getRoles as $key => $value) {
         $roles[] = [
             'option' => $value['role'],
             'value' => $value['ID']
         ];
     }

    //  Status
    $statuses = [];
    $getStstuses = [
        [
            'ID' => 1,
            'status' => 'Approved'
        ],
        [
            'ID' => 2,
            'status' => 'Unapproved'
        ],
        [
            'ID' => 3,
            'status' => 'Suspended'
        ]
    ];
    
    foreach ($getStstuses as $key => $value) {
        $statuses[] = [
            'option' => $value['status'],
            'value' => $value['ID']
        ];
        }
     

    echo '
    <script defer>
        setTimeout(() => {
            editUserContainer.style.display = "flex";
        }, 1);
    </script>';
 } else {
     echo '
     <script defer>
     setTimeout(() => {
            editUserContainer.style.display = "none";
        }, 1);
    </script>';
 }
 ?>

<!-- Edit Author -->
<div class="content edit-user-container" style="display: none; width: 80%;">
        <div class="quit" id="quitEditUser">
        <span class="material-symbols-outlined">
            close
        </span>
        </div>

        <div class="header">
                <span class="icon material-symbols-outlined" style="color: var(--heading);">
                    border_color
                </span>
                <h2 style="color: var(--heading);">Edit User Details</h2>
        </div>

        <div class="form">
            <form action="Includes/Processes/User/editUser.inc.php" method="POST" id="editUserForm">
                <div class="left-inputs inputs">
                <div>
                    <?= Input(atts:[
                            'input' => 'regular',
                            'label' => 'ID',
                            'placeholder' => 'First Name of the Author',
                            'name' => 'id',
                            'value' => $id
                    ]) ?>
                    <?= Input(atts:[
                            'input' => 'regular',
                            'label' => 'First Name',
                            'placeholder' => 'First Name of the Author',
                            'name' => 'firstname',
                            'value' => $firstname
                    ]) ?>
                <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Joined Date',
                        'placeholder' => 'First Name of the Author',
                        'name' => 'joinedDate',
                        'value' => $joinedDate
                ]) ?>
                <?= Input(atts:[
                    'input' => 'select',
                    'label' => 'Status',
                    'placeholder' => '',
                    'name' => 'status',
                    'options' => $statuses,
                    'selecetdOptions' => $statusID
                ]) ?>
                </div>
                </div>
                <!-- Right Side -->
                <div class="right-inputs inputs">
                <div>
                <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Username',
                        'placeholder' => 'Last Name of the Author',
                        'name' => 'username',
                        'value' => $username
                ]) ?>

                <?= Input(atts:[
                        'input' => 'regular',
                        'label' => 'Last Name',
                        'placeholder' => 'Last Name of the Author',
                        'name' => 'lastname',
                        'value' => $lastname
                ]) ?>
                <?= Input(atts:[
                    'input' => 'select',
                    'label' => 'Role',
                    'placeholder' => '',
                    'name' => 'role',
                    'options' => $roles,
                    'selecetdOptions' => $roleID
                ]) ?>
                </div>

                <button type="submit" class="action-btn">
                    <?=
                    Button(
                        atts: [
                            'btnType' => 'filled',
                            'button' => 'Edit User\'s Details',
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
</div>
</body>
</html>
