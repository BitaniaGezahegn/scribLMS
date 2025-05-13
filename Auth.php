<!-- Includes -->
<?php require_once 'Includes/Data/dbFunctions.inc.php' ?>
<?php require_once 'Components/Button.php' ?>
<?php require_once 'Components/Input.php' ?>
<?php require_once 'Components/Popup.php' ?>

<?php
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
        case 'not_approved':
            $message = "Your account is not yet approved.";
            break;
        case 'account_suspended':
            $message = "Your account has been <span class='error'>suspended</span> please contact the adminstrators.";
            break;
        case 'unauthorized':
                $message = "Please login to continue.";
                break;
        case 'username_exists':
            $message = "Username already exists. Please choose a different one.";
            break;
        case 'missing_fields':
            $message = "Please fill in all required fields.";
            break;
        case 'db_error':
            $message = "A database error occurred. Please try again later.";
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
    <title>Auth | Scrib Library</title>
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
    <link rel="stylesheet" href="Assets/CSS/sign_in.css">
</head>
<body>
    <div class="container">
        <div class="sign-in-container" id="sign-in-container">
            <form action="Includes/Processes/User/signin.inc.php" method="POST">
                <div class="header">
                    <h1>Sign in</h1>
                    <img src="Assets/Images/Logo/Logo Main.png" alt="Logo">
                </div>
                <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'Username',
                    'placeholder' => 'Your Username...',
                    'name' => 'username',
                    'focus' => 'autofocus'
                ]) ?>
                <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'Password',
                    'placeholder' => 'Your Password...',
                    'name' => 'password',
                    'type' => 'password'
                ]) ?>
                <button type="submit" class="action-btn">
                    <?=
                        Button(
                            atts: [
                                'btnType' => 'filled',
                                'button' => 'Sign In',
                                'symbol' => 'login',
                                'background' => 'var(--primary)',
                                'color' => 'var(--background)',
                                'url' => '#',
                                'type' => 'div'
                            ]
                        );
                    ?>
                </button>
                <div class="signin-prompt">
                    <p class="sub">Don't have an account? <span class="sub link" id="enableSignup">Sign-up instead</span></p>
                </div>
            </form>
        </div>
            <!-- Sign up container -->
            <div class="sign-up-container" id="sign-up-container">
                <form action="Includes/Processes/User/signup.inc.php" method="POST">
                    <div class="header">
                        <h1>Register</h1>
                        <img src="Assets/Images/Logo/Logo Main.png" alt="Logo">
                    </div>
                    <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'Username',
                    'placeholder' => '(e.g. JohnDoe)',
                    'name' => 'username'
                ]) ?>
                <div class="name-container">
                <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'First Name',
                    'placeholder' => '(e.g. John)',
                    'name' => 'firstname'
                ]) ?>
                <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'Last Name',
                    'placeholder' => '(e.g. Doe)',
                    'name' => 'lastname'
                ]) ?>
                </div>
                <?= Input(atts:[
                    'input' => 'regular',
                    'label' => 'password',
                    'placeholder' => '********',
                    'name' => 'password',
                    'type' => 'password'
                ]) ?>
                <div class="is-admin" id="isAdmin">
                    <input type="checkbox" name="admin" id="adminInput">
                    <label for="admin"><p class="sub">I am a Admin</p></label>
                </div>
                <button type="submit" class="action-btn">
                    <?=
                        Button(
                            atts: [
                                'btnType' => 'filled',
                                'button' => 'Request Account',
                                'symbol' => 'notifications',
                                'background' => 'var(--primary)',
                                'color' => 'var(--background)',
                                'url' => '#',
                                'type' => 'div'
                            ]
                        );
                    ?>
                </button>
                <div class="signin-prompt">
                    <p class="sub">Already have an account? <span class="sub link" id="enableSignin">Sign-in instead</span></p>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="Assets/JS/script.js"></script>
<script src="Assets/JS/auth.js"></script>
</html>