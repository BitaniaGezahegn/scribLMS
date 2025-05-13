<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../../../Users.php?popup=error&message=unauthorized');
    exit();
}

require_once '../../Data/dbFunctions.inc.php';


$id = $_POST['id'];
$username = $_POST['username'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$joinedDate = $_POST['joinedDate'];
$role = $_POST['role'];
$status = $_POST['status'];

// Sanitize the data
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
$username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
$firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
$lastName = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');
$joinedDate = htmlspecialchars($joinedDate, ENT_QUOTES, 'UTF-8');
$role = filter_var($role, FILTER_SANITIZE_NUMBER_INT);
$status = filter_var($status, FILTER_SANITIZE_NUMBER_INT);

updateUser($id, $username, $firstName, $lastName, $joinedDate, $status, $role);
header('location: ../../../Users.php?popup=success&message=edit_successfull');