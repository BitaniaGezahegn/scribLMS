<?php
require_once '../../../config.php';
require_once '../../Data/dbFunctions.inc.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input Sanitization and Validation
    $username = htmlspecialchars(trim($_POST['username']));
    $firstName = htmlspecialchars(trim($_POST['firstname']));
    $lastName = htmlspecialchars(trim($_POST['lastname']));
    $password = htmlspecialchars(trim($_POST['password']));
    $roleID = isset($_POST['admin']) ? 1 : 2; // 1 for admin, 2 for user

    // Validate if username already exists
    if (checkUsernameExists($username)) {
        header("Location: ../../../Auth.php?popup=error&message=username_exists");
        exit();
    }

    // Basic Input Validation
    if (empty($username) || empty($firstName) || empty($lastName) || empty($password)) {
        header("Location: ../../../Auth.php?popup=error&message=missing_fields");
        exit();
    }

    // Password Hashing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database Insertion (using parameterized query to prevent SQL injection)
    $newUserDetailID = addUserDetail($username, $firstName, $lastName, $hashedPassword);


    if ($newUserDetailID !== false) {
        $result = addUser($roleID, $newUserDetailID);
        if ($result) {
            header("Location: ../../../Auth.php?popup=success&message=account_creation_success");
        } else {
            header("Location: ../../../Auth.php?popup=error&message=db_error"); //Generic DB error
            //Consider logging the error for debugging purposes.
        }
        exit();
    } else {
        header("Location: ../../../Auth.php?popup=error&message=db_error"); //Generic DB error
        //Consider logging the error for debugging purposes.
        exit();
    }

}
