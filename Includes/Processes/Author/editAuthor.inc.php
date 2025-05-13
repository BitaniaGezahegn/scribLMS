<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location: ../../../Authors.php?popup=error&message=unauthorized');
    exit();
}

require_once '../../Data/dbFunctions.inc.php';


$id = $_POST['id'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$biography = $_POST['biography'];


// Sanitize the data
$id = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
$firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
$lastName = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');
$biography = htmlspecialchars($biography, ENT_QUOTES, 'UTF-8');


updateAuthor($id, $firstName, $lastName, $biography);

// Redirect to success page or back to the add author form with a success message.
header('location: ../../../Authors.php?popup=success&message=author_edited');
?>
