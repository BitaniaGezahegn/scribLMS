<?php
require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['loggedin'])) {
        session_unset();
        session_destroy();
        header('location: ../../../auth.php?popup=success&message=signout_success');
        exit;
    } else {
        header('location: ../../../auth.php?popup=error&message=signout_error');
        exit;
    }
} else {
    header('location: ../../../auth.php?popup=error&message=unauthorized');
}
?>
