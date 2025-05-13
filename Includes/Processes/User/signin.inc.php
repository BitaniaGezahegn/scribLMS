<?php
require_once '../../../config.php';
require_once '../../Data/dbFunctions.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim(htmlspecialchars($_POST['username'])); // Trim whitespace
        $password = trim(htmlspecialchars($_POST['password'])); // Trim whitespace
        if (strlen(trim($username)) <= 0 && strlen(trim($password)) <= 0) {
        // Handle missing username or password
            header("Location: ../../../Auth.php?popup=error&message=missing_credentials");
            exit();     
        }
    } else {
        // Handle missing username or password
        header("Location: ../../../Auth.php?popup=error&message=missing_credentials");
        exit(); 
    }

    $userdata = getuser($username); // Assuming getuser returns an array with 'users' key

    if ($userdata && isset($userdata['users']) && count($userdata['users']) > 0) {
        $user;
        foreach (getuser($username)['users'] as $key => $value) {
            $user = $value;
            break;
        }

        // Verify password (CORRECTLY using password_verify)
        if (password_verify($password, $user['password'])) {
            // Check if user is approved
            if ($user['statusID'] === 1) {
                // Start session (already started in config.php, but we need to use it)
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $user['id']; // Store user ID
                $_SESSION['username'] = $username; // Store username
                $_SESSION['roleID'] = $user['roleID']; // Store roleID

                // Redirect to the index page after successful login
                header("Location: ../../../index.php?popup=success&message=signin_success"); // Message 0 indicates success
                exit();
            } else if ($user['statusID'] === 2) {
                header("Location: ../../../Auth.php?popup=error&message=not_approved");
                exit();
            } else {
                header("Location: ../../../Auth.php?popup=error&message=account_suspended");
                exit();
            }
        } else {
            header("Location: ../../../Auth.php?popup=error&message=wrong_password");
            exit();
        }
    } else {
        header("Location: ../../../Auth.php?popup=error&message=user_not_found");
        exit();
    }
}